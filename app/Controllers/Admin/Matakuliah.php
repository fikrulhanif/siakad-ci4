<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MatakuliahModel;
use App\Models\ProdiModel;

class Matakuliah extends BaseController
{
    protected $mkModel;
    protected $prodiModel;
    protected $db;

    public function __construct()
    {
        $this->mkModel = new MatakuliahModel();
        $this->prodiModel = new ProdiModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Get filter semester dari query string
        $filterSmt = $this->request->getGet('filter_smt');

        // Get mata kuliah dengan info prodi yang bisa akses
        $builder = $this->db->table('matakuliah')
            ->select('matakuliah.*, 
                      GROUP_CONCAT(DISTINCT prodi.nama_prodi ORDER BY prodi.nama_prodi SEPARATOR ", ") as prodi_list,
                      COUNT(DISTINCT matakuliah_prodi.id_prodi) as jml_prodi')
            ->join('matakuliah_prodi', 'matakuliah_prodi.kd_mk = matakuliah.kd_mk', 'left')
            ->join('prodi', 'prodi.id_prodi = matakuliah_prodi.id_prodi', 'left')
            ->groupBy('matakuliah.kd_mk')
            ->orderBy('matakuliah.smt', 'ASC')
            ->orderBy('matakuliah.kd_mk', 'ASC');

        // Apply filter jika ada
        if ($filterSmt && $filterSmt != '') {
            $builder->where('matakuliah.smt', $filterSmt);
        }

        $matakuliah = $builder->get()->getResultArray();

        $data = [
            'title' => 'Data Mata Kuliah',
            'matakuliah' => $matakuliah,
            'prodi' => $this->prodiModel->findAll(),
            'filterSmt' => $filterSmt
        ];

        return view('admin/matakuliah/index', $data);
    }

    public function store()
    {
        $kd_mk = $this->request->getPost('kd_mk');
        $prodiAkses = $this->request->getPost('prodi_akses'); // Array

        // Validasi: Minimal pilih 1 prodi atau biarkan kosong untuk umum
        // (Jika kosong, berarti mata kuliah umum)

        $this->db->transStart();

        // 1. Simpan data mata kuliah (id_prodi tidak dipakai lagi)
        $this->mkModel->insert([
            'kd_mk'    => $kd_mk,
            'nama_mk'  => $this->request->getPost('nama_mk'),
            'sks'      => $this->request->getPost('sks'),
            'smt'      => $this->request->getPost('smt'),
            'id_prodi' => null // Tidak dipakai lagi, semua di pivot table
        ]);

        // 2. Simpan relasi dengan prodi di pivot table (jika ada)
        if (!empty($prodiAkses)) {
            foreach ($prodiAkses as $id_prodi) {
                $this->db->table('matakuliah_prodi')->insert([
                    'kd_mk' => $kd_mk,
                    'id_prodi' => $id_prodi,
                    'smt_prodi' => $this->request->getPost("smt_prodi_{$id_prodi}"),
                    'is_wajib' => $this->request->getPost("is_wajib_{$id_prodi}") ?? 1
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menambah data mata kuliah.');
        }

        return redirect()->to('admin/matakuliah')->with('success', 'Mata Kuliah berhasil ditambah.');
    }

    public function update($kd_mk)
    {
        $prodiAkses = $this->request->getPost('prodi_akses'); // Array

        $this->db->transStart();

        // 1. Update data mata kuliah
        $this->mkModel->update($kd_mk, [
            'nama_mk'  => $this->request->getPost('nama_mk'),
            'sks'      => $this->request->getPost('sks'),
            'smt'      => $this->request->getPost('smt')
        ]);

        // 2. Hapus relasi lama di pivot table
        $this->db->table('matakuliah_prodi')->where('kd_mk', $kd_mk)->delete();

        // 3. Insert relasi baru (jika ada)
        if (!empty($prodiAkses)) {
            foreach ($prodiAkses as $id_prodi) {
                $this->db->table('matakuliah_prodi')->insert([
                    'kd_mk' => $kd_mk,
                    'id_prodi' => $id_prodi,
                    'smt_prodi' => $this->request->getPost("smt_prodi_{$id_prodi}"),
                    'is_wajib' => $this->request->getPost("is_wajib_{$id_prodi}") ?? 1
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal mengubah data mata kuliah.');
        }

        return redirect()->to('admin/matakuliah')->with('success', 'Mata Kuliah berhasil diubah.');
    }

    public function delete($kd_mk)
    {
        // Cek apakah mata kuliah sudah dipakai di jadwal
        $cekJadwal = $this->db->table('jadwal')->where('kd_mk', $kd_mk)->countAllResults();

        if ($cekJadwal > 0) {
            return redirect()->back()->with('error', 'Mata kuliah tidak bisa dihapus karena sudah dipakai di jadwal!');
        }

        // Hapus mata kuliah (relasi di pivot table otomatis terhapus karena CASCADE)
        $this->mkModel->delete($kd_mk);

        return redirect()->to('admin/matakuliah')->with('success', 'Mata Kuliah berhasil dihapus.');
    }

    /**
     * Get data prodi yang sudah terdaftar untuk mata kuliah (untuk edit)
     */
    public function getProdiByMatakuliah($kd_mk)
    {
        return $this->db->table('matakuliah_prodi')
            ->where('kd_mk', $kd_mk)
            ->get()->getResultArray();
    }
}
