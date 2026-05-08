<?php

namespace App\Controllers\Admin;

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
        // Query jumlah mahasiswa per Program Studi untuk grafik
        $mhsPerProdi = $this->db->table('prodi')
            ->select('prodi.nama_prodi, COUNT(mahasiswa.nim) as total')
            ->join('mahasiswa', 'mahasiswa.id_prodi = prodi.id_prodi', 'left')
            ->groupBy('prodi.id_prodi')
            ->get()->getResultArray();

        // Tahun Akademik Aktif
        $taAktif = $this->db->table('tahun_akademik')->where('status', 'Aktif')->get()->getRowArray();

        // Statistik KRS
        $totalKrs = $this->db->table('krs')->where('id_tahun', $taAktif['id_tahun'])->countAllResults();
        $krsApproved = $this->db->table('krs')->where('id_tahun', $taAktif['id_tahun'])->where('status_krs', 'Approved')->countAllResults();
        $krsPending = $this->db->table('krs')->where('id_tahun', $taAktif['id_tahun'])->where('status_krs', 'Pending')->countAllResults();
        $krsRejected = $this->db->table('krs')->where('id_tahun', $taAktif['id_tahun'])->where('status_krs', 'Rejected')->countAllResults();

        // Statistik Jadwal
        $totalJadwal = $this->db->table('jadwal')->where('id_tahun', $taAktif['id_tahun'])->countAllResults();

        // Mahasiswa per angkatan (5 tahun terakhir)
        $tahunSekarang = date('Y');
        $mhsPerAngkatan = [];
        $angkatanLabels = [];
        for ($i = 4; $i >= 0; $i--) {
            $angkatan = $tahunSekarang - $i;
            $angkatanLabels[] = (string)$angkatan;
            $count = $this->db->table('mahasiswa')->where('angkatan', $angkatan)->countAllResults();
            $mhsPerAngkatan[] = $count;
        }

        // Aktivitas terbaru (KRS yang baru diajukan)
        $recentKrs = $this->db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, prodi.nama_prodi')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->where('krs.id_tahun', $taAktif['id_tahun'])
            ->orderBy('krs.id_krs', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $data = [
            'title'     => 'Dashboard Admin',
            'jml_mhs'   => $this->db->table('mahasiswa')->countAllResults(),
            'jml_dsn'   => $this->db->table('dosen')->countAllResults(),
            'jml_mk'    => $this->db->table('matakuliah')->countAllResults(),
            'jml_prodi' => $this->db->table('prodi')->countAllResults(),
            'taAktif'   => $taAktif,
            'totalKrs'  => $totalKrs,
            'krsApproved' => $krsApproved,
            'krsPending' => $krsPending,
            'krsRejected' => $krsRejected,
            'totalJadwal' => $totalJadwal,
            // Data untuk Grafik
            'prodiLabels' => array_column($mhsPerProdi, 'nama_prodi'),
            'prodiData'   => array_column($mhsPerProdi, 'total'),
            'angkatanLabels' => $angkatanLabels,
            'mhsPerAngkatan' => $mhsPerAngkatan,
            'recentKrs' => $recentKrs
        ];

        return view('admin/dashboard', $data);
    }
}
