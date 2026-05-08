<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    public function run()
    {
        // Data mata kuliah (sks & smt tidak dipakai lagi, semua di pivot table)
        $matakuliah = [
            // ========== SEMESTER 1 (SAMA UNTUK SEMUA PRODI) ==========
            ['kd_mk' => 'MK001', 'nama_mk' => 'Algoritma & Struktur Data 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK002', 'nama_mk' => 'Praktikum Algoritma & Struktur Data 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK003', 'nama_mk' => 'Bahasa Pemrograman 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK004', 'nama_mk' => 'Praktikum Bahasa Pemrograman 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK005', 'nama_mk' => 'Bahasa Inggris 1', 'id_prodi' => null, 'sks' => 2, 'smt' => 1],
            ['kd_mk' => 'MK006', 'nama_mk' => 'Pengantar Teknologi Informasi', 'id_prodi' => null, 'sks' => 2, 'smt' => 1],
            ['kd_mk' => 'MK007', 'nama_mk' => 'Praktikum Pengantar Teknologi Informasi', 'id_prodi' => null, 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK008', 'nama_mk' => 'Sistem Basis Data 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK009', 'nama_mk' => 'Praktikum Sistem Basis Data 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK010', 'nama_mk' => 'Pancasila dan Pendidikan Kewarganegaraan', 'id_prodi' => null, 'sks' => 2, 'smt' => 1],

            // Mata kuliah khusus semester 1
            ['kd_mk' => 'MK011', 'nama_mk' => 'Organisasi Dan Manajemen', 'id_prodi' => 1, 'sks' => 3, 'smt' => 1], // SI & MI
            ['kd_mk' => 'MK012', 'nama_mk' => 'Logika Matematika', 'id_prodi' => 2, 'sks' => 3, 'smt' => 1], // SK only

            // ========== SEMESTER 2 (SAMA UNTUK SEMUA PRODI) ==========
            ['kd_mk' => 'MK013', 'nama_mk' => 'Algoritma & Struktur Data 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK014', 'nama_mk' => 'Praktikum Algoritma & Struktur Data 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 2],
            ['kd_mk' => 'MK015', 'nama_mk' => 'Bahasa Pemrograman 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK016', 'nama_mk' => 'Praktikum Bahasa Pemrograman 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 2],
            ['kd_mk' => 'MK017', 'nama_mk' => 'Statistik', 'id_prodi' => null, 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK018', 'nama_mk' => 'Bahasa Inggris 2', 'id_prodi' => null, 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK019', 'nama_mk' => 'Agama', 'id_prodi' => null, 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK020', 'nama_mk' => 'Seni Budaya', 'id_prodi' => null, 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK021', 'nama_mk' => 'Sistem Basis Data 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK022', 'nama_mk' => 'Praktikum Sistem Basis Data 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 2],

            // Mata kuliah khusus semester 2
            ['kd_mk' => 'MK023', 'nama_mk' => 'Konsep Sistem Informasi', 'id_prodi' => 1, 'sks' => 3, 'smt' => 2], // SI & MI
            ['kd_mk' => 'MK024', 'nama_mk' => 'Elektronika Dasar', 'id_prodi' => 2, 'sks' => 3, 'smt' => 2], // SK only
            ['kd_mk' => 'MK025', 'nama_mk' => 'Sistem Digital', 'id_prodi' => 2, 'sks' => 3, 'smt' => 2], // SK only
            ['kd_mk' => 'MK026', 'nama_mk' => 'Bahasa Rakitan', 'id_prodi' => 2, 'sks' => 2, 'smt' => 2], // SK only

            // ========== SEMESTER 3 (SAMA UNTUK SEMUA PRODI) ==========
            ['kd_mk' => 'MK027', 'nama_mk' => 'Matematika', 'id_prodi' => null, 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK028', 'nama_mk' => 'Bahasa Pemrograman 3', 'id_prodi' => null, 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK029', 'nama_mk' => 'Praktikum Bahasa Pemrograman 3', 'id_prodi' => null, 'sks' => 1, 'smt' => 3],
            ['kd_mk' => 'MK030', 'nama_mk' => 'Jaringan Komputer 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK031', 'nama_mk' => 'Praktikum Jaringan Komputer 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 3],
            ['kd_mk' => 'MK032', 'nama_mk' => 'Sistem Operasi', 'id_prodi' => null, 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK033', 'nama_mk' => 'Bahasa Inggris 3', 'id_prodi' => null, 'sks' => 2, 'smt' => 3],

            // Mata kuliah khusus semester 3
            ['kd_mk' => 'MK034', 'nama_mk' => 'Manajemen Bisnis', 'id_prodi' => 1, 'sks' => 3, 'smt' => 3], // SI & MI
            ['kd_mk' => 'MK035', 'nama_mk' => 'Pemodelan Sistem Informasi', 'id_prodi' => 1, 'sks' => 3, 'smt' => 3], // SI & MI
            ['kd_mk' => 'MK036', 'nama_mk' => 'Analisa Proses Bisnis', 'id_prodi' => 1, 'sks' => 3, 'smt' => 3], // SI & MI
            ['kd_mk' => 'MK037', 'nama_mk' => 'Elektronika Lanjutan', 'id_prodi' => 2, 'sks' => 3, 'smt' => 3], // SK only
            ['kd_mk' => 'MK038', 'nama_mk' => 'Praktikum Elektronika Lanjutan', 'id_prodi' => 2, 'sks' => 1, 'smt' => 3], // SK only
            ['kd_mk' => 'MK039', 'nama_mk' => 'Fisika', 'id_prodi' => 2, 'sks' => 3, 'smt' => 3], // SK only
            ['kd_mk' => 'MK040', 'nama_mk' => 'Sistem Pengaturan', 'id_prodi' => 2, 'sks' => 3, 'smt' => 3], // SK only

            // ========== SEMESTER 4 (SAMA UNTUK SEMUA PRODI) ==========
            ['kd_mk' => 'MK041', 'nama_mk' => 'Pemrograman Web 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK042', 'nama_mk' => 'Praktikum Pemrograman Web 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 4],
            ['kd_mk' => 'MK043', 'nama_mk' => 'Bahasa Indonesia', 'id_prodi' => null, 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK044', 'nama_mk' => 'Komunikasi Interpersonal', 'id_prodi' => null, 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK045', 'nama_mk' => 'Metode Penelitian', 'id_prodi' => null, 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK046', 'nama_mk' => 'Bahasa Inggris 4', 'id_prodi' => null, 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK047', 'nama_mk' => 'Interaksi Manusia & Komputer', 'id_prodi' => null, 'sks' => 3, 'smt' => 4],

            // Mata kuliah khusus semester 4
            ['kd_mk' => 'MK048', 'nama_mk' => 'E-Commerce', 'id_prodi' => 1, 'sks' => 3, 'smt' => 4], // SI & MI
            ['kd_mk' => 'MK049', 'nama_mk' => 'Analisa & Perancangan Sistem Informasi', 'id_prodi' => 1, 'sks' => 3, 'smt' => 4], // SI & MI
            ['kd_mk' => 'MK050', 'nama_mk' => 'Akuntansi', 'id_prodi' => 1, 'sks' => 3, 'smt' => 4], // SI & MI
            ['kd_mk' => 'MK051', 'nama_mk' => 'Interfacing', 'id_prodi' => 2, 'sks' => 3, 'smt' => 4], // SK only
            ['kd_mk' => 'MK052', 'nama_mk' => 'Arsitektur dan Organisasi Komputer', 'id_prodi' => 2, 'sks' => 3, 'smt' => 4], // SK only
            ['kd_mk' => 'MK053', 'nama_mk' => 'Pemrosesan Paralel', 'id_prodi' => 2, 'sks' => 3, 'smt' => 4], // SK only

            // ========== SEMESTER 5 (SAMA UNTUK SEMUA PRODI) ==========
            ['kd_mk' => 'MK054', 'nama_mk' => 'Pemrograman Web 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK055', 'nama_mk' => 'Praktikum Pemrograman Web 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK056', 'nama_mk' => 'Pemrograman Client Server', 'id_prodi' => null, 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK057', 'nama_mk' => 'Praktikum Pemrograman Client Server', 'id_prodi' => null, 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK058', 'nama_mk' => 'Bahasa Inggris 5', 'id_prodi' => null, 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK059', 'nama_mk' => 'Kewirausahaan IT', 'id_prodi' => null, 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK060', 'nama_mk' => 'Etika Dan Hukum TI', 'id_prodi' => null, 'sks' => 2, 'smt' => 5],

            // Mata kuliah khusus semester 5
            ['kd_mk' => 'MK061', 'nama_mk' => 'Database Manajemen Sistem', 'id_prodi' => 1, 'sks' => 3, 'smt' => 5], // SI & MI
            ['kd_mk' => 'MK062', 'nama_mk' => 'Praktikum Database Manajemen Sistem', 'id_prodi' => 1, 'sks' => 1, 'smt' => 5], // SI & MI
            ['kd_mk' => 'MK063', 'nama_mk' => 'Komputer Akuntansi', 'id_prodi' => 1, 'sks' => 3, 'smt' => 5], // SI & MI
            ['kd_mk' => 'MK064', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'id_prodi' => 1, 'sks' => 3, 'smt' => 5], // SI only
            ['kd_mk' => 'MK065', 'nama_mk' => 'Seminar Penelitian', 'id_prodi' => 3, 'sks' => 2, 'smt' => 5], // MI only (semester 5)
            ['kd_mk' => 'MK066', 'nama_mk' => 'Sistem Tertanam', 'id_prodi' => 2, 'sks' => 3, 'smt' => 5], // SK only
            ['kd_mk' => 'MK067', 'nama_mk' => 'Praktikum Sistem Tertanam', 'id_prodi' => 2, 'sks' => 1, 'smt' => 5], // SK only
            ['kd_mk' => 'MK068', 'nama_mk' => 'Simulasi dan Pemodelan', 'id_prodi' => 2, 'sks' => 3, 'smt' => 5], // SK only
            ['kd_mk' => 'MK069', 'nama_mk' => 'Rekayasa Perangkat Keras', 'id_prodi' => 2, 'sks' => 3, 'smt' => 5], // SK only

            // ========== SEMESTER 6 (SI & SK) ==========
            ['kd_mk' => 'MK070', 'nama_mk' => 'Kecerdasan Tiruan', 'id_prodi' => null, 'sks' => 3, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK071', 'nama_mk' => 'Bahasa Inggris 6', 'id_prodi' => null, 'sks' => 2, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK072', 'nama_mk' => 'Keamanan Teknologi Informasi', 'id_prodi' => null, 'sks' => 3, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK073', 'nama_mk' => 'Jaringan Komputer 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK074', 'nama_mk' => 'Praktikum Jaringan Komputer 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK075', 'nama_mk' => 'Aplikasi Mobile 1', 'id_prodi' => null, 'sks' => 3, 'smt' => 6], // SI & SK
            ['kd_mk' => 'MK076', 'nama_mk' => 'Praktikum Aplikasi Mobile 1', 'id_prodi' => null, 'sks' => 1, 'smt' => 6], // SI & SK

            // Mata kuliah khusus semester 6
            ['kd_mk' => 'MK077', 'nama_mk' => 'Enterprise Architecture IT', 'id_prodi' => 1, 'sks' => 3, 'smt' => 6], // SI only
            ['kd_mk' => 'MK078', 'nama_mk' => 'Manajemen Resiko IT', 'id_prodi' => 1, 'sks' => 3, 'smt' => 6], // SI only
            ['kd_mk' => 'MK079', 'nama_mk' => 'Proyek Aplikasi Sistem Informasi', 'id_prodi' => 1, 'sks' => 4, 'smt' => 6], // SI only
            ['kd_mk' => 'MK080', 'nama_mk' => 'Dasar Robotika', 'id_prodi' => 2, 'sks' => 3, 'smt' => 6], // SK only
            ['kd_mk' => 'MK081', 'nama_mk' => 'Praktikum Dasar Robotika', 'id_prodi' => 2, 'sks' => 1, 'smt' => 6], // SK only
            ['kd_mk' => 'MK082', 'nama_mk' => 'Mobile Networking', 'id_prodi' => 2, 'sks' => 3, 'smt' => 6], // SK only

            // MI Semester 6 (PKL & TA)
            ['kd_mk' => 'MK083', 'nama_mk' => 'Praktek Kerja Lapangan', 'id_prodi' => null, 'sks' => 4, 'smt' => 6], // Semua prodi
            ['kd_mk' => 'MK084', 'nama_mk' => 'Tugas Akhir', 'id_prodi' => null, 'sks' => 6, 'smt' => 6], // Semua prodi

            // ========== SEMESTER 7 (SI & SK) ==========
            ['kd_mk' => 'MK085', 'nama_mk' => 'Seminar Penelitian', 'id_prodi' => null, 'sks' => 2, 'smt' => 7], // SI & SK (semester 7)
            ['kd_mk' => 'MK086', 'nama_mk' => 'Data & Teknologi Multimedia', 'id_prodi' => null, 'sks' => 3, 'smt' => 7], // SI & SK
            ['kd_mk' => 'MK087', 'nama_mk' => 'Praktikum Data & Teknologi Multimedia', 'id_prodi' => null, 'sks' => 1, 'smt' => 7], // SI & SK
            ['kd_mk' => 'MK088', 'nama_mk' => 'Bahasa Inggris 7', 'id_prodi' => null, 'sks' => 2, 'smt' => 7], // SI & SK
            ['kd_mk' => 'MK089', 'nama_mk' => 'Aplikasi Mobile 2', 'id_prodi' => null, 'sks' => 3, 'smt' => 7], // SI & SK
            ['kd_mk' => 'MK090', 'nama_mk' => 'Praktikum Aplikasi Mobile 2', 'id_prodi' => null, 'sks' => 1, 'smt' => 7], // SI & SK

            // Mata kuliah khusus semester 7
            ['kd_mk' => 'MK091', 'nama_mk' => 'Enterprise Information System', 'id_prodi' => 1, 'sks' => 3, 'smt' => 7], // SI only
            ['kd_mk' => 'MK092', 'nama_mk' => 'IT Service Management', 'id_prodi' => 1, 'sks' => 3, 'smt' => 7], // SI only
            ['kd_mk' => 'MK093', 'nama_mk' => 'Sistem Penunjang Keputusan', 'id_prodi' => 1, 'sks' => 3, 'smt' => 7], // SI only
            ['kd_mk' => 'MK094', 'nama_mk' => 'Jaringan Syaraf Tiruan', 'id_prodi' => 2, 'sks' => 3, 'smt' => 7], // SK only
            ['kd_mk' => 'MK095', 'nama_mk' => 'Instrumentasi', 'id_prodi' => 2, 'sks' => 3, 'smt' => 7], // SK only
            ['kd_mk' => 'MK096', 'nama_mk' => 'Robot Vision', 'id_prodi' => 2, 'sks' => 3, 'smt' => 7], // SK only
        ];

        // Insert data
        foreach ($matakuliah as $mk) {
            $this->db->table('matakuliah')->insert($mk);
        }
    }
}
