<?php

namespace App\Database\Seeds;

use App\Models\VideoModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $model = new VideoModel();

        $data = [
            [
                'video_url'     => 'https://www.youtube.com/embed/BbkFE_K_t0c?si=6GpxQfyS-NFyoIMc',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
