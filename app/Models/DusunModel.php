<?php

namespace App\Models;

use CodeIgniter\Model;

class DusunModel extends Model
{
    protected $table         = 'dusun';
    protected $allowedFields = ['nama_dusun', 'slug', 'deskripsi', 'gambar', 'luas', 'timur', 'barat', 'selatan', 'utara', 'kepala_dusun_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
