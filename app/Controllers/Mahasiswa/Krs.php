<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\KrsModel;
use App\Models\DetailKrsModel;
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
        $nim = session()->get('nim');
        $taModel = new \App\Models\TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        if (!$taAktif) {
            return "Tahun akademik aktif tidak ditemukan.";
        }

        $mhs = $this->db->table('mahasiswa')
            ->select('mahasiswa.*, dosen.nama_dosen as nama_pa, prodi.nama_prodi')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('mahasiswa.nim', $nim)->get()->getRowArray();

        $krs = $this->db->table('krs')->where(['nim' => $nim, 'id_tahun' => $taAktif['id_tahun']])->get()->getRowArray();

        $detailKrs = [];
        $jadwalGrid = [];
        $listJamUnique = []; // Untuk menampung jam apa saja yang ada di KRS

        if ($krs) {
            $detailKrs = $this->db->table('detail_krs')
                ->select('detail_krs.*, matakuliah.nama_mk, matakuliah.kd_mk, matakuliah.sks, dosen.nama_dosen, jadwal.kelas, jadwal.hari, jadwal.jam, jadwal.jam_selesai, jadwal.ruang')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('dosen', 'dosen.nidn = jadwal.nidn')
                ->where('id_krs', $krs['id_krs'])
                ->orderBy('jadwal.jam', 'ASC')
                ->get()->getResultArray();

            foreach ($detailKrs as $dk) {
                $jamFormat = date('H:i', strtotime($dk['jam'])) . ' - ' . date('H:i', strtotime($dk['jam_selesai']));
                $jadwalGrid[$dk['hari']][$jamFormat] = $dk;

                if (!in_array($jamFormat, $listJamUnique)) {
                    $listJamUnique[] = $jamFormat;
                }
            }
            sort($listJamUnique); // Urutkan jam dari yang paling pagi
        }

        $data = [
            'title'      => 'KRS Mahasiswa',
            'taAktif'    => $taAktif,
            'mhs'        => $mhs,
            'krs_aktif'  => $krs,
            'detailKrs'  => $detailKrs,
            'jadwalGrid' => $jadwalGrid,
            'listJam'    => $listJamUnique,
            'listHari'   => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
        ];

        return view('mahasiswa/krs/index', $data);
    }

    public function create()
    {
        $nim = session()->get('nim');
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        // Ambil data mahasiswa termasuk ID Prodi-nya
        $mhs = $this->db->table('mahasiswa')->where('nim', $nim)->get()->getRowArray();
        $idProdiMhs = $mhs['id_prodi']; // ID Prodi mahasiswa yang login
        $angkatan = (int)$mhs['angkatan'];
        $tahunSekarang = (int)substr($taAktif['tahun_ajaran'], 0, 4);

        // 1. Hitung Semester Mahasiswa saat ini
        if ($taAktif['semester'] == 'Ganjil') {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 1;
            $filterSmt = [1, 3, 5, 7];
        } else {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 2;
            $filterSmt = [2, 4, 6, 8];
        }

        // 2. Logika Pembatasan Semester
        if ($semesterMhs <= 2) {
            $maxSmtBolehDiambil = $semesterMhs;
        } else {
            $maxSmtBolehDiambil = $semesterMhs + 2;
        }

        // 3. Ambil ID Jadwal yang sudah ada di Keranjang
        $krsMhs = $this->db->table('krs')->where(['nim' => $nim, 'id_tahun' => $taAktif['id_tahun']])->get()->getRowArray();
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

        // 4. Bangun Query Jadwal (IMPLEMENTASI PIVOT TABLE)
        $builder = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, 
                      COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) as smt,
                      COALESCE(matakuliah_prodi.is_wajib, 1) as is_wajib,
                      dosen.nama_dosen,
                      (SELECT count(*) FROM detail_krs WHERE id_jadwal = jadwal.id_jadwal) as terisi')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$idProdiMhs}", 'left')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->where('jadwal.id_tahun', $taAktif['id_tahun']);

        // --- LOGIKA FILTER PRODI MENGGUNAKAN PIVOT TABLE ---
        // Tampilkan mata kuliah yang:
        // 1. Ada di matakuliah_prodi untuk prodi mahasiswa ini, ATAU
        // 2. Tidak ada di matakuliah_prodi sama sekali (mata kuliah umum)
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

        // Filter semester berdasarkan semester di pivot table (atau fallback ke matakuliah.smt)
        $builder->having('smt IN (' . implode(',', $filterSmt) . ')', null, false);
        $builder->having('smt <=', $maxSmtBolehDiambil);
        // ----------------------------------------

        if (!empty($idJadwalTerambil)) {
            $builder->whereNotIn('id_jadwal', $idJadwalTerambil);
        }

        $jadwal = $builder->orderBy('matakuliah.smt', 'ASC')->get()->getResultArray();

        $data = [
            'title'            => 'Pilih Mata Kuliah',
            'jadwal'           => $jadwal,
            'taAktif'          => $taAktif,
            'semesterMhs'      => $semesterMhs,
            'totalSksTerambil' => $totalSksTerambil,
            'maxSks'           => 24
        ];

        return view('mahasiswa/krs/create', $data);
    }

    public function store()
    {
        $nim = session()->get('nim');
        $id_jadwal_dipilih = $this->request->getPost('id_jadwal');
        $id_tahun = $this->request->getPost('id_tahun');

        if (empty($id_jadwal_dipilih)) {
            return redirect()->back()->with('error', 'Pilih minimal satu mata kuliah!');
        }

        // 1. Cek Status KRS (Jika sudah Approve tidak boleh tambah)
        $krs = $this->db->table('krs')->where(['nim' => $nim, 'id_tahun' => $id_tahun])->get()->getRowArray();
        if ($krs && $krs['status_krs'] == 'Approved') {
            return redirect()->to('mahasiswa/krs')->with('error', 'KRS sudah disetujui, tidak bisa menambah matakuliah.');
        }

        // 2. Ambil data jadwal yang SUDAH ada di keranjang (untuk cek bentrok & total SKS)
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

        // 3. Ambil data jadwal yang BARU dipilih
        $jadwalBaru = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->whereIn('id_jadwal', $id_jadwal_dipilih)->get()->getResultArray();

        $sksBaru = 0;
        foreach ($jadwalBaru as $jb) {
            // VALIDASI BENTROK: Cek jadwal baru terhadap jadwal yang sudah ada di keranjang
            foreach ($jadwalEksis as $je) {
                if ($jb['hari'] == $je['hari']) {
                    if ($jb['jam'] < $je['jam_selesai'] && $jb['jam_selesai'] > $je['jam']) {
                        return redirect()->back()->with('error', "<b>BENTROK WAKTU!</b><br>Matakuliah <b>{$jb['nama_mk']}</b> (" . date('H:i', strtotime($jb['jam'])) . "-" . date('H:i', strtotime($jb['jam_selesai'])) . ") beririsan dengan matakuliah <b>{$je['nama_mk']}</b> yang sudah ada di KRS Anda.");
                    }
                }
            }
            $sksBaru += $jb['sks'];
        }

        // VALIDASI BENTROK SESAMA PILIHAN BARU (Jika pilih > 1 sekaligus)
        for ($i = 0; $i < count($jadwalBaru); $i++) {
            for ($j = $i + 1; $j < count($jadwalBaru); $j++) {
                $b1 = $jadwalBaru[$i];
                $b2 = $jadwalBaru[$j];
                if ($b1['hari'] == $b2['hari']) {
                    if ($b1['jam'] < $b2['jam_selesai'] && $b1['jam_selesai'] > $b2['jam']) {
                        return redirect()->back()->with('error', "Gagal! Dua matakuliah yang Anda pilih saling bentrok: <b>{$b1['nama_mk']}</b> dan <b>{$b2['nama_mk']}</b>.");
                    }
                }
            }
        }

        // 4. Validasi Maksimal SKS
        if (($sksLama + $sksBaru) > 24) {
            return redirect()->back()->with('error', "Total SKS melebihi batas 24 SKS! (Sudah ambil: $sksLama, Baru: $sksBaru)");
        }

        // 5. PROSES SIMPAN
        $this->db->transStart();
        if (!$krs) {
            $this->db->table('krs')->insert([
                'nim' => $nim, 'id_tahun' => $id_tahun, 'tgl_krs' => date('Y-m-d'), 'status_krs' => 'Pending'
            ]);
            $id_krs = $this->db->insertID();
        } else {
            $id_krs = $krs['id_krs'];
        }

        foreach ($id_jadwal_dipilih as $id_j) {
            $this->db->table('detail_krs')->insert(['id_krs' => $id_krs, 'id_jadwal' => $id_j]);
        }
        $this->db->transComplete();

        return redirect()->to('mahasiswa/krs')->with('success', 'Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function delete_item($id_detail)
    {
        $nim = session()->get('nim');
        $detail = $this->db->table('detail_krs')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->where('id_detail', $id_detail)
            ->where('nim', $nim)
            ->get()->getRowArray();

        if (!$detail) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        if ($detail['status_krs'] == 'Approved') {
            return redirect()->back()->with('error', 'Gagal! KRS sudah disetujui Dosen PA.');
        }

        $this->db->table('detail_krs')->where('id_detail', $id_detail)->delete();
        return redirect()->back()->with('success', 'Mata kuliah berhasil dihapus dari draf.');
    }

    public function resubmit($id_krs)
    {
        $nim = session()->get('nim');

        // Cek apakah KRS milik mahasiswa ini
        $krs = $this->db->table('krs')
            ->where('id_krs', $id_krs)
            ->where('nim', $nim)
            ->get()->getRowArray();

        if (!$krs) {
            return redirect()->back()->with('error', 'KRS tidak ditemukan.');
        }

        // Cek apakah KRS dalam status Rejected
        if ($krs['status_krs'] != 'Rejected') {
            return redirect()->back()->with('error', 'KRS tidak dalam status ditolak.');
        }

        // Update status kembali ke Pending dan hapus catatan lama
        $this->db->table('krs')->where('id_krs', $id_krs)->update([
            'status_krs' => 'Pending',
            'catatan_pa' => null
        ]);

        return redirect()->to('mahasiswa/krs')->with('success', 'KRS berhasil diajukan ulang ke Dosen PA. Silakan tunggu persetujuan.');
    }
}
