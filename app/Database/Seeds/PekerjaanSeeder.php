<?php

namespace App\Database\Seeds;

use App\Models\PekerjaanModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PekerjaanSeeder extends Seeder
{
    public function run()
    {
        $model = new PekerjaanModel();

        $pekerjaans = [
            'PNS',
            'TNI/POLRI',
            'BUMN/BUMD',
            'Wiraswasta',
            'Buruh',
            'Petani/Pekebun',
            'Peternak',
            'Tidak Bekerja',
            'Lainnya',
        ];

        foreach ($pekerjaans as $pekerjaan) {
            $jumlah = mt_rand(1, 1000);

            $data[] = [
                'pekerjaan'     => $pekerjaan,
                'jumlah'        => $jumlah,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ];
        }

        $model->insertBatch($data);
    }
}
