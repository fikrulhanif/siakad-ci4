<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\MahasiswaModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'dosen':
                return '/dosen/dashboard';
            case 'mahasiswa':
                return '/mahasiswa/dashboard';
            default:
                return '/login';
        }
    }

    public function process()
    {
        $userModel = new \App\Models\UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Username atau password salah');
        }

        // --- TAMBAHKAN FOTO KE SINI ---
        $sessionData = [
            'id_user'   => $user['id_user'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'foto'      => $user['foto'], // <--- Ambil kolom foto dari tabel users
            'logged_in' => true
        ];

        // Jika Admin, set nama default agar tidak kosong di sidebar
        if ($user['role'] === 'admin') {
            $sessionData['nama'] = 'Administrator';
        }

        // Jika Mahasiswa, ambil NIM dan Nama
        if ($user['role'] === 'mahasiswa') {
            $mhsModel = new \App\Models\MahasiswaModel();
            $mhs = $mhsModel->where('id_user', $user['id_user'])->first();
            if (!$mhs) {
                return redirect()->back()->with('error', 'Profil Mahasiswa belum dibuat oleh Admin');
            }
            $sessionData['nim'] = $mhs['nim'];
            $sessionData['nama'] = $mhs['nama_mhs'];
        }

        // Jika Dosen, ambil NIDN dan Nama
        if ($user['role'] === 'dosen') {
            $dosenModel = new \App\Models\DosenModel();
            $dosen = $dosenModel->where('id_user', $user['id_user'])->first();
            if (!$dosen) {
                return redirect()->back()->with('error', 'Profil Dosen belum dibuat oleh Admin');
            }
            $sessionData['nidn'] = $dosen['nidn'];
            $sessionData['nama'] = $dosen['nama_dosen'];
        }

        session()->set($sessionData);
        return redirect()->to($this->redirectByRole($user['role']));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
