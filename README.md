#  Portal Akademik (SIAKAD)

Sistem Informasi Akademik berbasis web yang dibangun menggunakan CodeIgniter 4 dengan template AdminLTE. Sistem ini dirancang untuk mengelola kegiatan akademik perguruan tinggi dengan 3 role utama: Admin, Dosen, dan Mahasiswa.

![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-red)
![License](https://img.shields.io/badge/License-MIT-green)

##  Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Struktur Database](#-struktur-database)
- [Role & Hak Akses](#-role--hak-akses)
- [Screenshot](#-screenshot)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

##  Fitur Utama

###  Admin

- **Dashboard**: Statistik lengkap (jumlah mahasiswa, dosen, mata kuliah, prodi)
- **Manajemen Data Master**:
  - Program Studi (Prodi)
  - Tahun Akademik
  - Mata Kuliah
  - Dosen
  - Mahasiswa
  - Jadwal Kuliah
- **Manajemen KRS**: Monitoring dan persetujuan KRS mahasiswa
- **Laporan**: Generate laporan akademik
- **User Management**: Kelola akun pengguna sistem

###  Dosen

- **Dashboard**: Ringkasan jadwal mengajar dan mahasiswa bimbingan
- **Jadwal Mengajar**: Lihat jadwal kuliah yang diampu
- **Mahasiswa Bimbingan**:
  - Daftar mahasiswa bimbingan akademik
  - Monitoring IPK dan progress studi
  - Riwayat nilai mahasiswa
- **Persetujuan KRS**: Approve/reject KRS mahasiswa bimbingan
- **Input Nilai**: Entry nilai mahasiswa per mata kuliah
- **Cetak Absensi**: Generate daftar hadir mahasiswa

###  Mahasiswa

- **Dashboard**:
  - Informasi akademik (IPK, SKS lulus, semester)
  - Grafik perkembangan IPS per semester
  - Jadwal kuliah hari ini
- **Pengisian KRS**:
  - Pilih mata kuliah sesuai semester
  - Lihat kuota dan jadwal kelas
  - Submit KRS untuk persetujuan dosen PA
- **Lihat Nilai**: Transkrip nilai dan riwayat akademik
- **Jadwal Kuliah**: Lihat jadwal kuliah lengkap per minggu

## 🛠 Tech Stack

### Backend

- **Framework**: CodeIgniter 4.x
- **PHP**: 8.1 atau lebih tinggi
- **Database**: MySQL/MariaDB

### Frontend

- **Template**: AdminLTE 3.x
- **CSS Framework**: Bootstrap 4
- **JavaScript**: jQuery
- **Charts**: Chart.js (untuk grafik statistik)
- **Icons**: Font Awesome

### Additional Libraries

- **DataTables**: Untuk tabel interaktif
- **Select2**: Enhanced select boxes
- **DatePicker**: Bootstrap Datepicker

##  Persyaratan Sistem

- PHP >= 8.1
- MySQL >= 5.7 atau MariaDB >= 10.3
- Apache/Nginx Web Server
- Composer
- PHP Extensions:
  - `intl`
  - `mbstring`
  - `mysqli`
  - `json`
  - `curl`

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/portal-akademik.git
cd portal-akademik
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env` dan sesuaikan konfigurasi:

```bash
cp env .env
```

Edit file `.env`:

```env
CI_ENVIRONMENT = development

# Database Configuration
database.default.hostname = localhost
database.default.database = db_akademikv2
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306

# Base URL
app.baseURL = 'http://localhost:8080/'
```

### 4. Setup Database

#### Opsi A: Import SQL File (Recommended)

```bash
# Import database yang sudah ada
mysql -u root -p db_akademikv2 < db_akademikv2.sql
```

#### Opsi B: Menggunakan Migration

```bash
# Jalankan migration
php spark migrate

# Jalankan seeder untuk data awal
php spark db:seed UserSeeder
php spark db:seed MatakuliahSeeder
php spark db:seed JadwalSeeder
```

### 5. Set Permissions

Pastikan folder `writable` memiliki permission yang tepat:

```bash
# Linux/Mac
chmod -R 777 writable/

# Windows (jalankan sebagai Administrator)
icacls writable /grant Users:F /t
```

### 6. Jalankan Aplikasi

#### Development Server

```bash
php spark serve
```

Akses aplikasi di: `http://localhost:8080`

#### Production (Apache/Nginx)

Arahkan document root ke folder `public/`

**Apache `.htaccess` sudah tersedia di folder `public/`**

## ⚙️ Konfigurasi

### Database

Edit konfigurasi database di `app/Config/Database.php` atau melalui file `.env`

### Routes

Konfigurasi routing ada di `app/Config/Routes.php`

### Filters (Middleware)

- **AuthFilter**: Memastikan user sudah login
- **RoleFilter**: Membatasi akses berdasarkan role (admin/dosen/mahasiswa)

Konfigurasi filter di `app/Config/Filters.php`

##  Struktur Database

### Tabel Utama

- `users` - Data akun pengguna
- `prodi` - Program Studi
- `tahun_akademik` - Tahun Akademik & Semester
- `dosen` - Data Dosen
- `mahasiswa` - Data Mahasiswa
- `matakuliah` - Mata Kuliah
- `matakuliah_prodi` - Relasi Mata Kuliah dengan Prodi (Pivot Table)
- `jadwal` - Jadwal Kuliah
- `krs` - Kartu Rencana Studi
- `detail_krs` - Detail mata kuliah dalam KRS
- `nilai` - Nilai Mahasiswa

### Relasi Database

```
users (1) -----> (1) mahasiswa/dosen
prodi (1) -----> (N) mahasiswa
dosen (1) -----> (N) mahasiswa (sebagai PA/Wali)
dosen (1) -----> (N) jadwal
matakuliah (N) <-----> (N) prodi (via matakuliah_prodi)
jadwal (1) -----> (N) detail_krs
krs (1) -----> (N) detail_krs
detail_krs (1) -----> (1) nilai
```

##  Role & Hak Akses

### Default Login Credentials

Setelah instalasi, gunakan kredensial berikut:

**Admin**

- Username: `admin`
- Password: `admin123`

**Dosen**

- Username: `dosen1` (atau sesuai NIDN)
- Password: `password`

**Mahasiswa**

- Username: `mahasiswa1` (atau sesuai NIM)
- Password: `password`

### Middleware & RBAC

Sistem menggunakan Role-Based Access Control (RBAC) dengan middleware:

- Routes dengan prefix `/admin/*` hanya bisa diakses oleh role `admin`
- Routes dengan prefix `/dosen/*` hanya bisa diakses oleh role `dosen`
- Routes dengan prefix `/mahasiswa/*` hanya bisa diakses oleh role `mahasiswa`

Implementasi ada di `app/Filters/RoleFilter.php`

##  Struktur Folder

```
portal-akademik/
├── app/
│   ├── Config/          # Konfigurasi aplikasi
│   ├── Controllers/     # Controller (Admin, Dosen, Mahasiswa)
│   ├── Models/          # Model database
│   ├── Views/           # View templates
│   ├── Filters/         # Middleware (Auth, Role)
│   └── Database/
│       ├── Migrations/  # Database migrations
│       └── Seeds/       # Database seeders
├── public/              # Public assets (CSS, JS, images)
│   ├── assets/          # AdminLTE template assets
│   └── index.php        # Entry point
├── writable/            # Cache, logs, uploads
├── system/              # CodeIgniter 4 core
├── .env                 # Environment configuration
├── composer.json        # PHP dependencies
└── spark                # CLI tool
```

##  Development

### Menjalankan Migration

```bash
# Jalankan semua migration
php spark migrate

# Rollback migration
php spark migrate:rollback

# Refresh (rollback + migrate)
php spark migrate:refresh
```

### Menjalankan Seeder

```bash
# Jalankan seeder tertentu
php spark db:seed UserSeeder

# Jalankan semua seeder
php spark db:seed
```

### Debugging

Set environment ke `development` di file `.env`:

```env
CI_ENVIRONMENT = development
```

Aktifkan debug toolbar di `app/Config/Toolbar.php`

##  Troubleshooting

### Error: "Class not found"

```bash
composer dump-autoload
```

### Error: "Unable to connect to database"

Pastikan:

- MySQL service berjalan
- Kredensial database di `.env` benar
- Database sudah dibuat

### Error: "Writable directory not writable"

```bash
# Linux/Mac
chmod -R 777 writable/

# Windows (run as Administrator)
icacls writable /grant Users:F /t
```

## 📄 Lisensi

Project ini menggunakan lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail.

---

**Catatan**: Ini adalah project akademik/pembelajaran. Untuk penggunaan production, pastikan melakukan security hardening dan testing yang memadai.

---

 Jika project ini bermanfaat, jangan lupa berikan star!
