<?php

namespace App\Database\Seeds;

use App\Models\UMKMModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UMKMSeeder extends Seeder
{
    public function run()
    {
        $model = new UMKMModel();

        $nama = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, eum!';
        $slug = url_title($nama, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus laboriosam porro at similique perferendis quaerat doloremque deserun omnis. Minus molestias facere pariatur repellendus inventore distinctio voluptas sequi ut officia ipsam.';

        $data = [
            [
                'nama'          => $nama,
                'slug'          => $slug,
                'pemilik'       => 'Anonim',
                'nomor_hp'      => '81234567890',
                'instagram'     => '',
                'harga'         => 15000,
                'deskripsi'     => $deskripsi,
                'viewer'        => 1,
                'gambar'        => 'default.svg',
                'user_id'       => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
