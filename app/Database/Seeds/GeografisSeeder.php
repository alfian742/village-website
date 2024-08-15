<?php

namespace App\Database\Seeds;

use App\Models\GeografisModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class GeografisSeeder extends Seeder
{
    public function run()
    {
        $model = new GeografisModel();

        $data = [
            [
                'lokasi'        => 'Desa/kelurahan, Kecamatan, Kabupaten/Kota',
                'luas'          => '12345 km²',
                'timur'         => 'Timur',
                'barat'         => 'Barat',
                'selatan'       => 'Selatan',
                'utara'         => 'Utara',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
