<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Matakuliah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kd_mk' => ['type' => 'VARCHAR','constraint' => 20],
            'id_prodi' => ['type' => 'INT','unsigned' => true],
            'nama_mk' => ['type' => 'VARCHAR','constraint' => 100],
            'sks' => ['type' => 'INT','constraint' => 2],
            'smt' => ['type' => 'INT','constraint' => 2],
            'sifat' => [
                'type' => 'ENUM',
                'constraint' => ['Wajib Umum','Wajib Prodi','Pilihan']
            ]
        ]);

        $this->forge->addKey('kd_mk', true);
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi');
        $this->forge->createTable('matakuliah', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('matakuliah');
    }
}
