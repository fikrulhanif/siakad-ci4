<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\NilaiModel;
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
        $nidn = session()->get('nidn');
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        // Ambil jadwal yang diajar oleh dosen ini di semester aktif
        $jadwal = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->where('nidn', $nidn)
            ->where('id_tahun', $taAktif['id_tahun'])
            ->orderBy('matakuliah.smt', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'   => 'Daftar Mata Kuliah Diampu',
            'jadwal'  => $jadwal,
            'taAktif' => $taAktif
        ];

        return view('dosen/nilai/index', $data);
    }

    public function input($id_jadwal)
    {
        // Ambil info detail jadwal untuk header
        $infoJadwal = $this->db->table('jadwal')
            ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks')
            ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
            ->where('id_jadwal', $id_jadwal)
            ->get()->getRowArray();

        // Ambil daftar mahasiswa yang mengambil jadwal ini
        $mahasiswa = $this->db->table('detail_krs')
        ->select('detail_krs.id_detail, mahasiswa.nim, mahasiswa.nama_mhs, prodi.nama_prodi, nilai.nilai_angka, nilai.nilai_huruf') // Tambah prodi
        ->join('krs', 'krs.id_krs = detail_krs.id_krs')
        ->join('mahasiswa', 'mahasiswa.nim = krs.nim')
        ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left') // Join ke prodi
        ->join('nilai', 'nilai.id_detail = detail_krs.id_detail', 'left')
        ->where('detail_krs.id_jadwal', $id_jadwal)
        ->get()->getResultArray();

        $data = [
            'title'      => 'Input Nilai Mahasiswa',
            'mahasiswa'  => $mahasiswa,
            'id_jadwal'  => $id_jadwal,
            'infoJadwal' => $infoJadwal // Data tambahan untuk header view
        ];

        return view('dosen/nilai/input', $data);
    }

    public function store()
    {
        $id_detail   = $this->request->getPost('id_detail'); // Array
        $nilai_angka = $this->request->getPost('nilai_angka'); // Array
        $nilaiModel  = new NilaiModel();

        foreach ($id_detail as $key => $id) {
            $angka = $nilai_angka[$key];

            // Logika konversi nilai huruf
            if ($angka >= 85) {
                $huruf = 'A';
            } elseif ($angka >= 75) {
                $huruf = 'B';
            } elseif ($angka >= 65) {
                $huruf = 'C';
            } elseif ($angka >= 50) {
                $huruf = 'D';
            } else {
                $huruf = 'E';
            }

            // Cek apakah nilai sudah ada (Update) atau belum (Insert)
            $cek = $nilaiModel->where('id_detail', $id)->first();

            $dataNilai = [
                'id_detail'   => $id,
                'nilai_angka' => $angka,
                'nilai_huruf' => $huruf
            ];

            if ($cek) {
                $nilaiModel->update($cek['id_nilai'], $dataNilai);
            } else {
                $nilaiModel->insert($dataNilai);
            }
        }

        return redirect()->to('dosen/nilai')->with('success', 'Nilai berhasil disimpan!');
    }
}
