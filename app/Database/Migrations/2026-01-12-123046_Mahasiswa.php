<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nim' => ['type' => 'VARCHAR','constraint' => 20],
            'id_user' => ['type' => 'INT','unsigned' => true],
            'id_prodi' => ['type' => 'INT','unsigned' => true],
            'nama_mhs' => ['type' => 'VARCHAR','constraint' => 100],
            'jenkel' => ['type' => 'ENUM','constraint' => ['L','P']],
            'angkatan' => ['type' => 'YEAR'],
            'status' => ['type' => 'ENUM','constraint' => ['aktif','nonaktif']],
            'nidn_wali' => ['type' => 'VARCHAR','constraint' => 20],
            'nik' => ['type' => 'VARCHAR','constraint' => 20],
            'tempat_lahir' => ['type' => 'VARCHAR','constraint' => 100],
            'tgl_lahir' => ['type' => 'DATE'],
            'agama' => ['type' => 'VARCHAR','constraint' => 20],
            'no_hp' => ['type' => 'VARCHAR','constraint' => 20],
            'email' => ['type' => 'VARCHAR','constraint' => 100],
            'alamat' => ['type' => 'TEXT']
        ]);

        $this->forge->addKey('nim', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi');
        $this->forge->addForeignKey('nidn_wali', 'dosen', 'nidn');
        $this->forge->createTable('mahasiswa', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('mahasiswa');
    }
}
