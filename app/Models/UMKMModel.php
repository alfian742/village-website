<?php

namespace App\Models;

use CodeIgniter\Model;

class UMKMModel extends Model
{
    protected $table         = 'umkm';
    protected $allowedFields = ['nama', 'slug', 'pemilik', 'nomor_hp', 'instagram', 'harga', 'deskripsi', 'viewer', 'gambar', 'user_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
