<?php

namespace App\Database\Seeds;

use App\Models\StrukturOrganisasiModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run()
    {
        $model = new StrukturOrganisasiModel();

        $data = [
            [
                'gambar'        => 'default.svg',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
