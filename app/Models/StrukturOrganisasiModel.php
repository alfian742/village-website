<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturOrganisasiModel extends Model
{
    protected $table         = 'struktur_organisasi';
    protected $allowedFields = ['gambar', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
