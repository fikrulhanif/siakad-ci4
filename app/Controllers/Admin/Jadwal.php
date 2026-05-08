<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\MatakuliahModel;
use App\Models\DosenModel;
use App\Models\TahunAkademikModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $db;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        if (!$taAktif) {
            return redirect()->to('admin/tahun-akademik')->with('error', 'Aktifkan Tahun Akademik terlebih dahulu!');
        }

        $filterSmt = $this->request->getGet('filter_smt');

        // 1. MODIFIKASI QUERY JADWAL (Mendukung Matkul Umum)
        $builder = $this->db->table('jadwal')
        ->select('jadwal.*, matakuliah.nama_mk, matakuliah.sks, matakuliah.smt, matakuliah.id_prodi, dosen.nama_dosen, prodi.nama_prodi')
        ->join('matakuliah', 'matakuliah.kd_mk = jadwal.kd_mk')
        ->join('dosen', 'dosen.nidn = jadwal.nidn')
        // Gunakan leftJoin ke prodi agar matkul umum (NULL) tidak hilang dari daftar
        ->join('prodi', 'prodi.id_prodi = matakuliah.id_prodi', 'left')
        ->where('id_tahun', $taAktif['id_tahun']);

        if ($filterSmt) {
            $builder->where('matakuliah.smt', $filterSmt);
        }

        $jadwal = $builder->get()->getResultArray();

        // 2. LOGIKA AMBIL MATAKULIAH UNTUK DROPDOWN (Support Hybrid)
        $mkModel = new MatakuliahModel();
        $smtFilterList = ($taAktif['semester'] == 'Ganjil') ? [1, 3, 5, 7] : [2, 4, 6, 8];

        // Ambil matkul sesuai semester aktif, tanpa memedulikan prodi (karena Admin berhak menjadwalkan semua)
        $mkFiltered = $mkModel->whereIn('smt', $smtFilterList)->orderBy('smt', 'ASC')->findAll();

        $mkGrouped = [];
        foreach ($mkFiltered as $m) {
            // Kita beri label tambahan agar Admin tahu mana matkul Prodi dan mana Umum
            $mkGrouped[$m['smt']][] = $m;
        }

        $data = [
            'title'   => 'Penjadwalan Kuliah',
            'taAktif' => $taAktif,
            'jadwal'  => $jadwal,
            'mk_grouped' => $mkGrouped,
            'dosen'      => (new DosenModel())->findAll(), // Dosen tetap semua agar bisa lintas prodi
            'filterSmt'  => $filterSmt,
            'smtList'    => $smtFilterList
        ];

        return view('admin/jadwal/index', $data);
    }

    public function copy_jadwal()
    {
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        // Cari Tahun Akademik sebelumnya yang semesternya sama (misal Ganjil ke Ganjil)
        $taLalu = $taModel->where('semester', $taAktif['semester'])
                          ->where('id_tahun !=', $taAktif['id_tahun'])
                          ->orderBy('id_tahun', 'DESC')
                          ->first();

        if (!$taLalu) {
            return redirect()->back()->with('error', 'Tidak ditemukan jadwal semester sebelumnya untuk disalin.');
        }

        // Ambil semua jadwal dari tahun lalu
        $jadwalLalu = $this->jadwalModel->where('id_tahun', $taLalu['id_tahun'])->findAll();

        foreach ($jadwalLalu as $j) {
            $this->jadwalModel->insert([
                'kd_mk'    => $j['kd_mk'],
                'nidn'     => $j['nidn'],
                'id_tahun' => $taAktif['id_tahun'], // Masukkan ke tahun aktif sekarang
                'kelas'    => $j['kelas'],
                'hari'     => $j['hari'],
                'jam'      => $j['jam'],
                'jam_selesai'  => $j['jam_selesai'],
                'ruang'    => $j['ruang'],
                'kouta'    => $j['kouta'],
            ]);
        }

        return redirect()->to('admin/jadwal')->with('success', 'Berhasil menyalin ' . count($jadwalLalu) . ' jadwal dari semester ' . $taLalu['tahun_ajaran']);
    }

    public function store()
    {
        $taModel = new TahunAkademikModel();
        $taAktif = $taModel->where('status', 'Aktif')->first();

        $this->jadwalModel->insert([
            'kd_mk'    => $this->request->getPost('kd_mk'),
            'nidn'     => $this->request->getPost('nidn'),
            'id_tahun' => $taAktif['id_tahun'],
            'kelas'    => $this->request->getPost('kelas'),
            'hari'     => $this->request->getPost('hari'),
            'jam'      => $this->request->getPost('jam'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'ruang'    => $this->request->getPost('ruang'),
            'kouta'    => $this->request->getPost('kouta'),
        ]);

        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function update($id)
    {
        $this->jadwalModel->update($id, [
            'nidn'  => $this->request->getPost('nidn'),
            'kelas' => $this->request->getPost('kelas'),
            'hari'  => $this->request->getPost('hari'),
            'jam'   => $this->request->getPost('jam'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'ruang' => $this->request->getPost('ruang'),
            'kouta' => $this->request->getPost('kouta'),
        ]);

        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->jadwalModel->delete($id);
        return redirect()->to('admin/jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }
}
