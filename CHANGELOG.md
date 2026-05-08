# 📝 Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned Features

- Export laporan ke Excel/PDF
- Notifikasi email untuk persetujuan KRS
- Dashboard analytics yang lebih detail
- Mobile responsive optimization
- API REST untuk integrasi eksternal

---

## [1.0.0] - 2026-05-08

###  Initial Release

Portal Akademik (SIAKAD) versi pertama dengan fitur lengkap untuk manajemen akademik perguruan tinggi.

###  Added

#### Admin Features

- Dashboard dengan statistik lengkap
  - Jumlah mahasiswa, dosen, mata kuliah, prodi
  - Grafik mahasiswa per prodi
  - Grafik mahasiswa per angkatan
  - Statistik KRS (approved, pending, rejected)
  - Aktivitas terbaru
- Manajemen Data Master
  - CRUD Program Studi
  - CRUD Tahun Akademik (dengan status aktif)
  - CRUD Mata Kuliah
  - CRUD Dosen
  - CRUD Mahasiswa
  - Relasi Mata Kuliah dengan Prodi (pivot table)
- Manajemen Jadwal Kuliah
  - CRUD Jadwal
  - Filter per semester dan prodi
  - Validasi bentrok jadwal
  - Kuota kelas
- Manajemen KRS
  - Monitoring KRS mahasiswa
  - Approve/Reject KRS
  - Lihat detail mata kuliah per KRS
- Laporan Akademik
  - Laporan mahasiswa per prodi
  - Laporan KRS per semester
  - Laporan nilai
- User Management
  - CRUD User
  - Role-based access (Admin, Dosen, Mahasiswa)

#### Dosen Features

- Dashboard Dosen
  - Ringkasan jadwal mengajar
  - Statistik mahasiswa bimbingan (IPK rendah, baik, sangat baik)
  - Jadwal mengajar dalam bentuk grid
  - Notifikasi KRS pending
- Jadwal Mengajar
  - Lihat semua mata kuliah yang diampu
  - Jumlah mahasiswa per kelas
  - Detail peserta mata kuliah
- Mahasiswa Bimbingan
  - Daftar mahasiswa bimbingan akademik
  - Monitoring IPK dan total SKS
  - Semester mahasiswa
  - Status KRS pending
  - Grouping per angkatan
- Riwayat Nilai Mahasiswa
  - Lihat nilai mahasiswa bimbingan per semester
  - Perhitungan IP per semester
  - Perhitungan IPK kumulatif
- Persetujuan KRS
  - Approve/Reject KRS mahasiswa bimbingan
  - Lihat detail mata kuliah yang diambil
  - Catatan penolakan
  - Informasi IPK dan IPS mahasiswa
- Input Nilai
  - Entry nilai per mata kuliah
  - Nilai huruf (A, B, C, D, E)
  - Nilai angka
  - Bulk input untuk semua mahasiswa
- Cetak Absensi
  - Generate daftar hadir mahasiswa
  - Format print-friendly
  - Kolom tanda tangan

#### Mahasiswa Features

- Dashboard Mahasiswa
  - Informasi akademik (IPK, SKS lulus, semester)
  - Grafik perkembangan IPS per semester (Chart.js)
  - Jadwal kuliah hari ini
  - Jadwal kuliah mingguan (grid view)
  - Status KRS semester aktif
  - Alert jika profil belum lengkap
- Pengisian KRS
  - Pilih mata kuliah sesuai semester
  - Filter per semester
  - Lihat kuota dan sisa slot kelas
  - Lihat jadwal (hari, jam, ruangan, dosen)
  - Validasi bentrok jadwal
  - Submit KRS untuk persetujuan PA
  - Lihat status KRS (Pending, Approved, Rejected)
  - Lihat catatan penolakan dari PA
- Lihat Nilai
  - Transkrip nilai lengkap
  - Nilai per semester
  - IP per semester
  - IPK kumulatif
  - Total SKS lulus
- Jadwal Kuliah
  - Lihat jadwal lengkap per minggu
  - Informasi dosen pengampu
  - Informasi ruangan dan waktu
- Profile Management
  - Update data pribadi
  - Upload foto profil

#### Authentication & Authorization

