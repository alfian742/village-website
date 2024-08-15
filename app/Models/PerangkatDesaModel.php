<?php

namespace App\Models;

use CodeIgniter\Model;

class PerangkatDesaModel extends Model
{
    protected $table         = 'perangkat_desa';
    protected $allowedFields = ['nama', 'jabatan', 'nip', 'deskripsi', 'foto', 'staff_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
