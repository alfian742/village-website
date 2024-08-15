<?php

namespace App\Models;

use CodeIgniter\Model;

class TentangDesaModel extends Model
{
    protected $table         = 'tentang';
    protected $allowedFields = ['tentang_desa', 'visi', 'misi', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
