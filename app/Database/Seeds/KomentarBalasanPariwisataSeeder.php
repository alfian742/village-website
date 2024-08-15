<?php

namespace App\Database\Seeds;

use App\Models\KomentarBalasanPariwisataModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KomentarBalasanPariwisataSeeder extends Seeder
{
    public function run()
    {
        $model = new KomentarBalasanPariwisataModel();

        $data = [
            [
                'nama'                     => 'Anonim',
                'email'                    => '',
                'deskripsi'                => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Libero, facilis?',
                'komentar_pariwisata_id'   => 1,
                'created_at'               => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'               => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
