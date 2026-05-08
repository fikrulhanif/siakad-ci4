<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAkademikModel extends Model
{
    protected $table            = 'tahun_akademik';
    protected $primaryKey       = 'id_tahun';
    protected $allowedFields    = ['tahun_ajaran', 'semester', 'status'];
}
