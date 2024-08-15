<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table         = 'berita';
    protected $allowedFields = ['judul', 'slug', 'deskripsi', 'viewer', 'gambar', 'user_id', 'kategori_id', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
