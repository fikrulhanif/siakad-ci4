<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TahunAkademik extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahun' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 9
            ],
            'semester' => [
                'type' => 'ENUM',
                'constraint' => ['Ganjil','Genap']
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif','Nonaktif']
            ]
        ]);

        $this->forge->addKey('id_tahun', true);
        $this->forge->createTable('tahun_akademik', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('tahun_akademik');
    }
}
