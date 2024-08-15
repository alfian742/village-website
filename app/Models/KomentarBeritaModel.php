<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarBeritaModel extends Model
{
    protected $table         = 'komentar_berita';
    protected $allowedFields = ['nama', 'email', 'deskripsi', 'berita_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
