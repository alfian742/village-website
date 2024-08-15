<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarBalasanPariwisataModel extends Model
{
    protected $table         = 'komentar_balasan_pariwisata';
    protected $allowedFields = ['nama', 'email', 'deskripsi', 'komentar_pariwisata_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
