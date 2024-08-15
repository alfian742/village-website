<?php

namespace App\Database\Seeds;

use App\Models\KomentarPariwisataModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KomentarPariwisataSeeder extends Seeder
{
    public function run()
    {
        $model = new KomentarPariwisataModel();

        $data = [
            [
                'nama'          => 'Anonim',
                'email'         => '',
                'rating'         => 5,
                'deskripsi'     => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Libero, facilis?',
                'pariwisata_id' => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
