<?php

namespace App\Database\Seeds;

use App\Models\PengumumanModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        $model = new PengumumanModel();

        $judul = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium, exercitationem.';
        $slug = url_title($judul, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus laboriosam porro at similique perferendis quaerat doloremque deserun omnis. Minus molestias facere pariatur repellendus inventore distinctio voluptas sequi ut officia ipsam.';

        $data = [
            [
                'judul'         => $judul,
                'slug'          => $slug,
                'deskripsi'     => $deskripsi,
                'viewer'        => 1,
                'user_id'       => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
