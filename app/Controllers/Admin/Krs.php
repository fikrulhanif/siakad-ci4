<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KrsModel;
use App\Models\DetailKrsModel;
use App\Models\MahasiswaModel;
use App\Models\TahunAkademikModel;

class Krs extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $taModel = new TahunAkademikModel();
        $tahunAkademik = $taModel->findAll();

        // Filter
        $filterTahun = $this->request->getGet('id_tahun');
        $filterStatus = $this->request->getGet('status');
        $filterNim = $this->request->getGet('nim');

        $builder = $this->db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, prodi.nama_prodi, 
                      tahun_akademik.tahun_ajaran, tahun_akademik.semester,
                      (SELECT COUNT(*) FROM detail_krs WHERE id_krs = krs.id_krs) as jumlah_mk,
                      (SELECT SUM(matakuliah.sks) FROM detail_krs 
                       JOIN jadwal ON jadwal.id_jadwal = detail_krs.id_jadwal
                       JOIN matakuliah ON matakuliah.kd_mk = jadwal.kd_mk
                       WHERE detail_krs.id_krs = krs.id_krs) as total_sks')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun');

        if ($filterTahun) {
            $builder->where('krs.id_tahun', $filterTahun);
        }
        if ($filterStatus) {
            $builder->where('krs.status_krs', $filterStatus);
        }
        if ($filterNim) {
            $builder->like('mahasiswa.nim', $filterNim);
        }

        $krs = $builder->orderBy('krs.tgl_krs', 'DESC')->get()->getResultArray();

        $data = [
            'title' => 'Kelola KRS',
            'krs' => $krs,
            'tahunAkademik' => $tahunAkademik,
            'filterTahun' => $filterTahun,
            'filterStatus' => $filterStatus,
            'filterNim' => $filterNim
        ];

        return view('admin/krs/index', $data);
    }

    public function detail($id_krs)
    {
        $krs = $this->db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, mahasiswa.angkatan,
                      prodi.nama_prodi, tahun_akademik.tahun_ajaran, tahun_akademik.semester,
                      dosen.nama_dosen as nama_pa')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->where('krs.id_krs', $id_krs)
            ->get()->getRowArray();

        if (!$krs) {
            return redirect()->to('admin/krs')->with('error', 'Data KRS tidak ditemukan.');
        }

        $detailKrs = $this->db->table('detail_krs')
            ->select('detail_krs.*, matakuliah.nama_mk, matakuliah.kd_mk, matakuliah.sks, 
                      dosen.nama_dosen, jadwal.kelas, jadwal.hari, jadwal.jam, jadwal.jam_selesai, 
                      jadwal.ruang, jadwal.kouta as kapasitas,
                      (SELECT COUNT(*) FROM detail_krs WHERE id_jadwal = jadwal.id_jadwal) as terisi')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->where('id_krs', $id_krs)
            ->orderBy('jadwal.hari', 'ASC')
            ->orderBy('jadwal.jam', 'ASC')
            ->get()->getResultArray();

        // Buat jadwal grid untuk tampilan visual
        $jadwalGrid = [];
        $listJamUnique = [];
        foreach ($detailKrs as $dk) {
            $jamFormat = date('H:i', strtotime($dk['jam'])) . ' - ' . date('H:i', strtotime($dk['jam_selesai']));
            $jadwalGrid[$dk['hari']][$jamFormat] = $dk;
            if (!in_array($jamFormat, $listJamUnique)) {
                $listJamUnique[] = $jamFormat;
            }
        }
        sort($listJamUnique);

        $data = [
            'title' => 'Detail KRS',
            'krs' => $krs,
            'detailKrs' => $detailKrs,
            'jadwalGrid' => $jadwalGrid,
            'listJam' => $listJamUnique,
            'listHari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
        ];

        return view('admin/krs/detail', $data);
    }

    public function create()
    {
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->select('mahasiswa.*, prodi.nama_prodi')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->orderBy('nama_mhs', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Input KRS Manual',
            'mahasiswa' => $mahasiswa,
            'taAktif' => $taAktif
        ];

        return view('admin/krs/create', $data);
    }

    public function pilih_matakuliah()
    {
        $nim = $this->request->getPost('nim');
        $id_tahun = $this->request->getPost('id_tahun');
        $bypassKapasitas = $this->request->getPost('bypass_kapasitas') == '1';

        if (!$nim || !$id_tahun) {
            return redirect()->back()->with('error', 'Pilih mahasiswa dan tahun akademik terlebih dahulu.');
        }

        // Ambil data mahasiswa
        $mhs = $this->db->table('mahasiswa')
            ->select('mahasiswa.*, prodi.nama_prodi, dosen.nama_dosen as nama_pa')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->where('mahasiswa.nim', $nim)
            ->get()->getRowArray();

        if (!$mhs) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        $taAktif = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();
        $idProdiMhs = $mhs['id_prodi'];
        $angkatan = (int)$mhs['angkatan'];
        $tahunSekarang = (int)substr($taAktif['tahun_ajaran'], 0, 4);

        // Hitung semester mahasiswa
        if ($taAktif['semester'] == 'Ganjil') {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 1;
            $filterSmt = [1, 3, 5, 7];
        } else {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 2;
            $filterSmt = [2, 4, 6, 8];
        }

        // Logika pembatasan semester (admin bisa lebih fleksibel)
        $maxSmtBolehDiambil = $semesterMhs + 4; // Admin bisa ambil sampai +4 semester

        // Cek KRS yang sudah ada
        $krsMhs = $this->db->table('krs')->where(['nim' => $nim, 'id_tahun' => $id_tahun])->get()->getRowArray();
        $idJadwalTerambil = [];
        $totalSksTerambil = 0;

        if ($krsMhs) {
            $details = $this->db->table('detail_krs')
                ->select('detail_krs.id_jadwal, matakuliah.sks')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->where('id_krs', $krsMhs['id_krs'])->get()->getResultArray();

            foreach ($details as $dt) {
                $idJadwalTerambil[] = $dt['id_jadwal'];
                $totalSksTerambil += $dt['sks'];
            }
        }

        // Query jadwal
        $builder = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, 
                      COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) as smt,
                      COALESCE(matakuliah_prodi.is_wajib, 1) as is_wajib,
                      dosen.nama_dosen,
                      jadwal.kouta as kapasitas,
                      (SELECT count(*) FROM detail_krs WHERE id_jadwal = jadwal.id_jadwal) as terisi')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$idProdiMhs}", 'left')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->where('jadwal.id_tahun', $id_tahun);

        // Filter prodi
        $builder->where("(
            EXISTS (
                SELECT 1 FROM matakuliah_prodi mp
                WHERE mp.kd_mk = matakuliah.kd_mk
                AND mp.id_prodi = {$idProdiMhs}
            )
            OR NOT EXISTS (
                SELECT 1 FROM matakuliah_prodi mp2
                WHERE mp2.kd_mk = matakuliah.kd_mk
            )
        )", null, false);

        $builder->having('smt IN (' . implode(',', $filterSmt) . ')', null, false);
        $builder->having('smt <=', $maxSmtBolehDiambil);

        if (!empty($idJadwalTerambil)) {
            $builder->whereNotIn('id_jadwal', $idJadwalTerambil);
        }

        $jadwal = $builder->orderBy('matakuliah.smt', 'ASC')->get()->getResultArray();

        $data = [
            'title' => 'Pilih Mata Kuliah untuk ' . $mhs['nama_mhs'],
            'jadwal' => $jadwal,
            'mhs' => $mhs,
            'taAktif' => $taAktif,
            'semesterMhs' => $semesterMhs,
            'totalSksTerambil' => $totalSksTerambil,
            'maxSks' => 30, // Admin bisa sampai 30 SKS
            'bypassKapasitas' => $bypassKapasitas,
            'krsMhs' => $krsMhs
        ];

        return view('admin/krs/pilih_matakuliah', $data);
    }

    public function store()
    {
        $nim = $this->request->getPost('nim');
        $id_tahun = $this->request->getPost('id_tahun');
        $id_jadwal_dipilih = $this->request->getPost('id_jadwal');
        $bypassKapasitas = $this->request->getPost('bypass_kapasitas') == '1';
        $bypassBentrok = $this->request->getPost('bypass_bentrok') == '1';

        if (empty($id_jadwal_dipilih)) {
            return redirect()->back()->with('error', 'Pilih minimal satu mata kuliah!');
        }

        // Cek KRS yang sudah ada
        $krs = $this->db->table('krs')->where(['nim' => $nim, 'id_tahun' => $id_tahun])->get()->getRowArray();

        // Ambil jadwal yang sudah ada
        $jadwalEksis = [];
        $sksLama = 0;
        if ($krs) {
            $jadwalEksis = $this->db->table('detail_krs')
                ->select('jadwal.hari, jadwal.jam, jadwal.jam_selesai, matakuliah.nama_mk, matakuliah.sks')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->where('id_krs', $krs['id_krs'])->get()->getResultArray();

            foreach ($jadwalEksis as $je) {
                $sksLama += $je['sks'];
            }
        }

        // Ambil jadwal baru yang dipilih
        $jadwalBaru = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->whereIn('id_jadwal', $id_jadwal_dipilih)->get()->getResultArray();

        $sksBaru = 0;

        // Validasi bentrok (kecuali bypass)
        if (!$bypassBentrok) {
            foreach ($jadwalBaru as $jb) {
                // Cek bentrok dengan jadwal yang sudah ada
                foreach ($jadwalEksis as $je) {
                    if ($jb['hari'] == $je['hari']) {
                        if ($jb['jam'] < $je['jam_selesai'] && $jb['jam_selesai'] > $je['jam']) {
                            return redirect()->back()->with('error', "<b>BENTROK WAKTU!</b><br>Matakuliah <b>{$jb['nama_mk']}</b> bentrok dengan <b>{$je['nama_mk']}</b>. Centang 'Bypass Bentrok' jika ingin tetap input.");
                        }
                    }
                }
                $sksBaru += $jb['sks'];
            }

            // Cek bentrok sesama pilihan baru
            for ($i = 0; $i < count($jadwalBaru); $i++) {
                for ($j = $i + 1; $j < count($jadwalBaru); $j++) {
                    $b1 = $jadwalBaru[$i];
                    $b2 = $jadwalBaru[$j];
                    if ($b1['hari'] == $b2['hari']) {
                        if ($b1['jam'] < $b2['jam_selesai'] && $b1['jam_selesai'] > $b2['jam']) {
                            return redirect()->back()->with('error', "Gagal! Dua matakuliah yang dipilih saling bentrok: <b>{$b1['nama_mk']}</b> dan <b>{$b2['nama_mk']}</b>.");
                        }
                    }
                }
            }
        } else {
            foreach ($jadwalBaru as $jb) {
                $sksBaru += $jb['sks'];
            }
        }

        // Validasi kapasitas (kecuali bypass)
        if (!$bypassKapasitas) {
            foreach ($jadwalBaru as $jb) {
                $terisi = $this->db->table('detail_krs')->where('id_jadwal', $jb['id_jadwal'])->countAllResults();
                if ($terisi >= $jb['kouta']) {
                    return redirect()->back()->with('error', "Kapasitas kelas <b>{$jb['nama_mk']}</b> sudah penuh ({$terisi}/{$jb['kouta']}). Centang 'Bypass Kapasitas' jika ingin tetap input.");
                }
            }
        }

        // Validasi maksimal SKS (30 untuk admin)
        if (($sksLama + $sksBaru) > 30) {
            return redirect()->back()->with('error', "Total SKS melebihi batas 30 SKS! (Sudah ambil: $sksLama, Baru: $sksBaru)");
        }

        // Proses simpan
        $this->db->transStart();
        if (!$krs) {
            $this->db->table('krs')->insert([
                'nim' => $nim,
                'id_tahun' => $id_tahun,
                'tgl_krs' => date('Y-m-d'),
                'status_krs' => 'Pending'
            ]);
            $id_krs = $this->db->insertID();
        } else {
            $id_krs = $krs['id_krs'];
        }

        foreach ($id_jadwal_dipilih as $id_j) {
            $this->db->table('detail_krs')->insert(['id_krs' => $id_krs, 'id_jadwal' => $id_j]);
        }
        $this->db->transComplete();

        $bypassMsg = [];
        if ($bypassKapasitas) {
            $bypassMsg[] = 'bypass kapasitas';
        }
        if ($bypassBentrok) {
            $bypassMsg[] = 'bypass bentrok';
        }
        $msg = 'Mata kuliah berhasil ditambahkan ke KRS';
        if (!empty($bypassMsg)) {
            $msg .= ' dengan ' . implode(' dan ', $bypassMsg);
        }

        return redirect()->to('admin/krs/detail/' . $id_krs)->with('success', $msg . '.');
    }

    public function delete_item($id_detail)
    {
        $detail = $this->db->table('detail_krs')->where('id_detail', $id_detail)->get()->getRowArray();

        if (!$detail) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $id_krs = $detail['id_krs'];
        $this->db->table('detail_krs')->where('id_detail', $id_detail)->delete();

        return redirect()->to('admin/krs/detail/' . $id_krs)->with('success', 'Mata kuliah berhasil dihapus dari KRS.');
    }

    public function update_status($id_krs)
    {
        $status = $this->request->getPost('status_krs');
        $catatan = $this->request->getPost('catatan_pa');

        $this->db->table('krs')->where('id_krs', $id_krs)->update([
            'status_krs' => $status,
            'catatan_pa' => $catatan
        ]);

        return redirect()->to('admin/krs/detail/' . $id_krs)->with('success', 'Status KRS berhasil diupdate.');
    }

    public function delete($id_krs)
    {
        // Hapus detail KRS terlebih dahulu
        $this->db->table('detail_krs')->where('id_krs', $id_krs)->delete();

        // Hapus KRS
        $this->db->table('krs')->where('id_krs', $id_krs)->delete();

        return redirect()->to('admin/krs')->with('success', 'Data KRS berhasil dihapus.');
    }
}
