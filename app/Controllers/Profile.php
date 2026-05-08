<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');

        $builder = $this->db->table('users');

        if ($role == 'mahasiswa') {
            $builder->select('users.*, mahasiswa.*, mahasiswa.nama_mhs as nama, prodi.nama_prodi');
            $builder->join('mahasiswa', 'mahasiswa.id_user = users.id_user');
            $builder->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi');
        } elseif ($role == 'dosen') {
            $builder->select('users.*, dosen.*, dosen.nama_dosen as nama, prodi.nama_prodi');
            $builder->join('dosen', 'dosen.id_user = users.id_user');
            $builder->join('prodi', 'prodi.id_prodi = dosen.id_prodi');
        } else {
            $builder->select('users.*');
        }

        $userData = $builder->where('users.id_user', $id_user)->get()->getRowArray();

        $data = [
            'title' => 'Profil Saya',
            'user'  => $userData
        ];
        return view('profile/index', $data);
    }

    public function updateBiodata()
    {
        $id_user = session()->get('id_user');
        $role = session()->get('role');

        $dataUpdate = [
            'nik'           => $this->request->getPost('nik'),
            'tempat_lahir'  => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'jenkel'        => $this->request->getPost('jenkel'),
            'agama'         => $this->request->getPost('agama'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'alamat'        => $this->request->getPost('alamat'),
        ];

        if ($role == 'mahasiswa') {
            $this->db->table('mahasiswa')->where('id_user', $id_user)->update($dataUpdate);
        } elseif ($role == 'dosen') {
            $this->db->table('dosen')->where('id_user', $id_user)->update($dataUpdate);
        }

        return redirect()->to('profile')->with('success', 'Biodata berhasil diperbarui!');
    }

    public function updateFoto()
    {
        $file = $this->request->getFile('foto');
        $id_user = session()->get('id_user');

        if ($file->isValid() && !$file->hasMoved()) {
            // Beri nama unik agar tidak bentrok
            $newName = $file->getRandomName();
            $file->move('uploads/profile/', $newName);

            // Hapus foto lama jika ada (opsional)
            $oldUser = $this->userModel->find($id_user);
            if ($oldUser['foto'] && file_exists('uploads/profile/' . $oldUser['foto'])) {
                unlink('uploads/profile/' . $oldUser['foto']);
            }

            // Simpan ke database
            $this->userModel->update($id_user, ['foto' => $newName]);

            // Update session foto agar langsung berubah tanpa relogin
            session()->set('foto', $newName);

            return redirect()->to('profile')->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal upload foto.');
    }

    public function updatePassword()
    {
        $id_user = session()->get('id_user');
        $user = $this->userModel->find($id_user);

        $pass_lama = $this->request->getPost('pass_lama');
        $pass_baru = $this->request->getPost('pass_baru');
        $konfirmasi = $this->request->getPost('konfirmasi');

        // 1. Validasi Password Lama
        if (!password_verify($pass_lama, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai!');
        }

        // 2. Validasi Password Baru & Konfirmasi
        if ($pass_baru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok!');
        }

        // 3. Update Password
        $this->userModel->update($id_user, [
            'password' => password_hash($pass_baru, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('profile')->with('success', 'Password berhasil diperbarui!');
    }
}
