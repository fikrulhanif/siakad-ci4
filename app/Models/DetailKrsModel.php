<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailKrsModel extends Model
{
    protected $table            = 'detail_krs';
    protected $primaryKey       = 'id_detail';
    protected $allowedFields    = ['id_krs', 'id_jadwal'];
}
