<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\TahunAkademikModel;

class Nilai extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $nim = session()->get('nim');
        $taModel = new TahunAkademikModel();

        $id_tahun = $this->request->getGet('id_tahun') ?? $taModel->where('status', 'Aktif')->first()['id_tahun'];
        $taTerpilih = $taModel->find($id_tahun);
        $semuaTa = $taModel->findAll();

        // Ambil data mahasiswa dengan prodi
        $mhsData = $this->db->table('mahasiswa')
            ->select('mahasiswa.*, prodi.nama_prodi')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('mahasiswa.nim', $nim)
            ->get()->getRowArray();

        $krsRecord = $this->db->table('krs')->where('nim', $nim)->where('id_tahun', $id_tahun)->get()->getRowArray();
        $id_krs = $krsRecord ? $krsRecord['id_krs'] : null;

        $queryNilai = $this->db->table('detail_krs')
            ->select('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, nilai.nilai_angka, nilai.nilai_huruf')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
            ->where('krs.nim', $nim)
            ->where('krs.id_tahun', $id_tahun)
            ->get()->getResultArray();

        $totalSksAmbil = 0;
        $totalSksLulus = 0;
        $totalPoin = 0;
        $sksHitungIps = 0;
        $dataNilai = [];

        foreach ($queryNilai as $n) {
            $bobot = $this->_getBobot($n['nilai_huruf']);
            $sudahDinilai = ($n['nilai_huruf'] !== null);
            $poin = $sudahDinilai ? ($bobot * $n['sks']) : 0;

            $totalSksAmbil += $n['sks'];
            if ($sudahDinilai) {
                $sksHitungIps += $n['sks'];
                $totalPoin += $poin;
                if ($bobot > 0) {
                    $totalSksLulus += $n['sks'];
                }
            }

            $dataNilai[] = array_merge($n, [
                'bobot' => $bobot,
                'poin'  => $poin,
                'status' => $sudahDinilai ? ($bobot > 0 ? 'Lulus' : 'Gagal') : 'Proses'
            ]);
        }

        $ips = ($sksHitungIps > 0) ? number_format($totalPoin / $sksHitungIps, 2) : '0.00';

        $data = [
            'title'      => 'Kartu Hasil Studi',
            'nilai'      => $dataNilai,
            'semuaTa'    => $semuaTa,
            'taTerpilih' => $taTerpilih,
            'id_krs'     => $id_krs,
            'mahasiswa'  => $mhsData,
            'summary'    => [
                'totalSks' => $totalSksAmbil,
                'totalSksLulus' => $totalSksLulus,
                'totalPoin' => $totalPoin,
                'ips' => $ips
            ]
        ];

        return view('mahasiswa/nilai/index', $data);
    }

    private function _getBobot($huruf)
    {
        return match ($huruf) {
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            default => 0,
        };
    }

    private function _getJenjang($nama_prodi)
    {
        // Manajemen Informatika = D3 (6 semester)
        // Sistem Informasi & Sistem Komputer = S1 (8 semester)
        if (stripos($nama_prodi, 'Manajemen Informatika') !== false) {
            return 'D3';
        }
        return 'S1';
    }

    public function transkrip()
    {
        $nim = session()->get('nim');

        // Ambil Profil Mahasiswa (Join hanya ke Prodi saja)
        $mhs = $this->db->table('mahasiswa')
            ->select('mahasiswa.nama_mhs, mahasiswa.nim, prodi.nama_prodi')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('mahasiswa.nim', $nim)
            ->get()->getRowArray();

        // Query Transkrip Group By MK dengan info Semester
        $queryTranskrip = $this->db->table('detail_krs')
            ->select('matakuliah.kd_mk, 
                      matakuliah.nama_mk, 
                      matakuliah.sks, 
                      MAX(nilai.nilai_angka) as nilai_angka, 
                      MAX(nilai.nilai_huruf) as nilai_huruf, 
                      MAX(tahun_akademik.semester) as semester, 
                      MAX(tahun_akademik.tahun_ajaran) as tahun_ajaran')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail') // Hanya ambil yang sudah ada nilainya
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.nim', $nim)
            ->groupBy('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks')
            ->orderBy('MAX(tahun_akademik.id_tahun)', 'ASC')
            ->get()->getResultArray();

        $totalSksLulus = 0;
        $totalPoinKumulatif = 0;
        $sksHitungIpk = 0;
        $transkripGrouped = [];

        foreach ($queryTranskrip as $n) {
            $bobot = $this->_getBobot($n['nilai_huruf']);
            $poin = $bobot * $n['sks'];

            $sksHitungIpk += $n['sks'];
            $totalPoinKumulatif += $poin;
            if ($bobot > 0) {
                $totalSksLulus += $n['sks'];
            }

            $key = $n['tahun_ajaran'] . ' - ' . $n['semester'];
            $transkripGrouped[$key][] = [
                'kd_mk' => $n['kd_mk'],
                'nama_mk' => $n['nama_mk'],
                'sks' => $n['sks'],
                'nilai_huruf' => $n['nilai_huruf'],
                'bobot' => $bobot,
                'poin' => $poin,
                'status' => $bobot > 0 ? 'Lulus' : 'Gagal'
            ];
        }

        $ipk = ($sksHitungIpk > 0) ? number_format($totalPoinKumulatif / $sksHitungIpk, 2) : '0.00';

        $data = [
            'title'     => 'Transkrip Nilai',
            'mhs'       => $mhs,
            'transkrip' => $transkripGrouped,
            'summary'   => [
                'totalSksLulus' => $totalSksLulus,
                'totalPoin'     => $totalPoinKumulatif,
                'ipk'           => $ipk
            ]
        ];

        return view('mahasiswa/nilai/transkrip', $data);
    }

    public function print_khs($id_krs)
    {
        $db = \Config\Database::connect();

        // Ambil data KRS & Identitas Mahasiswa
        $krs = $db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, prodi.nama_prodi, dosen.nama_dosen as pembimbing, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.id_krs', $id_krs)
            ->get()->getRowArray();

        // Ambil detail mata kuliah dan nilai
        $detail = $db->table('detail_krs')
            ->select('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, nilai.nilai_huruf, nilai.nilai_angka')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
            ->where('detail_krs.id_krs', $id_krs)
            ->get()->getResultArray();

        // Hitung IPS
        $totalSksAmbil = 0;
        $totalSksLulus = 0;
        $totalPoin = 0;
        $sksHitungIps = 0;

        foreach ($detail as &$d) {
            $bobot = $this->_getBobot($d['nilai_huruf']);
            $sudahDinilai = ($d['nilai_huruf'] !== null);

            $totalSksAmbil += $d['sks'];

            if ($sudahDinilai) {
                $sksHitungIps += $d['sks'];
                $totalPoin += ($bobot * $d['sks']);
                if ($bobot > 0) {
                    $totalSksLulus += $d['sks'];
                }
            }

            $d['keterangan'] = $sudahDinilai ? ($bobot > 0 ? 'LULUS' : 'GAGAL') : 'PROSES';
        }

        $ips = ($sksHitungIps > 0) ? number_format($totalPoin / $sksHitungIps, 2) : '0.00';

        $data = [
            'krs'    => $krs,
            'detail' => $detail,
            'jenjang' => $this->_getJenjang($krs['nama_prodi']),
            'summary' => [
                'totalSksAmbil' => $totalSksAmbil,
                'totalSksLulus' => $totalSksLulus,
                'totalPoin' => $totalPoin,
                'ips' => $ips
            ]
        ];

        return view('mahasiswa/nilai/print_khs', $data);
    }

    public function print_transkrip()
    {
        $nim = session()->get('nim');

        $mhs = $this->db->table('mahasiswa')
            ->select('mahasiswa.*, prodi.nama_prodi, dosen.nama_dosen as pembimbing')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->where('mahasiswa.nim', $nim)
            ->get()->getRowArray();

        // Query Transkrip Group By MK dengan info Semester (sama seperti method transkrip)
        $queryTranskrip = $this->db->table('detail_krs')
            ->select('matakuliah.kd_mk, 
                      matakuliah.nama_mk, 
                      matakuliah.sks, 
                      MAX(nilai.nilai_angka) as nilai_angka, 
                      MAX(nilai.nilai_huruf) as nilai_huruf, 
                      MAX(tahun_akademik.semester) as semester, 
                      MAX(tahun_akademik.tahun_ajaran) as tahun_ajaran')
            ->join('krs', 'krs.id_krs = detail_krs.id_krs')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->join('nilai', 'nilai.id_detail = detail_krs.id_detail') // INNER JOIN - hanya yang sudah dinilai
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.nim', $nim)
            ->groupBy('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks')
            ->orderBy('MAX(tahun_akademik.id_tahun)', 'ASC')
            ->get()->getResultArray();

        $totalSksLulus = 0;
        $totalPoinKumulatif = 0;
        $sksHitungIpk = 0;
        $groupedData = [];

        foreach ($queryTranskrip as $n) {
            $bobot = $this->_getBobot($n['nilai_huruf']);
            $poin = $bobot * $n['sks'];

            $sksHitungIpk += $n['sks'];
            $totalPoinKumulatif += $poin;
            if ($bobot > 0) {
                $totalSksLulus += $n['sks'];
            }

            $key = $n['tahun_ajaran'] . ' - ' . $n['semester'];
            $groupedData[$key][] = [
                'kd_mk' => $n['kd_mk'],
                'nama_mk' => $n['nama_mk'],
                'sks' => $n['sks'],
                'nilai_huruf' => $n['nilai_huruf'],
                'bobot' => $bobot,
                'poin' => $poin,
                'keterangan' => $bobot > 0 ? 'LULUS' : 'GAGAL'
            ];
        }

        $ipk = ($sksHitungIpk > 0) ? number_format($totalPoinKumulatif / $sksHitungIpk, 2) : '0.00';

        $data = [
            'mhs'       => $mhs,
            'transkrip' => $groupedData,
            'jenjang'   => $this->_getJenjang($mhs['nama_prodi']),
            'summary'   => [
                'totalSksLulus' => $totalSksLulus,
                'totalPoin'     => $totalPoinKumulatif,
                'ipk'           => $ipk
            ]
        ];

        return view('mahasiswa/nilai/print_transkrip', $data);
    }

    public function print_krs($id_krs)
    {
        $krs = $this->db->table('krs')
            ->select('krs.*, mahasiswa.nama_mhs, mahasiswa.nim, prodi.nama_prodi, dosen.nama_dosen as pembimbing, tahun_akademik.tahun_ajaran, tahun_akademik.semester')
            ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
            ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali', 'left')
            ->join('tahun_akademik', 'tahun_akademik.id_tahun = krs.id_tahun')
            ->where('krs.id_krs', $id_krs)
            ->get()->getRowArray();

        $detail = $this->db->table('detail_krs')
            ->select('matakuliah.kd_mk, matakuliah.nama_mk, matakuliah.sks, jadwal.hari, jadwal.jam, jadwal.jam_selesai, jadwal.kelas, jadwal.ruang')
            ->join('jadwal', 'jadwal.id_jadwal = detail_krs.id_jadwal')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->where('detail_krs.id_krs', $id_krs)
            ->get()->getResultArray();

        $data = [
            'krs'    => $krs,
            'detail' => $detail
        ];

        return view('mahasiswa/krs/print_krs', $data);
    }
}
