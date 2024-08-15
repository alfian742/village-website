<?php

namespace App\Database\Seeds;

use App\Models\KomentarBeritaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KomentarBeritaSeeder extends Seeder
{
    public function run()
    {
        $model = new KomentarBeritaModel();

        $data = [
            [
                'nama'          => 'Anonim',
                'email'         => '',
                'deskripsi'     => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Libero, facilis?',
                'berita_id'     => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
