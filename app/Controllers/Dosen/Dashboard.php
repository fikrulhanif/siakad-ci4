<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $nidn = session()->get('nidn');
        $db = \Config\Database::connect();

        $id_user = session()->get('id_user');
        $dsn = $this->db->table('dosen')->where('id_user', $id_user)->get()->getRowArray();

        $is_lengkap = true;
        if (empty($dsn['nik']) || empty($dsn['no_hp']) || empty($dsn['email']) || empty($dsn['jenkel'])) {
            $is_lengkap = false;
        }


        $taAktif = $db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // 2. Statistik Ringkas
        $jmlBimbingan = $db->table('mahasiswa')->where('nidn_wali', $nidn)->countAllResults();
        $jmlMatkul = $db->table('jadwal')->where('nidn', $nidn)->where('id_tahun', $taAktif['id_tahun'])->countAllResults();

        // Hitung KRS yang butuh ACC
        $pendingKrs = $db->table('krs')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->where('mahasiswa.nidn_wali', $nidn)
            ->where('krs.status_krs', 'Pending')
            ->countAllResults();

        // Statistik Mahasiswa Bimbingan
        $mhsBimbingan = $db->table('mahasiswa')
            ->select('mahasiswa.nim, mahasiswa.angkatan')
            ->where('nidn_wali', $nidn)
            ->get()->getResultArray();

        $mhsIPKRendah = 0; // IPK < 2.5
        $mhsIPKBaik = 0; // IPK >= 2.5 && < 3.5
        $mhsIPKSangatBaik = 0; // IPK >= 3.5

        foreach ($mhsBimbingan as $m) {
            // Hitung IPK
            $allNilai = $db->table('detail_krs')
                ->select('matakuliah.sks, nilai.nilai_huruf')
                ->join('krs', 'krs.id_krs = detail_krs.id_krs')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
                ->where('krs.nim', $m['nim'])
                ->where('nilai.nilai_huruf IS NOT NULL')
                ->get()->getResultArray();

            $totalPoin = 0;
            $totalSks = 0;
            foreach ($allNilai as $n) {
                $bobot = $this->_getBobot($n['nilai_huruf']);
                $totalPoin += ($bobot * (int)$n['sks']);
                $totalSks += (int)$n['sks'];
            }

            $ipk = ($totalSks > 0) ? $totalPoin / $totalSks : 0;

            if ($ipk < 2.5) {
                $mhsIPKRendah++;
            } elseif ($ipk < 3.5) {
                $mhsIPKBaik++;
            } else {
                $mhsIPKSangatBaik++;
            }
        }

        // 3. Jadwal Mengajar
        $jadwal = $db->table('jadwal')
        ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt,
              (SELECT count(*) FROM detail_krs WHERE id_jadwal = jadwal.id_jadwal) as jml_mhs')
        ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
        ->where('jadwal.nidn', $nidn)
        ->where('jadwal.id_tahun', $taAktif['id_tahun'])
        ->get()->getResultArray();

        // Sort jadwal by hari dan jam
        $urutanHari = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
        usort($jadwal, function ($a, $b) use ($urutanHari) {
            $hariA = $urutanHari[$a['hari']] ?? 99;
            $hariB = $urutanHari[$b['hari']] ?? 99;
            if ($hariA != $hariB) {
                return $hariA - $hariB;
            }
            return strcmp($a['jam'], $b['jam']);
        });

        // Olah data untuk Grid
        $jadwalGrid = [];
        $listJamUnique = [];
        foreach ($jadwal as $j) {
            $jamMulai = date('H:i', strtotime($j['jam']));
            $jamSelesai = date('H:i', strtotime($j['jam_selesai']));
            $labelWaktu = $jamMulai . ' - ' . $jamSelesai;

            $jadwalGrid[$j['hari']][$labelWaktu] = $j;

            if (!in_array($labelWaktu, $listJamUnique)) {
                $listJamUnique[] = $labelWaktu;
            }
        }
        sort($listJamUnique);

        $data = [
            'title'        => 'Dashboard Dosen',
            'is_lengkap' => $is_lengkap,
            'taAktif'      => $taAktif,
            'jmlBimbingan' => $jmlBimbingan,
            'jmlMatkul'    => $jmlMatkul,
            'pendingKrs'   => $pendingKrs,
            'jadwal'       => $jadwal,
            'jadwalGrid'   => $jadwalGrid,
            'listJam'      => $listJamUnique,
            'listHari'     => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            'mhsIPKRendah' => $mhsIPKRendah,
            'mhsIPKBaik'   => $mhsIPKBaik,
            'mhsIPKSangatBaik' => $mhsIPKSangatBaik
        ];

        return view('dosen/dashboard', $data);
    }

    public function bimbingan()
    {
        $nidn = session()->get('nidn');
        $db = \Config\Database::connect();
        $taAktif = $db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // Ambil data mahasiswa yang nidn_wali nya adalah dosen yang sedang login
        $mhsList = $db->table('mahasiswa')
            ->select('mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->where('nidn_wali', $nidn)
            ->orderBy('mahasiswa.angkatan', 'DESC')
            ->orderBy('mahasiswa.nim', 'ASC')
            ->get()->getResultArray();

        // Hitung info akademik untuk setiap mahasiswa
        $mhs = [];
        foreach ($mhsList as $m) {
            // Hitung IPK dan Total SKS
            $allNilai = $db->table('detail_krs')
                ->select('matakuliah.sks, nilai.nilai_huruf')
                ->join('krs', 'krs.id_krs = detail_krs.id_krs')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
                ->where('krs.nim', $m['nim'])
                ->where('nilai.nilai_huruf IS NOT NULL')
                ->get()->getResultArray();

            $totalPoin = 0;
            $totalSks = 0;
            foreach ($allNilai as $n) {
                $bobot = $this->_getBobot($n['nilai_huruf']);
                $totalPoin += ($bobot * (int)$n['sks']);
                $totalSks += (int)$n['sks'];
            }

            $ipk = ($totalSks > 0) ? number_format($totalPoin / $totalSks, 2) : '0.00';

            // Hitung semester mahasiswa
            $angkatan = (int)$m['angkatan'];
            $tahunSekarang = (int)substr($taAktif['tahun_ajaran'], 0, 4);
            if ($taAktif['semester'] == 'Ganjil') {
                $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 1;
            } else {
                $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 2;
            }

            // Hitung jumlah KRS yang pending
            $pendingKrs = $db->table('krs')
                ->where('nim', $m['nim'])
                ->where('id_tahun', $taAktif['id_tahun'])
                ->where('status_krs', 'Pending')
                ->countAllResults();

            $mhs[] = [
                'nim' => $m['nim'],
                'nama_mhs' => $m['nama_mhs'],
                'angkatan' => $m['angkatan'],
                'nama_prodi' => $m['nama_prodi'],
                'ipk' => $ipk,
                'total_sks' => $totalSks,
                'semester' => $semesterMhs,
                'pending_krs' => $pendingKrs
            ];
        }

        // Group by angkatan
        $mhsByAngkatan = [];
        foreach ($mhs as $m) {
            $mhsByAngkatan[$m['angkatan']][] = $m;
        }
        krsort($mhsByAngkatan); // Sort descending

        $data = [
            'title' => 'Mahasiswa Bimbingan Akademik',
            'mhs'   => $mhs,
            'mhsByAngkatan' => $mhsByAngkatan,
            'taAktif' => $taAktif
        ];

        return view('dosen/bimbingan', $data);
    }

    public function detail_nilai($nim)
    {
        $db = \Config\Database::connect();

        // Ambil data profil mahasiswa
        $mhs = $db->table('mahasiswa')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->where('nim', $nim)->get()->getRowArray();

        // Ambil riwayat nilai per semester
        $riwayat = $db->table('krs')
            ->select('krs.id_krs, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.nim', $nim)
            ->where('krs.status_krs', 'Approved')
            ->orderBy('tahun_akademik.id_tahun', 'ASC')
            ->get()->getResultArray();

        $dataNilai = [];
        $totalPoinIPK = 0;
        $totalSksIPK = 0;

        foreach ($riwayat as $r) {
            $detail = $db->table('detail_krs')
                ->select('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, nilai.nilai_huruf, nilai.nilai_angka')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
                ->where('id_krs', $r['id_krs'])
                ->get()->getResultArray();

            // Hitung IP semester ini
            $totalPoinSemester = 0;
            $totalSksSemester = 0;
            foreach ($detail as $d) {
                if ($d['nilai_huruf']) {
                    $bobot = $this->_getBobot($d['nilai_huruf']);
                    $sks = (int)$d['sks'];
                    $totalPoinSemester += ($bobot * $sks);
                    $totalSksSemester += $sks;
                    $totalPoinIPK += ($bobot * $sks);
                    $totalSksIPK += $sks;
                }
            }

            $ipSemester = ($totalSksSemester > 0) ? number_format($totalPoinSemester / $totalSksSemester, 2) : '0.00';

            $dataNilai[] = [
                'semester' => $r['tahun_ajaran'] . ' - ' . $r['semester'],
                'detail'   => $detail,
                'ip'       => $ipSemester,
                'total_sks' => $totalSksSemester,
                'total_bobot' => $totalPoinSemester
            ];
        }

        $ipk = ($totalSksIPK > 0) ? number_format($totalPoinIPK / $totalSksIPK, 2) : '0.00';

        $data = [
            'title' => 'Riwayat Nilai Mahasiswa',
            'mhs'   => $mhs,
            'nilai' => $dataNilai,
            'ipk'   => $ipk,
            'totalSks' => $totalSksIPK
        ];

        return view('dosen/bimbingan_nilai', $data);
    }

    public function persetujuanKrs()
    {
        $nidn = session()->get('nidn');
        $db = \Config\Database::connect();
        $taAktif = $db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // Ambil daftar KRS mahasiswa bimbingan
        $krsMahasiswa = $db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, mahasiswa.angkatan, prodi.nama_prodi')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->where('mahasiswa.nidn_wali', $nidn)
            ->where('krs.id_tahun', $taAktif['id_tahun'])
            ->get()->getResultArray();

        // Kita ambil juga detail matkul untuk semua KRS tersebut agar bisa ditampilkan di Modal
        $detailKrs = [];
        $ipMahasiswa = [];

        foreach ($krsMahasiswa as $k) {
            // Detail mata kuliah
            $detailKrs[$k['id_krs']] = $db->table('detail_krs')
                ->select('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, jadwal.kelas')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->where('id_krs', $k['id_krs'])
                ->get()->getResultArray();

            // Hitung IP Semester Lalu & IPK
            $allNilai = $db->table('detail_krs')
                ->select('matakuliah.sks, nilai.nilai_huruf, tahun_akademik.id_tahun')
                ->join('krs', 'krs.id_krs = detail_krs.id_krs')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
                ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
                ->where('krs.nim', $k['nim'])
                ->where('nilai.nilai_huruf IS NOT NULL')
                ->orderBy('tahun_akademik.id_tahun', 'DESC')
                ->get()->getResultArray();

            $totalPoinIPK = 0;
            $sksHitungIPK = 0;
            $ipsSemesterLalu = 0;
            $sksSemesterLalu = 0;
            $poinSemesterLalu = 0;
            $idTahunLalu = null;

            foreach ($allNilai as $idx => $n) {
                $bobot = $this->_getBobot($n['nilai_huruf']);
                $totalPoinIPK += ($bobot * (int)$n['sks']);
                $sksHitungIPK += (int)$n['sks'];

                // IPS semester lalu (semester terakhir yang ada nilainya)
                if ($idx == 0) {
                    $idTahunLalu = $n['id_tahun'];
                }
                if ($n['id_tahun'] == $idTahunLalu) {
                    $poinSemesterLalu += ($bobot * (int)$n['sks']);
                    $sksSemesterLalu += (int)$n['sks'];
                }
            }

            $ipk = ($sksHitungIPK > 0) ? number_format($totalPoinIPK / $sksHitungIPK, 2) : '0.00';
            $ipsSemesterLalu = ($sksSemesterLalu > 0) ? number_format($poinSemesterLalu / $sksSemesterLalu, 2) : '0.00';

            // Hitung semester mahasiswa
            $angkatan = (int)$k['angkatan'];
            $tahunSekarang = (int)substr($taAktif['tahun_ajaran'], 0, 4);
            if ($taAktif['semester'] == 'Ganjil') {
                $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 1;
            } else {
                $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 2;
            }

            $ipMahasiswa[$k['id_krs']] = [
                'ipk' => $ipk,
                'ips_lalu' => $ipsSemesterLalu,
                'semester' => $semesterMhs,
                'total_sks' => $sksHitungIPK
            ];
        }

        $data = [
            'title'        => 'Persetujuan KRS Mahasiswa',
            'krs'          => $krsMahasiswa,
            'detailKrs'    => $detailKrs,
            'ipMahasiswa'  => $ipMahasiswa,
            'ta'           => $taAktif
        ];

        return view('dosen/persetujuan_krs', $data);
    }

    private function _getBobot($huruf)
    {
        return match ($huruf) {
            'A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0, default => 0,
        };
    }

    public function accKrs($id_krs)
    {
        $db = \Config\Database::connect();
        $db->table('krs')->where('id_krs', $id_krs)->update(['status_krs' => 'Approved']);

        return redirect()->back()->with('success', 'KRS Mahasiswa berhasil disetujui!');
    }

    public function rejectKrs($id_krs)
    {
        $catatan = $this->request->getPost('catatan_pa');

        if (empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan penolakan harus diisi!');
        }

        $db = \Config\Database::connect();
        $db->table('krs')->where('id_krs', $id_krs)->update([
            'status_krs' => 'Rejected',
            'catatan_pa' => $catatan
        ]);

        return redirect()->back()->with('success', 'KRS berhasil ditolak dengan catatan.');
    }

    public function print_absensi($id_jadwal)
    {
        $db = \Config\Database::connect();

        // Ambil data jadwal lengkap dengan nama dosen dan TA
        $jadwal = $db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, dosen.nama_dosen, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
            ->where('jadwal.id_jadwal', $id_jadwal)
            ->get()->getRowArray();

        // Ambil list mahasiswa yang mengambil jadwal tersebut
        $peserta = $db->table('detail_krs')
            ->select('mahasiswa.nim, mahasiswa.nama_mhs')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->where('detail_krs.id_jadwal', $id_jadwal)
            ->where('krs.status_krs', 'Approved') // Hanya yang sudah di-ACC
            ->orderBy('mahasiswa.nim', 'ASC')
            ->get()->getResultArray();

        $data = [
            'j' => $jadwal,
            'peserta' => $peserta
        ];

        return view('dosen/print_absensi', $data);
    }

    public function detail_matakuliah($id_jadwal)
    {
        $db = \Config\Database::connect();

        // 1. Ambil info jadwal & matakuliah
        $jadwal = $db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
            ->where('id_jadwal', $id_jadwal)
            ->get()->getRowArray();

        // 2. Ambil daftar mahasiswa yang mengambil (hanya yang sudah Approved)
        $peserta = $db->table('detail_krs')
            ->select('mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->where('detail_krs.id_jadwal', $id_jadwal)
            ->where('krs.status_krs', 'Approved')
            ->orderBy('mahasiswa.nim', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'   => 'Detail Peserta Mata Kuliah',
            'j'       => $jadwal,
            'peserta' => $peserta
        ];

        return view('dosen/detail_matakuliah', $data);
    }

    public function matakuliah_diampu()
    {
        $nidn = session()->get('nidn');
        $db = \Config\Database::connect();

        // Ambil Tahun Akademik Aktif
        $taAktif = $db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // Ambil Daftar Matakuliah yang diampu
        $jadwal = $db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt,
                 (SELECT count(*) FROM detail_krs 
                  JOIN krs ON krs.id_krs = detail_krs.id_krs 
                  WHERE id_jadwal = jadwal.id_jadwal AND krs.status_krs = "Approved") as jml_mhs')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->where('jadwal.nidn', $nidn)
            ->where('jadwal.id_tahun', $taAktif['id_tahun'])
            ->orderBy('matakuliah.smt', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'   => 'Mata Kuliah Diampu',
            'taAktif' => $taAktif,
            'jadwal'  => $jadwal
        ];

        return view('dosen/matakuliah_diampu', $data);
    }
}
