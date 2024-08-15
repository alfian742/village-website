<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table         = 'video';
    protected $allowedFields = ['video_url', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
