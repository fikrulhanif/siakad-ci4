<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Laporan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Pusat Laporan'
        ];
        return view('admin/laporan/index', $data);
    }

    public function mahasiswa()
    {
        $data = [
            'title' => 'Filter Laporan Mahasiswa',
            'prodi' => $this->db->table('prodi')->get()->getResultArray()
        ];
        return view('admin/laporan/index_mahasiswa', $data);
    }

    public function preview_mahasiswa()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $angkatan = $this->request->getPost('angkatan');

        $builder = $this->db->table('mahasiswa')
                    ->select('mahasiswa.*, prodi.nama_prodi')
                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi');

        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }
        if ($angkatan !== 'all') {
            $builder->where('mahasiswa.angkatan', $angkatan);
        }

        $mhs = $builder->orderBy('mahasiswa.nim', 'ASC')->get()->getResultArray();

        $nama_prodi = ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'];

        $data = [
            'title'      => 'Preview Laporan Mahasiswa',
            'mhs'        => $mhs,
            'prodi_text' => $nama_prodi,
            'angkatan'   => $angkatan,
            'id_prodi'   => $id_prodi
        ];

        return view('admin/laporan/preview_mahasiswa', $data);
    }

    public function print_mahasiswa()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $angkatan = $this->request->getPost('angkatan');

        $builder = $this->db->table('mahasiswa')
                    ->select('mahasiswa.*, prodi.nama_prodi')
                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi');

        // Terapkan Filter jika bukan 'all'
        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }
        if ($angkatan !== 'all') {
            $builder->where('mahasiswa.angkatan', $angkatan);
        }

        $mhs = $builder->orderBy('mahasiswa.nim', 'ASC')->get()->getResultArray();

        // Ambil nama prodi untuk judul laporan (jika difilter)
        $nama_prodi = ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'];

        $data = [
            'title'      => 'Laporan Mahasiswa - ' . $nama_prodi,
            'mhs'        => $mhs,
            'prodi_text' => $nama_prodi,
            'angkatan'   => $angkatan
        ];

        return view('admin/laporan/print_mahasiswa', $data);
    }

    public function dosen()
    {
        $data = [
            'title' => 'Laporan Data Dosen',
            'dosen' => $this->db->table('dosen')
                            ->select('dosen.nidn, dosen.nama_dosen, prodi.nama_prodi')
                            ->join('prodi', 'prodi.id_prodi = dosen.id_prodi', 'left')
                            ->orderBy('dosen.nama_dosen', 'ASC')
                            ->get()->getResultArray()
        ];
        return view('admin/laporan/print_dosen', $data);
    }

    public function matakuliah()
    {
        $data = [
            'title' => 'Filter Laporan Matakuliah',
            'prodi' => $this->db->table('prodi')->get()->getResultArray()
        ];
        return view('admin/laporan/index_matakuliah', $data);
    }

    public function preview_matakuliah()
    {
        $id_prodi = $this->request->getPost('id_prodi');

        // Gunakan pivot table untuk filter
        if ($id_prodi !== 'all') {
            $mk = $this->db->table('matakuliah')
                ->select('matakuliah.*, COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) as semester_prodi, 
                         COALESCE(matakuliah_prodi.is_wajib, 1) as is_wajib')
                ->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$id_prodi}", 'inner')
                ->orderBy('semester_prodi', 'ASC')
                ->orderBy('matakuliah.kd_mk', 'ASC')
                ->get()->getResultArray();
        } else {
            // Semua matakuliah
            $mk = $this->db->table('matakuliah')
                ->select('matakuliah.*, matakuliah.smt as semester_prodi, 1 as is_wajib')
                ->orderBy('matakuliah.smt', 'ASC')
                ->orderBy('matakuliah.kd_mk', 'ASC')
                ->get()->getResultArray();
        }

        $nama_prodi = ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'];

        $data = [
            'title'      => 'Preview Laporan Matakuliah',
            'mk'         => $mk,
            'prodi_text' => $nama_prodi,
            'id_prodi'   => $id_prodi
        ];

        return view('admin/laporan/preview_matakuliah', $data);
    }

    public function print_matakuliah()
    {
        $id_prodi = $this->request->getPost('id_prodi');

        // Gunakan pivot table untuk filter
        if ($id_prodi !== 'all') {
            $mk = $this->db->table('matakuliah')
                ->select('matakuliah.*, COALESCE(matakuliah_prodi.smt_prodi, matakuliah.smt) as semester_prodi, 
                         COALESCE(matakuliah_prodi.is_wajib, 1) as is_wajib')
                ->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$id_prodi}", 'inner')
                ->orderBy('semester_prodi', 'ASC')
                ->orderBy('matakuliah.kd_mk', 'ASC')
                ->get()->getResultArray();
        } else {
            // Semua matakuliah
            $mk = $this->db->table('matakuliah')
                ->select('matakuliah.*, matakuliah.smt as semester_prodi, 1 as is_wajib')
                ->orderBy('matakuliah.smt', 'ASC')
                ->orderBy('matakuliah.kd_mk', 'ASC')
                ->get()->getResultArray();
        }

        $nama_prodi = ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'];

        $data = [
            'title'      => 'Laporan Matakuliah - ' . $nama_prodi,
            'mk'         => $mk,
            'prodi_text' => $nama_prodi
        ];

        return view('admin/laporan/print_matakuliah', $data);
    }

    public function jadwal()
    {
        $data = [
            'title' => 'Filter Laporan Jadwal',
            'prodi' => $this->db->table('prodi')->get()->getResultArray(),
            'tahun' => $this->db->table('tahun_akademik')->orderBy('id_tahun', 'DESC')->get()->getResultArray()
        ];
        return view('admin/laporan/index_jadwal', $data);
    }

    public function preview_jadwal()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        // Gunakan pivot table untuk filter
        $builder = $this->db->table('jadwal')
                    ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, dosen.nama_dosen, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
                    ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                    ->join('dosen', 'dosen.nidn = jadwal.nidn')
                    ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
                    ->where('jadwal.id_tahun', $id_tahun);

        if ($id_prodi !== 'all') {
            // Filter menggunakan pivot table
            $builder->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$id_prodi}", 'inner');
        }

        // Urutkan berdasarkan hari dan jam
        $jadwal = $builder->orderBy('FIELD(jadwal.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
                          ->orderBy('jadwal.jam', 'ASC')
                          ->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Preview Jadwal Perkuliahan',
            'jadwal' => $jadwal,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'],
            'id_prodi' => $id_prodi,
            'id_tahun' => $id_tahun
        ];

        return view('admin/laporan/preview_jadwal', $data);
    }

    public function print_jadwal()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        // Gunakan pivot table untuk filter
        $builder = $this->db->table('jadwal')
                    ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, dosen.nama_dosen, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
                    ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                    ->join('dosen', 'dosen.nidn = jadwal.nidn')
                    ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
                    ->where('jadwal.id_tahun', $id_tahun);

        if ($id_prodi !== 'all') {
            // Filter menggunakan pivot table
            $builder->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$id_prodi}", 'inner');
        }

        // Urutkan berdasarkan hari dan jam
        $jadwal = $builder->orderBy('FIELD(jadwal.hari, "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu")')
                          ->orderBy('jadwal.jam', 'ASC')
                          ->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Jadwal Perkuliahan',
            'jadwal' => $jadwal,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi']
        ];

        return view('admin/laporan/print_jadwal', $data);
    }

    public function krs()
    {
        $data = [
            'title' => 'Filter Rekapitulasi KRS',
            'prodi' => $this->db->table('prodi')->get()->getResultArray(),
            'tahun' => $this->db->table('tahun_akademik')->orderBy('id_tahun', 'DESC')->get()->getResultArray()
        ];
        return view('admin/laporan/index_krs', $data);
    }

    public function preview_krs()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        $builder = $this->db->table('krs')
                    ->select('krs.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi, SUM(matakuliah.sks) as total_sks, krs.status_krs')
                    ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
                    ->join('detail_krs', 'detail_krs.id_krs = krs.id_krs')
                    ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
                    ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
                    ->where('krs.id_tahun', $id_tahun)
                    ->where('krs.status_krs', 'Approved');

        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }

        $rekap = $builder->groupBy('krs.nim')->orderBy('mahasiswa.nim', 'ASC')->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Preview Rekapitulasi KRS',
            'rekap'  => $rekap,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'],
            'id_prodi' => $id_prodi,
            'id_tahun' => $id_tahun
        ];

        return view('admin/laporan/preview_krs', $data);
    }

    public function print_krs()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        $builder = $this->db->table('krs')
                    ->select('krs.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi, SUM(matakuliah.sks) as total_sks, krs.status_krs')
                    ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
                    ->join('detail_krs', 'detail_krs.id_krs = krs.id_krs') // Join ke tabel detail
                    ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal') // Join ke jadwal
                    ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk') // Ambil SKS dari MK
                    ->where('krs.id_tahun', $id_tahun)
                    ->where('krs.status_krs', 'Approved'); // Biasanya hanya yang disetujui yang masuk rekap aktif

        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }

        $rekap = $builder->groupBy('krs.nim')->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Rekapitulasi KRS Mahasiswa',
            'rekap'  => $rekap,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi']
        ];

        return view('admin/laporan/print_krs', $data);
    }

    public function nilai()
    {
        $data = [
            'title' => 'Filter Laporan Prestasi Mahasiswa',
            'prodi' => $this->db->table('prodi')->get()->getResultArray(),
            'tahun' => $this->db->table('tahun_akademik')->orderBy('id_tahun', 'DESC')->get()->getResultArray()
        ];
        return view('admin/laporan/index_nilai', $data);
    }

    public function preview_nilai()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        $bobot_sql = "CASE 
        WHEN nilai.nilai_huruf = 'A' THEN 4
        WHEN nilai.nilai_huruf = 'B' THEN 3
        WHEN nilai.nilai_huruf = 'C' THEN 2
        WHEN nilai.nilai_huruf = 'D' THEN 1
        ELSE 0 
    END";

        $builder = $this->db->table('mahasiswa')
            ->select("mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi, 
                  SUM(matakuliah.sks) as total_sks, 
                  SUM(matakuliah.sks * ($bobot_sql)) as total_bobot,
                  (SUM(matakuliah.sks * ($bobot_sql)) / SUM(matakuliah.sks)) as ips")
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->join('krs', 'krs.nim = mahasiswa.nim')
            ->join('detail_krs', 'detail_krs.id_krs = krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail')
            ->where('krs.id_tahun', $id_tahun);

        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }

        $rekap = $builder->groupBy('mahasiswa.nim')
                         ->orderBy('ips', 'DESC')
                         ->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Preview Laporan Prestasi Mahasiswa',
            'rekap'  => $rekap,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi'],
            'id_prodi' => $id_prodi,
            'id_tahun' => $id_tahun
        ];

        return view('admin/laporan/preview_nilai', $data);
    }

    public function print_nilai()
    {
        $id_prodi = $this->request->getPost('id_prodi');
        $id_tahun = $this->request->getPost('id_tahun');

        // Menghitung bobot berdasarkan nilai_huruf (Sama persis dengan logika _getBobot di Mahasiswa)
        $bobot_sql = "CASE 
        WHEN nilai.nilai_huruf = 'A' THEN 4
        WHEN nilai.nilai_huruf = 'B' THEN 3
        WHEN nilai.nilai_huruf = 'C' THEN 2
        WHEN nilai.nilai_huruf = 'D' THEN 1
        ELSE 0 
    END";

        $builder = $this->db->table('mahasiswa')
            ->select("mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, prodi.nama_prodi, 
                  SUM(matakuliah.sks) as total_sks, 
                  SUM(matakuliah.sks * ($bobot_sql)) as total_bobot,
                  (SUM(matakuliah.sks * ($bobot_sql)) / SUM(matakuliah.sks)) as ips")
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->join('krs', 'krs.nim = mahasiswa.nim')
            ->join('detail_krs', 'detail_krs.id_krs = krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail')
            ->where('krs.id_tahun', $id_tahun);

        if ($id_prodi !== 'all') {
            $builder->where('mahasiswa.id_prodi', $id_prodi);
        }

        $rekap = $builder->groupBy('mahasiswa.nim')
                         ->orderBy('ips', 'DESC')
                         ->get()->getResultArray();

        $data_tahun = $this->db->table('tahun_akademik')->where('id_tahun', $id_tahun)->get()->getRowArray();

        $data = [
            'title'  => 'Laporan Prestasi Mahasiswa (IP Semester)',
            'rekap'  => $rekap,
            'ta'     => $data_tahun['tahun_ajaran'] . ' (' . $data_tahun['semester'] . ')',
            'prodi'  => ($id_prodi == 'all') ? 'Semua Program Studi' : $this->db->table('prodi')->where('id_prodi', $id_prodi)->get()->getRowArray()['nama_prodi']
        ];

        return view('admin/laporan/print_nilai', $data);
    }

    public function nilai_matakuliah()
    {
        $data = [
            'title' => 'Laporan Nilai Per Mata Kuliah',
            'tahun' => $this->db->table('tahun_akademik')->orderBy('id_tahun', 'DESC')->get()->getResultArray(),
            'prodi' => $this->db->table('prodi')->get()->getResultArray()
        ];
        return view('admin/laporan/index_nilaimk', $data);
    }

    public function get_jadwal_by_filter()
    {
        $id_tahun = $this->request->getPost('id_tahun');
        $id_prodi = $this->request->getPost('id_prodi');

        $builder = $this->db->table('jadwal')
            ->select('jadwal.id_jadwal, matakuliah.nama_mk, matakuliah.smt, jadwal.kelas, dosen.nama_dosen')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->where('jadwal.id_tahun', $id_tahun);

        if ($id_prodi !== 'all') {
            // Filter menggunakan pivot table
            $builder->join('matakuliah_prodi', "matakuliah_prodi.kd_mk = matakuliah.kd_mk AND matakuliah_prodi.id_prodi = {$id_prodi}", 'inner');
        }

        $data = $builder->orderBy('matakuliah.smt', 'ASC')->orderBy('matakuliah.nama_mk', 'ASC')->get()->getResultArray();
        return $this->response->setJSON($data);
    }

    public function preview_nilaimk()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');

        $info = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, jadwal.kelas, dosen.nama_dosen, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
            ->where('jadwal.id_jadwal', $id_jadwal)
            ->get()->getRowArray();

        $peserta = $this->db->table('detail_krs')
            ->select('mahasiswa.nim, mahasiswa.nama_mhs, prodi.nama_prodi, nilai.nilai_angka, nilai.nilai_huruf')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
            ->where('detail_krs.id_jadwal', $id_jadwal)
            ->where('krs.status_krs', 'Approved')
            ->orderBy('mahasiswa.nim', 'ASC')
            ->get()->getResultArray();

        // Hitung statistik
        $nilaiAngka = array_filter(array_column($peserta, 'nilai_angka'));
        $stats = [
            'total_mhs' => count($peserta),
            'sudah_dinilai' => count($nilaiAngka),
            'belum_dinilai' => count($peserta) - count($nilaiAngka),
            'rata_rata' => !empty($nilaiAngka) ? number_format(array_sum($nilaiAngka) / count($nilaiAngka), 2) : '0.00',
            'tertinggi' => !empty($nilaiAngka) ? max($nilaiAngka) : 0,
            'terendah' => !empty($nilaiAngka) ? min($nilaiAngka) : 0
        ];

        $data = [
            'title' => 'Preview Daftar Nilai',
            'info' => $info,
            'peserta' => $peserta,
            'stats' => $stats,
            'id_jadwal' => $id_jadwal
        ];

        return view('admin/laporan/preview_nilaimk', $data);
    }

    public function print_nilaimk()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');

        $info = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, jadwal.kelas, dosen.nama_dosen, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('dosen', 'dosen.nidn = jadwal.nidn')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = jadwal.id_tahun')
            ->where('jadwal.id_jadwal', $id_jadwal)
            ->get()->getRowArray();

        $peserta = $this->db->table('detail_krs')
            ->select('mahasiswa.nim, mahasiswa.nama_mhs, prodi.nama_prodi, nilai.nilai_angka, nilai.nilai_huruf')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
            ->where('detail_krs.id_jadwal', $id_jadwal)
            ->where('krs.status_krs', 'Approved')
            ->orderBy('mahasiswa.nim', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title' => 'Daftar Peserta dan Nilai Akhir',
            'info' => $info,
            'peserta' => $peserta
        ];

        return view('admin/laporan/print_nilaimk', $data);
    }
}
