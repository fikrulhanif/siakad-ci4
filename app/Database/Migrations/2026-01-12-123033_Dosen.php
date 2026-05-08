<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dosen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nidn' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'id_prodi' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'nama_dosen' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'nik' => ['type' => 'VARCHAR','constraint' => 20],
            'tempat_lahir' => ['type' => 'VARCHAR','constraint' => 100],
            'tgl_lahir' => ['type' => 'DATE'],
            'jenkel' => [
                'type' => 'ENUM',
                'constraint' => ['L','P']
            ],
            'agama' => ['type' => 'VARCHAR','constraint' => 20],
            'no_hp' => ['type' => 'VARCHAR','constraint' => 20],
            'email' => ['type' => 'VARCHAR','constraint' => 100],
            'alamat' => ['type' => 'TEXT']
        ]);

        $this->forge->addKey('nidn', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dosen', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('dosen');
    }
}
