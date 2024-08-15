<?php

namespace App\Models;

use CodeIgniter\Model;

class SitusModel extends Model
{
    protected $table         = 'situs';
    protected $allowedFields = ['nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'logo', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
