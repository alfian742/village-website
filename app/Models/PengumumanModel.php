<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table         = 'pengumuman';
    protected $allowedFields = ['judul', 'slug', 'deskripsi', 'viewer', 'user_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
