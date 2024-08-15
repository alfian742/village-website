<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisKelaminModel extends Model
{
    protected $table         = 'jenis_kelamin';
    protected $allowedFields = ['jenis_kelamin', 'jumlah', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
