<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'kd_mk' => ['type' => 'VARCHAR','constraint' => 20],
            'nidn' => ['type' => 'VARCHAR','constraint' => 20],
            'id_tahun' => ['type' => 'INT','unsigned' => true],
            'kelas' => ['type' => 'VARCHAR','constraint' => 10],
            'hari' => ['type' => 'VARCHAR','constraint' => 20],
            'jam' => ['type' => 'TIME'],
            'jam_selesai' => ['type' => 'TIME'],
            'ruang' => ['type' => 'VARCHAR','constraint' => 50],
            'kouta' => ['type' => 'INT']
        ]);

        $this->forge->addKey('id_jadwal', true);
        $this->forge->addForeignKey('kd_mk', 'matakuliah', 'kd_mk');
        $this->forge->addForeignKey('nidn', 'dosen', 'nidn');
        $this->forge->addForeignKey('id_tahun', 'tahun_akademik', 'id_tahun');
        $this->forge->createTable('jadwal', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
