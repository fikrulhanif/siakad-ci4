<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\UserModel;
use App\Models\ProdiModel;

class Dosen extends BaseController
{
    protected $dosenModel;
    protected $userModel;
    protected $prodiModel;
    protected $db;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->userModel  = new UserModel();
        $this->prodiModel = new ProdiModel();
        $this->db         = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dosen',
            'dosen' => $this->dosenModel->select('dosen.*, prodi.nama_prodi')
                                        ->join('prodi', 'prodi.id_prodi = dosen.id_prodi')
                                        ->findAll(),
            'prodi' => $this->prodiModel->findAll()
        ];
        return view('admin/dosen/index', $data);
    }

    public function store()
    {
        $nidn = $this->request->getPost('nidn');

        $this->db->transStart();

        // 1. Simpan ke tabel users
        $this->userModel->insert([
            'username' => $nidn,
            'password' => password_hash($nidn, PASSWORD_DEFAULT),
            'role'     => 'dosen'
        ]);

        $id_user = $this->userModel->getInsertID();

        // 2. Simpan ke tabel dosen
        $this->dosenModel->insert([
            'nidn'       => $nidn,
            'id_user'    => $id_user,
            'id_prodi'   => $this->request->getPost('id_prodi'),
            'nama_dosen' => $this->request->getPost('nama_dosen'),
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menambah data Dosen.');
        }

        return redirect()->to('admin/dosen')->with('success', 'Data Dosen berhasil ditambah.');
    }

    public function update($nidn)
    {
        $this->dosenModel->update($nidn, [
            'nama_dosen' => $this->request->getPost('nama_dosen'),
            'id_prodi'   => $this->request->getPost('id_prodi'),
        ]);

        return redirect()->to('admin/dosen')->with('success', 'Data Dosen berhasil diubah.');
    }

    public function delete($nidn)
    {
        $dosen = $this->dosenModel->find($nidn);

        if ($dosen) {
            $this->db->transStart();
            $this->dosenModel->delete($nidn);
            $this->userModel->delete($dosen['id_user']);
            $this->db->transComplete();

            return redirect()->to('admin/dosen')->with('success', 'Data Dosen berhasil dihapus.');
        }

        return redirect()->to('admin/dosen')->with('error', 'Data tidak ditemukan.');
    }
}
