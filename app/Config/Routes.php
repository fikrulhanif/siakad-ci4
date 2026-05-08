<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

// AUTH
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');

// Setup Profile, Upload Foto, Ganti Password
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/updatePassword', 'Profile::updatePassword');
    $routes->post('profile/updateFoto', 'Profile::updateFoto');
    $routes->post('profile/updateBiodata', 'Profile::updateBiodata');
});

// ADMIN
$routes->group('admin', [
    'filter' => ['auth', 'role:admin']
], function ($routes) {
    // Menu Admin
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Master Prodi
    $routes->get('prodi', 'Admin\Prodi::index');
    $routes->post('prodi/store', 'Admin\Prodi::store');
    $routes->post('prodi/update/(:num)', 'Admin\Prodi::update/$1');
    $routes->get('prodi/delete/(:num)', 'Admin\Prodi::delete/$1');

    // Master Matakuliah
    $routes->get('matakuliah', 'Admin\Matakuliah::index');
    $routes->post('matakuliah/store', 'Admin\Matakuliah::store');
    $routes->post('matakuliah/update/(:segment)', 'Admin\Matakuliah::update/$1');
    $routes->get('matakuliah/delete/(:segment)', 'Admin\Matakuliah::delete/$1');

    // Master Dosen
    $routes->get('dosen', 'Admin\Dosen::index');
    $routes->post('dosen/store', 'Admin\Dosen::store');
    $routes->post('dosen/update/(:segment)', 'Admin\Dosen::update/$1');
    $routes->get('dosen/delete/(:segment)', 'Admin\Dosen::delete/$1');

    // Master Mahasiswa
    $routes->get('mahasiswa', 'Admin\Mahasiswa::index');
    $routes->post('mahasiswa/store', 'Admin\Mahasiswa::store');
    $routes->post('mahasiswa/update/(:segment)', 'Admin\Mahasiswa::update/$1');
    $routes->get('mahasiswa/delete/(:segment)', 'Admin\Mahasiswa::delete/$1');

    // Atur Tahun Akademik
    $routes->get('tahun-akademik', 'Admin\TahunAkademik::index');
    $routes->post('tahun-akademik/store', 'Admin\TahunAkademik::store');
    $routes->get('tahun-akademik/delete/(:num)', 'Admin\TahunAkademik::delete/$1');
    $routes->get('tahun-akademik/set-aktif/(:num)', 'Admin\TahunAkademik::setAktif/$1');

    // Atur Jadwal
    $routes->get('jadwal', 'Admin\Jadwal::index');
    $routes->get('jadwal/create', 'Admin\Jadwal::create');
    $routes->post('jadwal/store', 'Admin\Jadwal::store');
    $routes->get('jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');
    $routes->get('jadwal/copy_jadwal', 'Admin\Jadwal::copy_jadwal');
    $routes->post('jadwal/update/(:num)', 'Admin\Jadwal::update/$1');

    // Kelola KRS
    $routes->get('krs', 'Admin\Krs::index');
    $routes->get('krs/detail/(:num)', 'Admin\Krs::detail/$1');
    $routes->get('krs/create', 'Admin\Krs::create');
    $routes->post('krs/pilih_matakuliah', 'Admin\Krs::pilih_matakuliah');
    $routes->post('krs/store', 'Admin\Krs::store');
    $routes->get('krs/delete_item/(:num)', 'Admin\Krs::delete_item/$1');
    $routes->post('krs/update_status/(:num)', 'Admin\Krs::update_status/$1');
    $routes->get('krs/delete/(:num)', 'Admin\Krs::delete/$1');

    // User Management
    $routes->get('user-management', 'Admin\UserManagement::index');
    $routes->post('user-management/create-admin', 'Admin\UserManagement::createAdmin');
    $routes->get('user-management/delete-admin/(:num)', 'Admin\UserManagement::deleteAdmin/$1');
    $routes->post('user-management/reset-password', 'Admin\UserManagement::resetPassword');
    $routes->post('user-management/change-username', 'Admin\UserManagement::changeUsername');
    $routes->get('user-management/toggle-status/(:num)', 'Admin\UserManagement::toggleStatus/$1');
    $routes->post('user-management/bulk-reset-password', 'Admin\UserManagement::bulkResetPassword');

    // Cetak Laporan
    $routes->get('laporan', 'Admin\Laporan::index');
    // Laporan Mahasiswa
    $routes->get('laporan/mahasiswa', 'Admin\Laporan::mahasiswa');
    $routes->post('laporan/preview-mahasiswa', 'Admin\Laporan::preview_mahasiswa');
    $routes->post('laporan/print-mahasiswa', 'Admin\Laporan::print_mahasiswa');
    // Laporan Dosen
    $routes->get('laporan/dosen', 'Admin\Laporan::dosen');
    // Laporan Jadwal
    $routes->get('laporan/jadwal', 'Admin\Laporan::jadwal');
    $routes->post('laporan/preview-jadwal', 'Admin\Laporan::preview_jadwal');
    $routes->post('laporan/print-jadwal', 'Admin\Laporan::print_jadwal');
    // Laporan Matakuliah
    $routes->get('laporan/matakuliah', 'Admin\Laporan::matakuliah');
    $routes->post('laporan/preview-matakuliah', 'Admin\Laporan::preview_matakuliah');
    $routes->post('laporan/print-matakuliah', 'Admin\Laporan::print_matakuliah');
    // Rekapitulasi KRS
    $routes->get('laporan/krs', 'Admin\Laporan::krs');
    $routes->post('laporan/preview-krs', 'Admin\Laporan::preview_krs');
    $routes->post('laporan/print-krs', 'Admin\Laporan::print_krs');
    // Rekapitulasi Indeks Prestasi (IP)
    $routes->get('laporan/nilai', 'Admin\Laporan::nilai');
    $routes->post('laporan/preview-nilai', 'Admin\Laporan::preview_nilai');
    $routes->post('laporan/print-nilai', 'Admin\Laporan::print_nilai');
    // Rekapitulasi Nilai Per Matkul
    $routes->get('laporan/nilai-mk', 'Admin\Laporan::nilai_matakuliah');
    $routes->post('laporan/preview-nilai-mk', 'Admin\Laporan::preview_nilaimk');
    $routes->post('laporan/print-nilai-mk', 'Admin\Laporan::print_nilaimk');
    $routes->post('laporan/get_jadwal_by_filter', 'Admin\Laporan::get_jadwal_by_filter');
});


