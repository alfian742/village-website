<?php

namespace App\Database\Seeds;

use App\Models\PariwisataModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PariwisataSeeder extends Seeder
{
    public function run()
    {
        $model = new PariwisataModel();

        $judul = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis, saepe!';
        $slug = url_title($judul, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minus laboriosam porro at similique perferendis quaerat doloremque deserun omnis. Minus molestias facere pariatur repellendus inventore distinctio voluptas sequi ut officia ipsam.';

        $data = [
            [
                'judul'         => $judul,
                'slug'          => $slug,
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
