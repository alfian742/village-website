<?php

namespace App\Database\Seeds;

use App\Models\KategoriModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $model = new KategoriModel();

        $kategoris = [
            'Teknologi',
            'Pendidikan',
            'Pariwisata',
        ];

        foreach ($kategoris as $kategori) {
            $slug = url_title($kategori, '-', true);

            $data[] = [
                'kategori'      => $kategori,
                'slug'          => $slug,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ];
        }

        $model->insertBatch($data);
    }
}
