<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdiModel;

class Prodi extends BaseController
{
    protected $prodiModel;

    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Program Studi',
            'prodi' => $this->prodiModel->findAll()
        ];
        return view('admin/prodi/index', $data);
    }

    public function store()
    {
        $this->prodiModel->save([
            'nama_prodi' => $this->request->getPost('nama_prodi')
        ]);

        return redirect()->to('/admin/prodi')->with('success', 'Data berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->prodiModel->update($id, [
            'nama_prodi' => $this->request->getPost('nama_prodi'),
        ]);

        return redirect()->to('admin/prodi')->with('success', 'Data Prodi berhasil diubah.');
    }


    public function delete($id)
    {
        $this->prodiModel->delete($id);
        return redirect()->to('/admin/prodi')->with('success', 'Data berhasil dihapus');
    }
}
