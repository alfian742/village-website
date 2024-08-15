<?php

namespace App\Database\Seeds;

use App\Models\LayananModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $model = new LayananModel();

        $nama_layanan = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis, saepe!';
        $slug = url_title($nama_layanan, '-', true);
        $deskripsi = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum quo fugit quaerat dignissimos mollitia, corrupti illo, quod veritatis totam accusantium placeat reiciendis ad laboriosam deleniti itaque laudantium expedita sequi incidunt.';

        $data = [
            [
                'nama_layanan'  => $nama_layanan,
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
