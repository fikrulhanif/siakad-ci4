<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCatatanPaToKrs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('krs', [
            'catatan_pa' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status_krs'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('krs', 'catatan_pa');
    }
}
