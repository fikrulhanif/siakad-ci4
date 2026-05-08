<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table            = 'dosen';
    protected $primaryKey       = 'nidn';
    protected $useAutoIncrement = false; // NIDN biasanya diinput manual
    protected $allowedFields    = ['nidn', 'id_user', 'id_prodi', 'nama_dosen','nik', 'tempat_lahir', 'tgl_lahir', 'jenkel', 'agama', 'no_hp', 'email', 'alamat'];
}
