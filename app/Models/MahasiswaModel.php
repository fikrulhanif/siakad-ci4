<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'nim',
        'id_user',
        'id_prodi',
        'nama_mhs',
        'jenkel',
        'angkatan',
        'status',
        'nidn_wali',
        'nik',
        'tempat_lahir',
        'tgl_lahir','agama',
        'no_hp',
        'email',
        'alamat'
    ];

    protected $useTimestamps = false;
}
