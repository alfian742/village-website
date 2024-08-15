<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanModel extends Model
{
    protected $table         = 'pekerjaan';
    protected $allowedFields = ['pekerjaan', 'jumlah', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
