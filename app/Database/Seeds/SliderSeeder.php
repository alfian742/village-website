<?php

namespace App\Database\Seeds;

use App\Models\SliderModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $model = new SliderModel();

        $sliders = [
            'Carousel 1',
            'Carousel 2',
            'Carousel 3',
        ];

        foreach ($sliders as $slider) {
            $gambar = 'default.svg';

            $data[] = [
                'judul'         => $slider,
                'deskripsi'     => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. A molestiae illo itaque delectus magnam nulla!',
                'gambar'        => $gambar,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ];
        }

        $model->insertBatch($data);
    }
}
