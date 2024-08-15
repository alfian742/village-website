<?php

namespace App\Database\Seeds;

use App\Models\KontakModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KontakSeeder extends Seeder
{
    public function run()
    {
        $model = new KontakModel();

        $data = [
            [
                'email'         => 'example@gmail.com',
                'nomor_hp'      => '81234567890',
                'instagram'     => '',
                'facebook'      => '',
                'instagram'     => '',
                'twitter'       => '',
                'tiktok'        => '',
                'youtube'       => '',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
