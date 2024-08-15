<?php

namespace App\Models;

use CodeIgniter\Model;

class GeografisModel extends Model
{
    protected $table         = 'geografis';
    protected $allowedFields = ['lokasi', 'luas', 'timur', 'barat', 'selatan', 'utara', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
