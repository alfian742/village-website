<?php

namespace App\Database\Seeds;

use App\Models\DokumenPublikModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DokumenPublikSeeder extends Seeder
{
    public function run()
    {
        $model = new DokumenPublikModel();

        $data = [
            [
                'nama'          => 'Default',
                'tipe'          => '-',
                'ukuran'        => '-',
                'berkas'        => 'default.pdf',
                'created_at'    => Time::now('Asia/Singapore', 'en_US'),
                'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
            ],
        ];

        $model->insertBatch($data);
    }
}
