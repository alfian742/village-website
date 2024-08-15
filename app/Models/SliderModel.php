<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table         = 'slider';
    protected $allowedFields = ['judul', 'deskripsi', 'relevan_url', 'gambar', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
