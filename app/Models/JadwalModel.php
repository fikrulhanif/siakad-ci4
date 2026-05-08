<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id_jadwal';
    protected $allowedFields    = ['kd_mk', 'nidn', 'id_tahun', 'kelas', 'hari', 'jam', 'jam_selesai','ruang', 'kouta'];
}
