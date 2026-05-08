<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatakuliahProdiSeeder extends Seeder
{
    public function run()
    {
        /**
         * Mapping mata kuliah ke prodi dengan semester yang sesuai
         *
         * Prodi:
         * 1 = Sistem Informasi (S1 - 8 semester)
         * 2 = Sistem Komputer (S1 - 8 semester)
         * 3 = Manajemen Informatika (D3 - 6 semester)
         */

        $data = [];

        // ========== SEMESTER 1 (SAMA UNTUK SEMUA PRODI) ==========
        $semester1_umum = ['MK001', 'MK002', 'MK003', 'MK004', 'MK005', 'MK006', 'MK007', 'MK008', 'MK009', 'MK010'];
        foreach ($semester1_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 1, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 1, 'is_wajib' => 1]; // SK
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 3, 'smt_prodi' => 1, 'is_wajib' => 1]; // MI
        }

        // Organisasi Dan Manajemen - SI & MI only
        $data[] = ['kd_mk' => 'MK011', 'id_prodi' => 1, 'smt_prodi' => 1, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK011', 'id_prodi' => 3, 'smt_prodi' => 1, 'is_wajib' => 1];

        // Logika Matematika - SK only
        $data[] = ['kd_mk' => 'MK012', 'id_prodi' => 2, 'smt_prodi' => 1, 'is_wajib' => 1];

        // ========== SEMESTER 2 (SAMA UNTUK SEMUA PRODI) ==========
        $semester2_umum = ['MK013', 'MK014', 'MK015', 'MK016', 'MK017', 'MK018', 'MK019', 'MK020', 'MK021', 'MK022'];
        foreach ($semester2_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 2, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 2, 'is_wajib' => 1]; // SK
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 3, 'smt_prodi' => 2, 'is_wajib' => 1]; // MI
        }

        // Konsep Sistem Informasi - SI & MI only
        $data[] = ['kd_mk' => 'MK023', 'id_prodi' => 1, 'smt_prodi' => 2, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK023', 'id_prodi' => 3, 'smt_prodi' => 2, 'is_wajib' => 1];

        // Elektronika & Sistem Digital - SK only
        $data[] = ['kd_mk' => 'MK024', 'id_prodi' => 2, 'smt_prodi' => 2, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK025', 'id_prodi' => 2, 'smt_prodi' => 2, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK026', 'id_prodi' => 2, 'smt_prodi' => 2, 'is_wajib' => 1];

        // ========== SEMESTER 3 (SAMA UNTUK SEMUA PRODI) ==========
        $semester3_umum = ['MK027', 'MK028', 'MK029', 'MK030', 'MK031', 'MK032', 'MK033'];
        foreach ($semester3_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 3, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 3, 'is_wajib' => 1]; // SK
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 3, 'smt_prodi' => 3, 'is_wajib' => 1]; // MI
        }

        // Manajemen Bisnis & Pemodelan SI - SI & MI only
        $data[] = ['kd_mk' => 'MK034', 'id_prodi' => 1, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK034', 'id_prodi' => 3, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK035', 'id_prodi' => 1, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK035', 'id_prodi' => 3, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK036', 'id_prodi' => 1, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK036', 'id_prodi' => 3, 'smt_prodi' => 3, 'is_wajib' => 1];

        // Elektronika Lanjutan & Fisika - SK only
        $data[] = ['kd_mk' => 'MK037', 'id_prodi' => 2, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK038', 'id_prodi' => 2, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK039', 'id_prodi' => 2, 'smt_prodi' => 3, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK040', 'id_prodi' => 2, 'smt_prodi' => 3, 'is_wajib' => 1];

        // ========== SEMESTER 4 (SAMA UNTUK SEMUA PRODI) ==========
        $semester4_umum = ['MK041', 'MK042', 'MK043', 'MK044', 'MK045', 'MK046', 'MK047'];
        foreach ($semester4_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 4, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 4, 'is_wajib' => 1]; // SK
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 3, 'smt_prodi' => 4, 'is_wajib' => 1]; // MI
        }

        // E-Commerce & Analisa SI - SI & MI only
        $data[] = ['kd_mk' => 'MK048', 'id_prodi' => 1, 'smt_prodi' => 4, 'is_wajib' => 0]; // Pilihan
        $data[] = ['kd_mk' => 'MK048', 'id_prodi' => 3, 'smt_prodi' => 4, 'is_wajib' => 0]; // Pilihan
        $data[] = ['kd_mk' => 'MK049', 'id_prodi' => 1, 'smt_prodi' => 4, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK049', 'id_prodi' => 3, 'smt_prodi' => 4, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK050', 'id_prodi' => 1, 'smt_prodi' => 4, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK050', 'id_prodi' => 3, 'smt_prodi' => 4, 'is_wajib' => 1];

        // Interfacing & Arsitektur Komputer - SK only
        $data[] = ['kd_mk' => 'MK051', 'id_prodi' => 2, 'smt_prodi' => 4, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK052', 'id_prodi' => 2, 'smt_prodi' => 4, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK053', 'id_prodi' => 2, 'smt_prodi' => 4, 'is_wajib' => 1];

        // ========== SEMESTER 5 (SAMA UNTUK SEMUA PRODI) ==========
        $semester5_umum = ['MK054', 'MK055', 'MK056', 'MK057', 'MK058', 'MK059', 'MK060'];
        foreach ($semester5_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 5, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 5, 'is_wajib' => 1]; // SK
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 3, 'smt_prodi' => 5, 'is_wajib' => 1]; // MI
        }

        // Database Management - SI & MI only
        $data[] = ['kd_mk' => 'MK061', 'id_prodi' => 1, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK061', 'id_prodi' => 3, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK062', 'id_prodi' => 1, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK062', 'id_prodi' => 3, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK063', 'id_prodi' => 1, 'smt_prodi' => 5, 'is_wajib' => 0]; // Pilihan
        $data[] = ['kd_mk' => 'MK063', 'id_prodi' => 3, 'smt_prodi' => 5, 'is_wajib' => 0]; // Pilihan

        // Rekayasa Perangkat Lunak - SI only
        $data[] = ['kd_mk' => 'MK064', 'id_prodi' => 1, 'smt_prodi' => 5, 'is_wajib' => 1];

        // Seminar Penelitian - MI semester 5
        $data[] = ['kd_mk' => 'MK065', 'id_prodi' => 3, 'smt_prodi' => 5, 'is_wajib' => 1];

        // Sistem Tertanam & Simulasi - SK only
        $data[] = ['kd_mk' => 'MK066', 'id_prodi' => 2, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK067', 'id_prodi' => 2, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK068', 'id_prodi' => 2, 'smt_prodi' => 5, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK069', 'id_prodi' => 2, 'smt_prodi' => 5, 'is_wajib' => 1];

        // ========== SEMESTER 6 ==========
        // Mata kuliah umum semester 6 (SI & SK only, MI sudah PKL & TA)
        $semester6_umum = ['MK070', 'MK071', 'MK072', 'MK073', 'MK074', 'MK075', 'MK076'];
        foreach ($semester6_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 6, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 6, 'is_wajib' => 1]; // SK
        }

        // Enterprise Architecture - SI only
        $data[] = ['kd_mk' => 'MK077', 'id_prodi' => 1, 'smt_prodi' => 6, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK078', 'id_prodi' => 1, 'smt_prodi' => 6, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK079', 'id_prodi' => 1, 'smt_prodi' => 6, 'is_wajib' => 1];

        // Robotika - SK only
        $data[] = ['kd_mk' => 'MK080', 'id_prodi' => 2, 'smt_prodi' => 6, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK081', 'id_prodi' => 2, 'smt_prodi' => 6, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK082', 'id_prodi' => 2, 'smt_prodi' => 6, 'is_wajib' => 0]; // Pilihan

        // PKL & TA - MI semester 6
        $data[] = ['kd_mk' => 'MK083', 'id_prodi' => 3, 'smt_prodi' => 6, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK084', 'id_prodi' => 3, 'smt_prodi' => 6, 'is_wajib' => 1];

        // ========== SEMESTER 7 (SI & SK only) ==========
        $semester7_umum = ['MK085', 'MK086', 'MK087', 'MK088', 'MK089', 'MK090'];
        foreach ($semester7_umum as $kd_mk) {
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 1, 'smt_prodi' => 7, 'is_wajib' => 1]; // SI
            $data[] = ['kd_mk' => $kd_mk, 'id_prodi' => 2, 'smt_prodi' => 7, 'is_wajib' => 1]; // SK
        }

        // Enterprise IS & IT Service - SI only
        $data[] = ['kd_mk' => 'MK091', 'id_prodi' => 1, 'smt_prodi' => 7, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK092', 'id_prodi' => 1, 'smt_prodi' => 7, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK093', 'id_prodi' => 1, 'smt_prodi' => 7, 'is_wajib' => 1];

        // Jaringan Syaraf & Robot Vision - SK only
        $data[] = ['kd_mk' => 'MK094', 'id_prodi' => 2, 'smt_prodi' => 7, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK095', 'id_prodi' => 2, 'smt_prodi' => 7, 'is_wajib' => 0]; // Pilihan
        $data[] = ['kd_mk' => 'MK096', 'id_prodi' => 2, 'smt_prodi' => 7, 'is_wajib' => 1];

        // ========== SEMESTER 8 (SI & SK only) ==========
        // PKL & TA - SI & SK semester 8
        $data[] = ['kd_mk' => 'MK083', 'id_prodi' => 1, 'smt_prodi' => 8, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK084', 'id_prodi' => 1, 'smt_prodi' => 8, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK083', 'id_prodi' => 2, 'smt_prodi' => 8, 'is_wajib' => 1];
        $data[] = ['kd_mk' => 'MK084', 'id_prodi' => 2, 'smt_prodi' => 8, 'is_wajib' => 1];

        // Insert batch
        $this->db->table('matakuliah_prodi')->insertBatch($data);

        echo "✅ Berhasil insert " . count($data) . " relasi mata kuliah-prodi\n";
    }
}
