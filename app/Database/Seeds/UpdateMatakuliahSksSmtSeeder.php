<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateMatakuliahSksSmtSeeder extends Seeder
{
    public function run()
    {
        // Update SKS dan SMT untuk semua mata kuliah
        $updates = [
            // Semester 1
            ['kd_mk' => 'MK001', 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK002', 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK003', 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK004', 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK005', 'sks' => 2, 'smt' => 1],
            ['kd_mk' => 'MK006', 'sks' => 2, 'smt' => 1],
            ['kd_mk' => 'MK007', 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK008', 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK009', 'sks' => 1, 'smt' => 1],
            ['kd_mk' => 'MK010', 'sks' => 2, 'smt' => 1],
            ['kd_mk' => 'MK011', 'sks' => 3, 'smt' => 1],
            ['kd_mk' => 'MK012', 'sks' => 3, 'smt' => 1],

            // Semester 2
            ['kd_mk' => 'MK013', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK014', 'sks' => 1, 'smt' => 2],
            ['kd_mk' => 'MK015', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK016', 'sks' => 1, 'smt' => 2],
            ['kd_mk' => 'MK017', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK018', 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK019', 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK020', 'sks' => 2, 'smt' => 2],
            ['kd_mk' => 'MK021', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK022', 'sks' => 1, 'smt' => 2],
            ['kd_mk' => 'MK023', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK024', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK025', 'sks' => 3, 'smt' => 2],
            ['kd_mk' => 'MK026', 'sks' => 2, 'smt' => 2],

            // Semester 3
            ['kd_mk' => 'MK027', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK028', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK029', 'sks' => 1, 'smt' => 3],
            ['kd_mk' => 'MK030', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK031', 'sks' => 1, 'smt' => 3],
            ['kd_mk' => 'MK032', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK033', 'sks' => 2, 'smt' => 3],
            ['kd_mk' => 'MK034', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK035', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK036', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK037', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK038', 'sks' => 1, 'smt' => 3],
            ['kd_mk' => 'MK039', 'sks' => 3, 'smt' => 3],
            ['kd_mk' => 'MK040', 'sks' => 3, 'smt' => 3],

            // Semester 4
            ['kd_mk' => 'MK041', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK042', 'sks' => 1, 'smt' => 4],
            ['kd_mk' => 'MK043', 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK044', 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK045', 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK046', 'sks' => 2, 'smt' => 4],
            ['kd_mk' => 'MK047', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK048', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK049', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK050', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK051', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK052', 'sks' => 3, 'smt' => 4],
            ['kd_mk' => 'MK053', 'sks' => 3, 'smt' => 4],

            // Semester 5
            ['kd_mk' => 'MK054', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK055', 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK056', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK057', 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK058', 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK059', 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK060', 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK061', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK062', 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK063', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK064', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK065', 'sks' => 2, 'smt' => 5],
            ['kd_mk' => 'MK066', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK067', 'sks' => 1, 'smt' => 5],
            ['kd_mk' => 'MK068', 'sks' => 3, 'smt' => 5],
            ['kd_mk' => 'MK069', 'sks' => 3, 'smt' => 5],

            // Semester 6
            ['kd_mk' => 'MK070', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK071', 'sks' => 2, 'smt' => 6],
            ['kd_mk' => 'MK072', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK073', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK074', 'sks' => 1, 'smt' => 6],
            ['kd_mk' => 'MK075', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK076', 'sks' => 1, 'smt' => 6],
            ['kd_mk' => 'MK077', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK078', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK079', 'sks' => 4, 'smt' => 6],
            ['kd_mk' => 'MK080', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK081', 'sks' => 1, 'smt' => 6],
            ['kd_mk' => 'MK082', 'sks' => 3, 'smt' => 6],
            ['kd_mk' => 'MK083', 'sks' => 4, 'smt' => 6],
            ['kd_mk' => 'MK084', 'sks' => 6, 'smt' => 6],

            // Semester 7
            ['kd_mk' => 'MK085', 'sks' => 2, 'smt' => 7],
            ['kd_mk' => 'MK086', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK087', 'sks' => 1, 'smt' => 7],
            ['kd_mk' => 'MK088', 'sks' => 2, 'smt' => 7],
            ['kd_mk' => 'MK089', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK090', 'sks' => 1, 'smt' => 7],
            ['kd_mk' => 'MK091', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK092', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK093', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK094', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK095', 'sks' => 3, 'smt' => 7],
            ['kd_mk' => 'MK096', 'sks' => 3, 'smt' => 7],
        ];

        foreach ($updates as $update) {
            $this->db->table('matakuliah')
                ->where('kd_mk', $update['kd_mk'])
                ->update(['sks' => $update['sks'], 'smt' => $update['smt']]);
        }

        echo "✅ Berhasil update SKS dan SMT untuk " . count($updates) . " mata kuliah\n";
    }
}
