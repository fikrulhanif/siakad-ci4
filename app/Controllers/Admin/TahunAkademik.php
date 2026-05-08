<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TahunAkademikModel;

class TahunAkademik extends BaseController
{
    protected $taModel;

    public function __construct()
    {
        $this->taModel = new TahunAkademikModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tahun Akademik',
            'ta'    => $this->taModel->orderBy('id_tahun', 'ASC')->findAll()
        ];
        return view('admin/tahun_akademik/index', $data);
    }

    public function store()
    {
        // Validasi duplikasi (Opsional tapi disarankan)
        $exists = $this->taModel->where([
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            'semester'     => $this->request->getPost('semester'),
        ])->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Tahun Akademik tersebut sudah ada.');
        }

        $this->taModel->insert([
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            'semester'     => $this->request->getPost('semester'),
            'status'       => 'Nonaktif'
        ]);

        return redirect()->to('admin/tahun-akademik')->with('success', 'Tahun Akademik berhasil ditambah.');
    }

    public function setAktif($id)
    {
        // 1. Set semua jadi Nonaktif
        $this->taModel->where('id_tahun >', 0)->set(['status' => 'Nonaktif'])->update();

        // 2. Set ID terpilih jadi Aktif
        $this->taModel->update($id, ['status' => 'Aktif']);

        return redirect()->to('admin/tahun-akademik')->with('success', 'Tahun Akademik Aktif berhasil diubah.');
    }

    public function delete($id)
    {
        $data = $this->taModel->find($id);

        if (!$data) {
            return redirect()->to('admin/tahun-akademik')->with('error', 'Data tidak ditemukan.');
        }

        // PROTEKSI: Jangan hapus jika statusnya sedang AKTIF
        if ($data['status'] == 'Aktif') {
            return redirect()->to('admin/tahun-akademik')->with('error', 'Gagal! Tahun akademik yang sedang AKTIF tidak boleh dihapus.');
        }

        // PROTEKSI TAMBAHAN: Cek relasi (Contoh jika ada tabel KRS)
        // $krsExist = $this->db->table('tbl_krs')->where('id_tahun', $id)->countAllResults();
        // if ($krsExist > 0) { return redirect()->back()->with('error', 'Data digunakan di tabel KRS.'); }

        $this->taModel->delete($id);
        return redirect()->to('admin/tahun-akademik')->with('success', 'Data berhasil dihapus.');
    }
}
