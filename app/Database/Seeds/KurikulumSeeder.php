<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // TENTUKAN ID PRODI SESUAI DATABASE ANDA
        $idSI = 1; // ID untuk Sistem Informasi
        $idSK = 2; // ID untuk Sistem Komputer
        $idMI = 3; // ID untuk Manajemen Informatika

        $matkul = [
            // --- SEMESTER 1 (IRISAN/UMUM) ---
            ['kd_mk' => 'MK001', 'nama_mk' => 'Algoritma & Struktur Data 1', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK002', 'nama_mk' => 'Praktikum Algoritma & Struktur Data 1', 'sks' => 1, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK003', 'nama_mk' => 'Bahasa Pemrograman 1', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK004', 'nama_mk' => 'Praktikum Bahasa Pemrograman 1', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK005', 'nama_mk' => 'Bahasa Inggris 1', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK006', 'nama_mk' => 'Pengantar Teknologi Informasi', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK007', 'nama_mk' => 'Praktikum Pengantar Teknologi Informasi', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK008', 'nama_mk' => 'Sistem Basis Data 1', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK009', 'nama_mk' => 'Praktikum Sistem Basis Data 1', 'sks' => 1, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK010', 'nama_mk' => 'Pancasila dan Pendidikan Kewarganegaraan', 'sks' => 2, 'smt' => 1, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],

            // --- SEMESTER 1 (KHUSUS) ---
            ['kd_mk' => 'SI101', 'nama_mk' => 'Organisasi Dan Manajemen', 'sks' => 2, 'smt' => 1, 'id_prodi' => $idSI, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'SK101', 'nama_mk' => 'Logika Matematika', 'sks' => 2, 'smt' => 1, 'id_prodi' => $idSK, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'MI101', 'nama_mk' => 'Organisasi Dan Manajemen', 'sks' => 2, 'smt' => 1, 'id_prodi' => $idMI, 'sifat' => 'Wajib Prodi'],

            // --- SEMESTER 2 (UMUM) ---
            ['kd_mk' => 'MK011', 'nama_mk' => 'Algoritma & Struktur Data 2', 'sks' => 2, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK012', 'nama_mk' => 'Praktikum Algoritma & Struktur Data 2', 'sks' => 1, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK013', 'nama_mk' => 'Bahasa Pemrograman 2', 'sks' => 2, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK014', 'nama_mk' => 'Praktikum Bahasa Pemrograman 2', 'sks' => 2, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK015', 'nama_mk' => 'Bahasa Inggris 2', 'sks' => 2, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK016', 'nama_mk' => 'Sistem Basis Data 2', 'sks' => 2, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK017', 'nama_mk' => 'Praktikum Sistem Basis Data 2', 'sks' => 1, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
            ['kd_mk' => 'MK018', 'nama_mk' => 'Arsitektur dan Organisasi Komputer', 'sks' => 3, 'smt' => 2, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],

            // --- CONTOH KHUSUS LANJUTAN ---
            ['kd_mk' => 'SI401', 'nama_mk' => 'Analisa & Perancangan Sistem Informasi', 'sks' => 3, 'smt' => 4, 'id_prodi' => $idSI, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'SK601', 'nama_mk' => 'Dasar Robotika', 'sks' => 2, 'smt' => 6, 'id_prodi' => $idSK, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'SK602', 'nama_mk' => 'Praktikum Dasar Robotika', 'sks' => 2, 'smt' => 6, 'id_prodi' => $idSK, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'MI501', 'nama_mk' => 'Kewirausahaan IT', 'sks' => 2, 'smt' => 5, 'id_prodi' => $idMI, 'sifat' => 'Wajib Prodi'],
            ['kd_mk' => 'MK999', 'nama_mk' => 'Skripsi / Tugas Akhir', 'sks' => 6, 'smt' => 8, 'id_prodi' => null, 'sifat' => 'Wajib Umum'],
        ];

        foreach ($matkul as $data) {
            $db->table('matakuliah')->replace($data);
        }
    }
}
