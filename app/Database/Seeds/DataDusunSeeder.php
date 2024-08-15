<?php

namespace App\Database\Seeds;

use App\Models\DataDusunModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DataDusunSeeder extends Seeder
{
    public function run()
    {
        $model = new DataDusunModel();

        $data = [
            [
                'waktu'             => '2024-01-01',
                'jumlah_lahir'      => 5,
                'jumlah_mati'       => 4,
                'jumlah_masuk'      => 3,
                'jumlah_keluar'     => 2,
                'dusun_id'          => 1,
                'created_at'        => Time::now('Asia/Singapore', 'en_US'),
                'updated_at'        => Time::now('Asia/Singapore', 'en_US'),
            ],
        ];

        $model->insertBatch($data);
    }
}
