<?php

namespace App\Models;

use CodeIgniter\Model;

class KepalaDusunModel extends Model
{
    protected $table         = 'kepala_dusun';
    protected $allowedFields = ['nama', 'nip', 'deskripsi', 'foto', 'staff_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
