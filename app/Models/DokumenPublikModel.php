<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenPublikModel extends Model
{
    protected $table         = 'dokumen_publik';
    protected $allowedFields = ['nama', 'tipe', 'ukuran', 'berkas', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
