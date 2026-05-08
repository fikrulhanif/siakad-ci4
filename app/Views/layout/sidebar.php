<?php
$role = session()->get('role');
$uri = uri_string(); // Ambil segment URL saat ini
?>

<aside class="main-sidebar">
    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $foto = session()->get('foto') ? base_url('uploads/profile/' . session()->get('foto')) : base_url('assets/dist/img/default.jpeg');
?>
                <img src="<?= $foto ?>" class="img-circle" alt="User Image" style="height: 45px; width: 45px; object-fit: cover;">
            </div>
            <div class="pull-left info">
                <p><?= session()->get('nama') ?? ucfirst(session()->get('username')) ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?= ucfirst(session()->get('role')) ?></a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li class="<?= ($uri == 'profile') ? 'active' : '' ?>">
                <a href="<?= base_url('profile') ?>"><i class="fa fa-user"></i> <span>Profil Saya</span></a>
            </li>

            <?php if ($role == 'admin'): ?>
                <li class="header">MASTER DATA</li>
                <li class="<?= ($uri == 'admin/dashboard') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="<?= ($uri == 'admin/prodi') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/prodi') ?>">
                        <i class="fa fa-university text-aqua"></i> <span>Prodi</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'admin/matakuliah') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/matakuliah') ?>">
                        <i class="fa fa-book text-green"></i> <span>Matakuliah</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'admin/dosen') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/dosen') ?>">
                        <i class="fa fa-user-md text-yellow"></i> <span>Dosen</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'admin/mahasiswa') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/mahasiswa') ?>">
                        <i class="fa fa-users text-purple"></i> <span>Mahasiswa</span>
                    </a>
                </li>

                <li class="header">SISTEM</li>
                <li class="<?= ($uri == 'admin/tahun-akademik') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/tahun-akademik') ?>">
                        <i class="fa fa-calendar-check-o text-red"></i> <span>Tahun Akademik</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'admin/jadwal') ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/jadwal') ?>">
                        <i class="fa fa-clock-o text-blue"></i> <span>Penjadwalan</span>
                    </a>
                </li>
                <li class="<?= (strpos($uri, 'admin/krs') !== false) ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/krs') ?>">
                        <i class="fa fa-list-alt text-orange"></i> <span>Kelola KRS</span>
                    </a>
                </li>
                <li class="<?= (strpos($uri, 'admin/user-management') !== false) ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/user-management') ?>">
                        <i class="fa fa-users text-purple"></i> <span>User Management</span>
                    </a>
                </li>

                <li class="header">LAPORAN</li>
                <li class="<?= (strpos($uri, 'admin/laporan') !== false) ? 'active' : '' ?>">
                    <a href="<?= site_url('admin/laporan') ?>">
                        <i class="fa fa-file-text text-red"></i> <span>Pusat Laporan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($role == 'dosen'): ?>
                <li class="header">MENU UTAMA</li>
                <li class="<?= ($uri == 'dosen/dashboard') ? 'active' : '' ?>">
                    <a href="<?= site_url('dosen/dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="<?= ($uri == 'dosen/matakuliah-diampu') ? 'active' : '' ?>">
                    <a href="<?= site_url('dosen/matakuliah-diampu') ?>">
                        <i class="fa fa-book"></i> <span>Mata Kuliah Diampu</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'dosen/bimbingan') ? 'active' : '' ?>">
                    <a href="<?= base_url('dosen/bimbingan') ?>"><i class="fa fa-users"></i> <span>Mahasiswa Bimbingan</span></a>
                </li>
                <li class="<?= ($uri == 'dosen/persetujuan-krs') ? 'active' : '' ?>">
                    <a href="<?= base_url('dosen/persetujuan-krs') ?>"><i class="fa fa-check-square-o"></i> <span>Persetujuan KRS</span></a>
                </li>
                <li class="<?= ($uri == 'dosen/nilai') ? 'active' : '' ?>">
                    <a href="<?= site_url('dosen/nilai') ?>"><i class="fa fa-pencil-square-o"></i> <span>Input Nilai</span></a>
                </li>
            <?php endif; ?>

            <?php if ($role == 'mahasiswa'): ?>
                <li class="header">MENU UTAMA</li>
                <li class="<?= ($uri == 'mahasiswa/dashboard') ? 'active' : '' ?>">
                    <a href="<?= site_url('mahasiswa/dashboard') ?>">
                        <i class="fa fa-dashboard text-aqua"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'mahasiswa/krs') ? 'active' : '' ?>">
                    <a href="<?= site_url('mahasiswa/krs') ?>">
                        <i class="fa fa-edit text-yellow"></i> <span>Kartu Rencana Studi (KRS)</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'mahasiswa/nilai') ? 'active' : '' ?>">
                    <a href="<?= site_url('mahasiswa/nilai') ?>">
                        <i class="fa fa-file-text-o text-green"></i> <span>Hasil Studi (KHS)</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'mahasiswa/transkrip') ? 'active' : '' ?>">
                    <a href="<?= site_url('mahasiswa/transkrip') ?>">
                        <i class="fa fa-graduation-cap text-red"></i> <span>Transkrip Nilai</span>
                    </a>
                </li>
                <li class="<?= ($uri == 'mahasiswa/daftar-kelas') ? 'active' : '' ?>">
                    <a href="<?= base_url('mahasiswa/daftar-kelas') ?>">
                        <i class="fa fa-list-alt"></i> <span>Informasi Daftar Kelas</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </section>
</aside>