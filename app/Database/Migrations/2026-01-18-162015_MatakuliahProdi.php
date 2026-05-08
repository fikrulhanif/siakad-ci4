<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MatakuliahProdi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'kd_mk' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'Kode mata kuliah'
            ],
            'id_prodi' => [
                'type' => 'INT',
                'unsigned' => true,
                'comment' => 'ID Prodi yang bisa akses mata kuliah ini'
            ],
            'smt_prodi' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => true,
                'comment' => 'Semester di prodi ini (bisa beda dengan smt di tabel matakuliah)'
            ],
            'is_wajib' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'comment' => '1=Wajib, 0=Pilihan untuk prodi ini'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kd_mk', 'matakuliah', 'kd_mk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');

        // Unique constraint: satu mata kuliah tidak bisa didaftarkan 2x untuk prodi yang sama
        $this->forge->addUniqueKey(['kd_mk', 'id_prodi']);

        $this->forge->createTable('matakuliah_prodi', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('matakuliah_prodi');
    }
}
