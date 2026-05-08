<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailKrs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'id_krs' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'id_jadwal' => [
                'type'     => 'INT',
                'unsigned' => true
            ]
        ]);

        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('id_krs', 'krs', 'id_krs', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_krs', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('detail_krs');
    }
}
