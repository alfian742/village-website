<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table         = 'kategori';
    protected $allowedFields = ['kategori', 'slug', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
