<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarPariwisataModel extends Model
{
    protected $table         = 'komentar_pariwisata';
    protected $allowedFields = ['nama', 'email', 'rating', 'deskripsi', 'pariwisata_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
