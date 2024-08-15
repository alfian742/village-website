<?php

namespace App\Database\Seeds;

use App\Models\UsiaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsiaSeeder extends Seeder
{
    public function run()
    {
        $model = new UsiaModel();

        $usias = [
            '0-5',
            '6-12',
            '13-17',
            '18-40',
            '41-60',
            '> 60',
        ];

        foreach ($usias as $usia) {
            $jumlah = mt_rand(1, 1000);

            $data[] = [
                'usia'          => $usia,
                'jumlah'        => $jumlah,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ];
        }

        $model->insertBatch($data);
    }
}
