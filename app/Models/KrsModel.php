<?php

namespace App\Models;

use CodeIgniter\Model;

class KrsModel extends Model
{
    protected $table            = 'krs';
    protected $primaryKey       = 'id_krs';
    protected $allowedFields    = ['nim', 'id_tahun', 'tgl_krs'];
}
