<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarUMKMModel extends Model
{
    protected $table         = 'komentar_umkm';
    protected $allowedFields = ['nama', 'email', 'rating', 'deskripsi', 'umkm_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
