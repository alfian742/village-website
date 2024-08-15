<?php

namespace App\Database\Seeds;

use App\Models\SaranaPrasaranaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SaranaPrasaranaSeeder extends Seeder
{
    public function run()
    {
        $model = new SaranaPrasaranaModel();

        $nama = 'Lorem ipsum dolor sit amet.';
        $slug = url_title($nama, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, sequi.';

        $data = [
            [
                'nama'          => $nama,
                'slug'          => $slug,
                'deskripsi'     => $deskripsi,
                'gambar'        => 'default.svg',
                'viewer'        => 1,
                'user_id'       => 1,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
