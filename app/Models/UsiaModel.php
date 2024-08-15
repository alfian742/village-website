<?php

namespace App\Models;

use CodeIgniter\Model;

class UsiaModel extends Model
{
    protected $table         = 'usia';
    protected $allowedFields = ['usia', 'jumlah', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