// DOSEN
$routes->group('dosen', [
    'filter' => ['auth', 'role:dosen']
], function ($routes) {
    // Menu Dosen
    $routes->get('dashboard', 'Dosen\Dashboard::index');

    $routes->get('matakuliah-diampu', 'Dosen\Dashboard::matakuliah_diampu');

    // Lihat Mahasiswa Bimbingan
    $routes->get('bimbingan', 'Dosen\Dashboard::bimbingan');
    $routes->get('bimbingan/nilai/(:any)', 'Dosen\Dashboard::detail_nilai/$1');

    // Acc Krs
    $routes->get('persetujuan-krs', 'Dosen\Dashboard::persetujuanKrs');
    $routes->get('acc-krs/(:num)', 'Dosen\Dashboard::accKrs/$1');

    // Tolak Krs
    $routes->get('reject-krs/(:num)', 'Dosen\Dashboard::rejectKrs/$1');
    $routes->post('reject-krs/(:num)', 'Dosen\Dashboard::rejectKrs/$1');

    // Input Nilai
    $routes->get('nilai', 'Dosen\Nilai::index');
    $routes->get('nilai/input/(:num)', 'Dosen\Nilai::input/$1');
    $routes->post('nilai/store', 'Dosen\Nilai::store');

    // Cetak Absen
    $routes->get('detail-matakuliah/(:num)', 'Dosen\Dashboard::detail_matakuliah/$1');
    $routes->get('print-absensi/(:num)', 'Dosen\Dashboard::print_absensi/$1');
});

// MAHASISWA
$routes->group('mahasiswa', [
    'filter' => ['auth', 'role:mahasiswa']
], function ($routes) {
    // Menu Mahasiswa
    $routes->get('dashboard', 'Mahasiswa\Dashboard::index');

    // Ambil Krs
    $routes->get('krs', 'Mahasiswa\Krs::index');
    $routes->get('krs/create', 'Mahasiswa\Krs::create');
    $routes->post('krs/store', 'Mahasiswa\Krs::store');
    $routes->get('krs/(:num)', 'Mahasiswa\Krs::detail/$1');
    $routes->get('krs/delete_item/(:num)', 'Mahasiswa\Krs::delete_item/$1');
    $routes->get('krs/resubmit/(:num)', 'Mahasiswa\Krs::resubmit/$1');

    // Lihat Nilai (t)erdapat 2 versi tampilan)
    //$routes->get('nilai', 'Mahasiswa\Krs::nilai');
    $routes->get('nilai', 'Mahasiswa\Nilai::index');

    // Transkrip Nilai
    $routes->get('transkrip', 'Mahasiswa\Nilai::transkrip');

    // Lihat Daftar Kelas
    $routes->get('daftar-kelas', 'Mahasiswa\Dashboard::daftar_kelas');

    // Cetak
    $routes->get('nilai/print/(:any)', 'Mahasiswa\Nilai::print_khs/$1');
    $routes->get('transkrip/print', 'Mahasiswa\Nilai::print_transkrip');
    $routes->get('krs/print/(:any)', 'Mahasiswa\Nilai::print_krs/$1');
});
