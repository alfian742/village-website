<?php

namespace App\Models;

use CodeIgniter\Model;

class AgamaModel extends Model
{
    protected $table         = 'agama';
    protected $allowedFields = ['agama', 'jumlah', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
