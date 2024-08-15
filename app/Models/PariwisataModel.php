<?php

namespace App\Models;

use CodeIgniter\Model;

class PariwisataModel extends Model
{
    protected $table         = 'pariwisata';
    protected $allowedFields = ['judul', 'slug', 'deskripsi', 'viewer', 'gambar', 'user_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
