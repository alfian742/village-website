<?php

namespace App\Database\Seeds;

use App\Models\SitusModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SitusSeeder extends Seeder
{
    public function run()
    {
        $model = new SitusModel();

        $data = [
            [
                'nama_desa'     => 'Desa/Kelurahan',
                'kecamatan'     => 'Kecamatan',
                'kabupaten'     => 'Kabupaten/Kota',
                'provinsi'      => 'Provinsi',
                'kode_pos'      => '12345',
                'logo'          => 'default.svg',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
