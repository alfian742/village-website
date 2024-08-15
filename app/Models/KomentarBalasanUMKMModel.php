<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarBalasanUMKMModel extends Model
{
    protected $table         = 'komentar_balasan_umkm';
    protected $allowedFields = ['nama', 'email', 'deskripsi', 'komentar_umkm_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