- Login system dengan role-based access
- Session management
- AuthFilter middleware
- RoleFilter middleware (RBAC)
- Redirect berdasarkan role setelah login
- Logout functionality

#### Database

- 12 Migration files
  - users
  - prodi
  - tahun_akademik
  - dosen
  - mahasiswa
  - matakuliah
  - matakuliah_prodi (pivot table)
  - jadwal
  - krs
  - detail_krs
  - nilai
- Database seeders
  - UserSeeder
  - MatakuliahSeeder
  - JadwalSeeder
  - KurikulumSeeder

#### UI/UX

- AdminLTE 3 template
- Responsive design (Bootstrap 4)
- DataTables untuk tabel interaktif
- Select2 untuk dropdown
- DatePicker untuk input tanggal
- Chart.js untuk grafik
- Font Awesome icons
- SweetAlert2 untuk notifikasi
- Loading indicators

#### Documentation

- README.md - Dokumentasi lengkap project
- QUICKSTART.md - Panduan instalasi cepat
- SETUP_GIT.md - Panduan Git & GitHub
- PRE_PUSH_CHECKLIST.md - Checklist sebelum push
- CONTRIBUTING.md - Panduan kontribusi
- START_HERE.md - Panduan navigasi dokumentasi
- CHANGELOG.md - Catatan perubahan
- .env.example - Template environment configuration

#### Configuration

- .gitignore - Comprehensive gitignore rules
- Environment configuration (.env)
- Database configuration
- Routes configuration
- Filters configuration
- Security configuration

###  Security

- Password hashing
- CSRF protection
- XSS protection dengan esc() helper
- SQL injection prevention (Query Builder)
- Session security
- Input validation
- Role-based access control (RBAC)
- Environment variables untuk kredensial

###  Design Patterns

- MVC (Model-View-Controller)
- Repository pattern (Models)
- Middleware pattern (Filters)
- Template inheritance (Views)
- Dependency injection

###  Business Logic

- Perhitungan IPK dan IPS
  - Bobot nilai: A=4, B=3, C=2, D=1, E=0
  - SKS lulus: nilai minimal D
  - IPK: rata-rata tertimbang semua semester
  - IPS: rata-rata tertimbang per semester
- Perhitungan semester mahasiswa
  - Berdasarkan angkatan dan tahun akademik aktif
  - Semester ganjil: (tahun - angkatan) \* 2 + 1
  - Semester genap: (tahun - angkatan) \* 2 + 2
- Validasi KRS
  - Cek bentrok jadwal
  - Cek kuota kelas
  - Cek mata kuliah sudah diambil
- Status KRS workflow
  - Pending → Approved/Rejected
  - Hanya KRS Approved yang bisa dinilai

### 🛠 Technical Stack

- **Backend**: CodeIgniter 4.x
- **PHP**: 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: AdminLTE 3, Bootstrap 4, jQuery
- **Charts**: Chart.js
- **Tables**: DataTables
- **Icons**: Font Awesome
- **Package Manager**: Composer

---

## Version History

### Version Numbering

Format: `MAJOR.MINOR.PATCH`

- **MAJOR**: Breaking changes
- **MINOR**: New features (backward compatible)
- **PATCH**: Bug fixes (backward compatible)

### Release Notes

- **v1.0.0** (2026-05-08): Initial release with complete SIAKAD features

---

## Future Roadmap

### v1.1.0 (Planned)

- [ ] Export laporan ke Excel
- [ ] Export laporan ke PDF
- [ ] Email notification untuk KRS approval
- [ ] Forgot password functionality
- [ ] Profile photo upload

### v1.2.0 (Planned)

- [ ] API REST untuk mobile app
- [ ] Advanced analytics dashboard
- [ ] Attendance management
- [ ] Online payment integration

### v2.0.0 (Future)

- [ ] Multi-tenant support
- [ ] E-learning integration
- [ ] Video conference integration
- [ ] Mobile app (React Native)

---

## License

Project ini menggunakan lisensi MIT. Lihat [LICENSE](LICENSE) untuk detail.

---

**Note**: Changelog ini mengikuti format [Keep a Changelog](https://keepachangelog.com/).

[Unreleased]: https://github.com/username/portal-akademik/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/username/portal-akademik/releases/tag/v1.0.0
