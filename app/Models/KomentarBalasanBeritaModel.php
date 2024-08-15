<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarBalasanBeritaModel extends Model
{
    protected $table         = 'komentar_balasan_berita';
    protected $allowedFields = ['nama', 'email', 'deskripsi', 'komentar_berita_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
