<?php

namespace App\Models;

use CodeIgniter\Model;

class MatakuliahModel extends Model
{
    protected $table            = 'matakuliah';
    protected $primaryKey       = 'kd_mk';
    protected $useAutoIncrement = false; // Karena kd_mk biasanya manual (mis: MK001)
    protected $allowedFields    = ['kd_mk', 'id_prodi', 'nama_mk', 'sks', 'smt','sifat'];
}
