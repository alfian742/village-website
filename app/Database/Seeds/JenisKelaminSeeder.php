<?php

namespace App\Database\Seeds;

use App\Models\JenisKelaminModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class JenisKelaminSeeder extends Seeder
{
    public function run()
    {
        $model = new JenisKelaminModel();

        $jenisKelamins = [
            'Laki-laki',
            'Perempuan',
        ];

        foreach ($jenisKelamins as $jenisKelamin) {
            $jumlah = mt_rand(1, 1000);

            $data[] = [
                'jenis_kelamin'  => $jenisKelamin,
                'jumlah'        => $jumlah,
                'created_at'    => Time::now('Asia/Singapore', 'en_US'),
                'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
            ];
        }

        $model->insertBatch($data);
    }
}
