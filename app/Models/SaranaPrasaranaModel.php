<?php

namespace App\Models;

use CodeIgniter\Model;

class SaranaPrasaranaModel extends Model
{
    protected $table         = 'sarana_prasarana';
    protected $allowedFields = ['nama', 'slug', 'deskripsi', 'gambar', 'viewer', 'user_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
