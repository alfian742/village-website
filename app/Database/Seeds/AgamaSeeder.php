<?php

namespace App\Database\Seeds;

use App\Models\AgamaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AgamaSeeder extends Seeder
{
    public function run()
    {
        $model = new AgamaModel();

        $agamas = [
            'Islam',
            'Hindu',
            'Buddha',
            'Protestan',
            'Katolik',
            'Konghucu',
        ];

        foreach ($agamas as $agama) {
            $jumlah = mt_rand(1, 1000);

            $data[] = [
                'agama'         => $agama,
                'jumlah'        => $jumlah,
                'created_at'    => Time::now('Asia/Singapore', 'en_US'),
                'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
            ];
        }

        $model->insertBatch($data);
    }
}
