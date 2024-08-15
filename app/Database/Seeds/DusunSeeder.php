<?php

namespace App\Database\Seeds;

use App\Models\DusunModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DusunSeeder extends Seeder
{
    public function run()
    {
        $model = new DusunModel();

        $namaDusun = 'Lorem ipsum dolor sit amet.';
        $slug = url_title($namaDusun, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus laboriosam porro at similique perferendis quaerat doloremque deserun omnis. Minus molestias facere pariatur repellendus inventore distinctio voluptas sequi ut officia ipsam.';

        $data = [
            [
                'nama_dusun'        => $namaDusun,
                'slug'              => $slug,
                'deskripsi'         => $deskripsi,
                'gambar'            => 'default.svg',
                'luas'              => '12345 km²',
                'timur'             => 'Timur',
                'barat'             => 'Barat',
                'selatan'           => 'Selatan',
                'utara'             => 'Utara',
                'kepala_dusun_id'   => 1,
                'created_at'        => Time::now('Asia/Singapore', 'en_US'),
                'updated_at'        => Time::now('Asia/Singapore', 'en_US'),
            ],
        ];

        $model->insertBatch($data);
    }
}
