<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nilai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_nilai' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_detail' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'nilai_angka' => [
                'type' => 'FLOAT'
            ],
            'nilai_huruf' => [
                'type'       => 'CHAR',
                'constraint' => 2
            ]
        ]);

        $this->forge->addKey('id_nilai', true);
        $this->forge->addForeignKey('id_detail', 'detail_krs', 'id_detail', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nilai', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('nilai');
    }
}
