<?php

namespace App\Models;

use CodeIgniter\Model;

class KontakModel extends Model
{
    protected $table         = 'kontak';
    protected $allowedFields = ['email', 'nomor_hp', 'instagram', 'facebook', 'twitter', 'tiktok', 'youtube', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
