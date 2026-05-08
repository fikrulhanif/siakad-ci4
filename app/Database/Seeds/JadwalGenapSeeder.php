<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalGenapSeeder extends Seeder
{
    public function run()
    {
        $nidn = '123'; // NIDN dosen default`
        $id_tahun = 6; // ID tahun akademik GENAP

        // Daftar hari
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Daftar ruang
        $ruangTeori = ['Lokal 1', 'Lokal 2', 'Aula'];
        $ruangPraktikum = ['Lab 1', 'Lab 2', 'Lab Elektro'];

        // Jam kuliah (08:00 - 16:00)
        $jamMulai = ['08:00', '10:00', '13:00', '15:00'];

        $jadwal = [];
        $hariIndex = 0;
        $jamIndex = 0;
        $ruangTeoriIndex = 0;
        $ruangPraktikumIndex = 0;

        // Ambil mata kuliah SEMESTER GENAP (2, 4, 6, 8)
        $db = \Config\Database::connect();
        $matakuliah = $db->table('matakuliah')
            ->whereIn('smt', [2, 4, 6, 8])
            ->orderBy('smt', 'ASC')
            ->orderBy('kd_mk', 'ASC')
            ->get()->getResultArray();

        foreach ($matakuliah as $mk) {
            $isPraktikum = (stripos($mk['nama_mk'], 'praktikum') !== false);
            $sks = (int)$mk['sks'];

            // Hitung durasi (1 SKS = 50 menit)
            $durasi = $sks * 50;
            $jamMulaiStr = $jamMulai[$jamIndex % count($jamMulai)];
            $jamSelesai = date('H:i', strtotime($jamMulaiStr) + ($durasi * 60));

            if ($isPraktikum) {
                // PRAKTIKUM: Buat 2 jadwal (Kelas A & B)

                // Kelas A
                $jadwal[] = [
                    'kd_mk' => $mk['kd_mk'],
                    'nidn' => $nidn,
                    'id_tahun' => $id_tahun,
                    'kelas' => 'A',
                    'hari' => $hari[$hariIndex % count($hari)],
                    'jam' => $jamMulaiStr,
                    'jam_selesai' => $jamSelesai,
                    'ruang' => $ruangPraktikum[$ruangPraktikumIndex % count($ruangPraktikum)],
                    'kouta' => 30
                ];

                // Kelas B (hari yang sama, jam berbeda)
                $jamIndexB = ($jamIndex + 1) % count($jamMulai);
                $jamMulaiStrB = $jamMulai[$jamIndexB];
                $jamSelesaiB = date('H:i', strtotime($jamMulaiStrB) + ($durasi * 60));

                $jadwal[] = [
                    'kd_mk' => $mk['kd_mk'],
                    'nidn' => $nidn,
                    'id_tahun' => $id_tahun,
                    'kelas' => 'B',
                    'hari' => $hari[$hariIndex % count($hari)],
                    'jam' => $jamMulaiStrB,
                    'jam_selesai' => $jamSelesaiB,
                    'ruang' => $ruangPraktikum[($ruangPraktikumIndex + 1) % count($ruangPraktikum)],
                    'kouta' => 30
                ];

                $ruangPraktikumIndex += 2;

            } else {
                // TEORI: Buat 1 jadwal (Kelas A)
                $jadwal[] = [
                    'kd_mk' => $mk['kd_mk'],
                    'nidn' => $nidn,
                    'id_tahun' => $id_tahun,
                    'kelas' => 'A',
                    'hari' => $hari[$hariIndex % count($hari)],
                    'jam' => $jamMulaiStr,
                    'jam_selesai' => $jamSelesai,
                    'ruang' => $ruangTeori[$ruangTeoriIndex % count($ruangTeori)],
                    'kouta' => 40
                ];

                $ruangTeoriIndex++;
            }

            // Rotate hari dan jam
            $jamIndex++;
            if ($jamIndex % 2 == 0) { // Setiap 2 mata kuliah, ganti hari
                $hariIndex++;
            }
        }

        // Insert data
        foreach ($jadwal as $j) {
            $this->db->table('jadwal')->insert($j);
        }

        echo "✅ Berhasil insert " . count($jadwal) . " jadwal untuk SEMESTER GENAP (2, 4, 6, 8)\n";
    }
}
