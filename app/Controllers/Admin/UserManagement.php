<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;

class UserManagement extends BaseController
{
    protected $userModel;
    protected $mahasiswaModel;
    protected $dosenModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->dosenModel = new DosenModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Get all users with their details
        $adminUsers = $this->db->table('users')
            ->where('role', 'admin')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        $mahasiswaUsers = $this->db->table('users')
            ->select('users.*, mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, mahasiswa.status, prodi.nama_prodi')
            ->join('mahasiswa', 'mahasiswa.id_user = users.id_user')
            ->join('prodi', 'prodi.id_prodi = mahasiswa.id_prodi', 'left')
            ->where('users.role', 'mahasiswa')
            ->orderBy('mahasiswa.nama_mhs', 'ASC')
            ->get()->getResultArray();

        $dosenUsers = $this->db->table('users')
            ->select('users.*, dosen.nidn, dosen.nama_dosen, prodi.nama_prodi')
            ->join('dosen', 'dosen.id_user = users.id_user')
            ->join('prodi', 'prodi.id_prodi = dosen.id_prodi', 'left')
            ->where('users.role', 'dosen')
            ->orderBy('dosen.nama_dosen', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title' => 'User Management',
            'adminUsers' => $adminUsers,
            'mahasiswaUsers' => $mahasiswaUsers,
            'dosenUsers' => $dosenUsers
        ];

        return view('admin/user_management/index', $data);
    }

    // ==================== ADMIN USERS ====================

    public function createAdmin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validation
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi!');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok!');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!');
        }

        // Check if username exists
        if ($this->userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        // Create admin user
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin'
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('admin/user-management')->with('success', 'Admin baru berhasil ditambahkan!');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan admin!');
    }

    public function deleteAdmin($id_user)
    {
        // Prevent deleting own account
        if ($id_user == session()->get('id_user')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        // Check if user is admin
        $user = $this->userModel->find($id_user);
        if (!$user || $user['role'] !== 'admin') {
            return redirect()->back()->with('error', 'User tidak ditemukan atau bukan admin!');
        }

        // Count remaining admins
        $adminCount = $this->userModel->where('role', 'admin')->countAllResults();
        if ($adminCount <= 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin terakhir!');
        }

        if ($this->userModel->delete($id_user)) {
            return redirect()->to('admin/user-management')->with('success', 'Admin berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menghapus admin!');
    }

    // ==================== RESET PASSWORD ====================

    public function resetPassword()
    {
        $id_user = $this->request->getPost('id_user');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validation
        if (empty($newPassword)) {
            return redirect()->back()->with('error', 'Password baru wajib diisi!');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok!');
        }

        if (strlen($newPassword) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!');
        }

        // Update password
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];

        if ($this->userModel->update($id_user, $data)) {
            return redirect()->to('admin/user-management')->with('success', 'Password berhasil direset!');
        }

        return redirect()->back()->with('error', 'Gagal mereset password!');
    }

    // ==================== CHANGE USERNAME ====================

    public function changeUsername()
    {
        $id_user = $this->request->getPost('id_user');
        $newUsername = $this->request->getPost('new_username');

        // Validation
        if (empty($newUsername)) {
            return redirect()->back()->with('error', 'Username baru wajib diisi!');
        }

        // Check if username exists (exclude current user)
        $existingUser = $this->userModel->where('username', $newUsername)
            ->where('id_user !=', $id_user)
            ->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        // Update username
        $data = ['username' => $newUsername];

        if ($this->userModel->update($id_user, $data)) {
            return redirect()->to('admin/user-management')->with('success', 'Username berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Gagal mengubah username!');
    }

    // ==================== TOGGLE STATUS ====================

    public function toggleStatus($id_user)
    {
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan!');
        }

        // Prevent disabling own account
        if ($id_user == session()->get('id_user')) {
            return redirect()->back()->with('error', 'Tidak dapat menonaktifkan akun sendiri!');
        }

        // For admin, prevent disabling last admin
        if ($user['role'] === 'admin') {
            $activeAdminCount = $this->userModel->where('role', 'admin')
                ->where('status', 'aktif')
                ->countAllResults();

            if ($activeAdminCount <= 1 && isset($user['status']) && $user['status'] === 'aktif') {
                return redirect()->back()->with('error', 'Tidak dapat menonaktifkan admin terakhir!');
            }
        }

        // Toggle status (if field exists)
        // Note: Based on the schema, users table doesn't have status field
        // We need to update mahasiswa/dosen table instead

        if ($user['role'] === 'mahasiswa') {
            $mhs = $this->mahasiswaModel->where('id_user', $id_user)->first();
            if ($mhs) {
                $newStatus = ($mhs['status'] === 'aktif') ? 'non-aktif' : 'aktif';
                $this->mahasiswaModel->update($mhs['nim'], ['status' => $newStatus]);
                return redirect()->to('admin/user-management')->with('success', 'Status mahasiswa berhasil diubah!');
            }
        } elseif ($user['role'] === 'dosen') {
            // Dosen table doesn't have status field in current schema
            return redirect()->back()->with('warning', 'Fitur status untuk dosen belum tersedia!');
        }

        return redirect()->back()->with('error', 'Gagal mengubah status!');
    }

    // ==================== BULK RESET PASSWORD ====================

    public function bulkResetPassword()
    {
        $role = $this->request->getPost('role');
        $defaultPassword = $this->request->getPost('default_password');

        if (empty($defaultPassword)) {
            return redirect()->back()->with('error', 'Password default wajib diisi!');
        }

        if (strlen($defaultPassword) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!');
        }

        $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

        // Update all users with specific role
        $this->db->table('users')
            ->where('role', $role)
            ->update(['password' => $hashedPassword]);

        $affected = $this->db->affectedRows();

        return redirect()->to('admin/user-management')
            ->with('success', "Password {$affected} user {$role} berhasil direset!");
    }
}
