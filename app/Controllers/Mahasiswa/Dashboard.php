<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $nim = session()->get('nim');
        $db = \Config\Database::connect();


        $id_user = session()->get('id_user');
        // Ambil data profil untuk cek kelengkapan
        $mhs = $this->db->table('mahasiswa')
            ->select('mahasiswa.*, prodi.nama_prodi')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('mahasiswa.id_user', $id_user)
            ->get()->getRowArray();

        // Cek field wajib (NIK, No HP, Email, Jenkel)
        $is_lengkap = true;
        if (empty($mhs['nik']) || empty($mhs['no_hp']) || empty($mhs['email']) || empty($mhs['jenkel'])) {
            $is_lengkap = false;
        }

        // 1. Data Tahun Akademik Aktif
        $taAktif = $db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // Hitung semester mahasiswa saat ini
        $angkatan = (int)$mhs['angkatan'];
        $tahunSekarang = (int)substr($taAktif['tahun_ajaran'], 0, 4);

        if ($taAktif['semester'] == 'Ganjil') {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 1;
        } else {
            $semesterMhs = ($tahunSekarang - $angkatan) * 2 + 2;
        }

        // 2. Hitung SKS Lulus & IPK (Hanya yang SUDAH ADA NILAI)
        $allNilai = $db->table('detail_krs')
            ->select('matakuliah.sks, nilai.nilai_huruf')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
            ->where('krs.nim', $nim)
            ->where('nilai.nilai_huruf IS NOT NULL') // Logika: Hanya yang sudah dinilai
            ->get()->getResultArray();

        $totalSksLulus = 0;
        $totalPoinIPK = 0;
        $sksHitungIPK = 0;

        foreach ($allNilai as $n) {
            $bobot = $this->_getBobot($n['nilai_huruf']);

            // SKS Lulus: Nilai minimal D (bobot > 0)
            if ($bobot > 0) {
                $totalSksLulus += (int)$n['sks'];
            }

            // IPK tetap menghitung nilai E (bobot 0) sebagai pembagi,
            // tapi hanya jika sudah ada nilai hurufnya.
            $totalPoinIPK += ($bobot * (int)$n['sks']);
            $sksHitungIPK += (int)$n['sks'];
        }

        $ipk = ($sksHitungIPK > 0) ? number_format($totalPoinIPK / $sksHitungIPK, 2) : '0.00';

        // 3. Logika Grafik: Ambil IPS per Semester
        $grafikData = $db->table('krs')
            ->select('tahun_akademik.tahun_ajaran, tahun_akademik.semester, krs.id_krs')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.nim', $nim)
            ->orderBy('tahun_akademik.id_tahun', 'ASC')
            ->get()->getResultArray();

        $labels = [];
        $ipsValues = [];

        foreach ($grafikData as $g) {
            // Hitung IPS untuk semester ini saja
            $detail = $db->table('detail_krs')
                ->select('matakuliah.sks, nilai.nilai_huruf')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
                ->where('id_krs', $g['id_krs'])
                ->get()->getResultArray();

            $semSks = 0;
            $semPoin = 0;
            $sudahAdaNilai = false;

            foreach ($detail as $d) {
                if ($d['nilai_huruf'] !== null) {
                    $sudahAdaNilai = true;
                    $b = $this->_getBobot($d['nilai_huruf']);
                    $semSks += (int)$d['sks'];
                    $semPoin += ($b * (int)$d['sks']);
                }
            }

            // Hanya tampilkan di grafik jika semester tersebut sudah selesai/dinilai
            if ($sudahAdaNilai) {
                $labels[] = $g['tahun_ajaran'] . ' (' . $g['semester'] . ')';
                $ipsValues[] = ($semSks > 0) ? number_format($semPoin / $semSks, 2) : 0;
            }
        }

        // 4. Jadwal Kuliah Hari Ini
        // Set timezone Indonesia
        date_default_timezone_set('Asia/Jakarta');

        $hariIni = date('l'); // Monday, Tuesday, etc.
        $hariIndo = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $hari = isset($hariIndo[$hariIni]) ? $hariIndo[$hariIni] : 'Senin';

        // Ambil KRS yang sudah approved di semester aktif
        $krsAktif = $db->table('krs')
            ->where('nim', $nim)
            ->where('id_tahun', $taAktif['id_tahun'])
            ->where('status_krs', 'Approved')
            ->get()->getRowArray();

        $jadwalHariIni = [];
        $semuaJadwal = [];
        if ($krsAktif) {
            // Jadwal hari ini
            $jadwalHariIni = $db->table('detail_krs')
                ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, dosen.nama_dosen')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('dosen', 'dosen.nidn = jadwal.nidn')
                ->where('detail_krs.id_krs', $krsAktif['id_krs'])
                ->where('jadwal.hari', $hari)
                ->orderBy('jadwal.jam', 'ASC')
                ->get()->getResultArray();

            // Semua jadwal untuk tampilan grouping
            $semuaJadwal = $db->table('detail_krs')
                ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, dosen.nama_dosen')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->join('dosen', 'dosen.nidn = jadwal.nidn')
                ->where('detail_krs.id_krs', $krsAktif['id_krs'])
                ->get()->getResultArray();

            // Sort jadwal by hari dan jam
            $urutanHari = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 7];
            usort($semuaJadwal, function ($a, $b) use ($urutanHari) {
                $hariA = $urutanHari[$a['hari']] ?? 99;
                $hariB = $urutanHari[$b['hari']] ?? 99;
                if ($hariA != $hariB) {
                    return $hariA - $hariB;
                }
                return strcmp($a['jam'], $b['jam']);
            });
        }

        // 5. Status KRS Semester Ini
        $statusKrs = $krsAktif['status_krs'] ?? 'Belum Mengisi';
        $totalSksKrs = 0;
        if ($krsAktif) {
            $detailKrs = $db->table('detail_krs')
                ->select('matakuliah.sks')
                ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                ->where('detail_krs.id_krs', $krsAktif['id_krs'])
                ->get()->getResultArray();

            foreach ($detailKrs as $d) {
                $totalSksKrs += (int)$d['sks'];
            }
        }

        $data = [
            'title'       => 'Dashboard Mahasiswa',
            'is_lengkap'  => $is_lengkap,
            'mhs'         => $mhs,
            'semesterMhs' => $semesterMhs,
            'taAktif'     => $taAktif,
            'ipk'         => $ipk,
            'totalSks'    => $totalSksLulus, // Sekarang hanya SKS yang Lulus
            'grafik'      => [
                'labels' => $labels,
                'data'   => $ipsValues
            ],
            'jadwalHariIni' => $jadwalHariIni,
            'semuaJadwal' => $semuaJadwal,
            'hari' => $hari,
            'statusKrs' => $statusKrs,
            'totalSksKrs' => $totalSksKrs
        ];

        return view('mahasiswa/dashboard', $data);
    }

    private function _getBobot($huruf)
    {
        return match ($huruf) {
            'A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0, default => 0,
        };
    }

    public function daftar_kelas()
    {
        $id_user = session()->get('id_user');
        $filter_smt = $this->request->getGet('smt');

        // 1. Ambil DATA MAHASISWA untuk mendapatkan ID PRODI
        $mhs = $this->db->table('mahasiswa')->where('id_user', $id_user)->get()->getRowArray();

        if (!$mhs) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $id_prodi = $mhs['id_prodi'];

        // 2. Ambil Tahun Akademik Aktif
        $ta = $this->db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();
        if (!$ta) {
            return redirect()->back()->with('error', 'Tahun Akademik Aktif tidak ditemukan');
        }

        $id_tahun = $ta['id_tahun'];
        $semester_tipe = $ta['semester'];

        // Daftar semester standar sesuai tipe TA
        $daftar_smt = ($semester_tipe == 'Ganjil') ? [1, 3, 5, 7] : [2, 4, 6, 8];

        // 3. Query Jadwal dengan FILTER PRODI menggunakan PIVOT TABLE
        // HANYA tampilkan mata kuliah yang ADA di matakuliah_prodi untuk prodi mahasiswa ini
        $builder = $this->db->table('jadwal')
            ->select('jadwal.*, 
                      matakuliah.nama_mk, 
                      matakuliah.sks, 
                      matakuliah.kd_mk,
                      COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) as smt,
                      COALESCE(matakuliah_prodi.is_wajib, 1) as is_wajib,
                      matakuliah_prodi.id_prodi,
                      dosen.nama_dosen, 
                      prodi.nama_prodi,
                      jadwal.kouta as kapasitas,
                      (SELECT COUNT(*) FROM detail_krs 
                       JOIN krs ON krs.id_krs = detail_krs.id_krs 
                       WHERE detail_krs.id_jadwal = jadwal.id_jadwal 
                       AND krs.status_krs = "Approved") as terisi')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('matakuliah_prodi', 'matakuliah_prodi.kd_mk = matakuliah.kd_mk', 'inner') // INNER JOIN = harus ada di pivot
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->join('prodi', 'prodi.id_prodi = matakuliah_prodi.id_prodi', 'left')
            ->where('jadwal.id_tahun', $id_tahun)
            ->where('matakuliah_prodi.id_prodi', $id_prodi); // FILTER: hanya prodi mahasiswa ini

        // 4. Filter Semester
        if ($filter_smt && $filter_smt !== 'all') {
            $builder->where("COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) = " . (int)$filter_smt, null, false);
        } else {
            $smt_list = implode(',', $daftar_smt);
            $builder->where("COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) IN ($smt_list)", null, false);
        }

        // 5. Get results first, then sort in PHP
        $jadwal = $builder->get()->getResultArray();

        // Sort by semester and nama_mk
        usort($jadwal, function ($a, $b) {
            if ($a['smt'] == $b['smt']) {
                return strcmp($a['nama_mk'], $b['nama_mk']);
            }
            return $a['smt'] - $b['smt'];
        });

        $data = [
            'title'      => 'Daftar Kelas & Jadwal',
            'ta'         => $ta,
            'jadwal'     => $jadwal,
            'daftar_smt' => $daftar_smt,
            'smt_aktif'  => $filter_smt ?? 'all',
            'prodi_mhs'  => $mhs['id_prodi']
        ];

        return view('mahasiswa/daftar_kelas', $data);
    }
}
