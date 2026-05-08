<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Krs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_krs' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => 20
            ],
            'id_tahun' => [
                'type'     => 'INT',
                'unsigned' => true
            ],
            'tgl_krs' => [
                'type' => 'DATE'
            ],
            'status_krs' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending','Approved','Rejected'],
                'default'    => 'Pending'
            ]
        ]);

        $this->forge->addKey('id_krs', true);
        $this->forge->addForeignKey('nim', 'mahasiswa', 'nim', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tahun', 'tahun_akademik', 'id_tahun', 'CASCADE', 'CASCADE');
        $this->forge->createTable('krs', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('krs');
    }
}
