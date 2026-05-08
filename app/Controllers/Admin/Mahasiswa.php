<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\UserModel;
use App\Models\ProdiModel;
use App\Models\DosenModel;

class Mahasiswa extends BaseController
{
    protected $mhsModel;
    protected $userModel;
    protected $prodiModel;
    protected $dosenModel;
    protected $db;

    public function __construct()
    {
        $this->mhsModel = new MahasiswaModel();
        $this->userModel = new UserModel();
        $this->prodiModel = new ProdiModel();
        $this->dosenModel = new DosenModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Mahasiswa',
            'mahasiswa' => $this->mhsModel->select('mahasiswa.*, prodi.nama_prodi, dosen.nama_dosen')
                                    ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi')
                                    ->join('dosen', 'dosen.nidn = mahasiswa.nidn_wali')
                                    ->findAll(),
            'dosen'     => $this->dosenModel->findAll(),
            'prodi'     => $this->prodiModel->findAll()
        ];
        return view('admin/mahasiswa/index', $data);
    }

    public function store()
    {
        $nim = $this->request->getPost('nim');

        $this->db->transStart();

        // 1. Simpan ke tabel users
        $this->userModel->insert([
            'username' => $nim,
            'password' => password_hash($nim, PASSWORD_DEFAULT),
            'role'     => 'mahasiswa'
        ]);

        $id_user = $this->userModel->getInsertID();

        // 2. Simpan ke tabel mahasiswa
        $this->mhsModel->insert([
            'nim'      => $nim,
            'id_user'  => $id_user,
            'id_prodi' => $this->request->getPost('id_prodi'),
            'nama_mhs' => $this->request->getPost('nama_mhs'),
            'jenkel' => $this->request->getPost('jenkel'),
            'angkatan' => $this->request->getPost('angkatan'),
            'status'   => 'aktif',
            'nidn_wali' => $this->request->getPost('nidn_wali'),
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menambah data.');
        }

        return redirect()->to('admin/mahasiswa')->with('success', 'Data Mahasiswa berhasil ditambah.');
    }

    public function update($nim)
    {
        // Update data profil saja (biasanya username/nim tidak diubah agar relasi aman)
        $data = [
            'nama_mhs' => $this->request->getPost('nama_mhs'),
            'jenkel' => $this->request->getPost('jenkel'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'angkatan' => $this->request->getPost('angkatan'),
            'status'   => $this->request->getPost('status'),
            'nidn_wali'   => $this->request->getPost('nidn_wali'),
        ];

        $this->mhsModel->update($nim, $data);
        return redirect()->to('admin/mahasiswa')->with('success', 'Data Mahasiswa berhasil diubah.');
    }

    public function delete($nim)
    {
        // Cari id_user dulu sebelum data mahasiswa dihapus
        $mhs = $this->mhsModel->find($nim);

        if ($mhs) {
            $this->db->transStart();

            // Hapus data mahasiswa (anak)
            $this->mhsModel->delete($nim);

            // Hapus data user (induk)
            $this->userModel->delete($mhs['id_user']);

            $this->db->transComplete();

            return redirect()->to('admin/mahasiswa')->with('success', 'Data Mahasiswa dan Akun Login berhasil dihapus.');
        }

        return redirect()->to('admin/mahasiswa')->with('error', 'Data tidak ditemukan.');
    }
}
