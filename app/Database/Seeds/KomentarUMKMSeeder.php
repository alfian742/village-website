<?php

namespace App\Database\Seeds;

use App\Models\KomentarUMKMModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KomentarUMKMSeeder extends Seeder
{
    public function run()
    {
        $model = new KomentarUMKMModel();

        $data = [
            [
                'nama'          => 'Anonim',
                'email'         => '',
                'rating'         => 5,
                'deskripsi'     => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Libero, facilis?',
                'umkm_id'       => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
