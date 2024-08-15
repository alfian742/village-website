<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table         = 'layanan';
    protected $allowedFields = ['nama_layanan', 'slug', 'deskripsi', 'viewer', 'user_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
