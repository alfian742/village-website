<?php

namespace App\Models;

use CodeIgniter\Model;

class DataDusunModel extends Model
{
    protected $table         = 'data_dusun';
    protected $allowedFields = ['waktu', 'jumlah_lahir', 'jumlah_mati', 'jumlah_masuk', 'jumlah_keluar', 'dusun_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
