<?php

namespace App\Database\Seeds;

use App\Models\TentangDesaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class TentangDesaSeeder extends Seeder
{
    public function run()
    {
        $model = new TentangDesaModel();

        $data = [
            [
                'tentang_desa'  => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vel rem quo consequuntur, laboriosam nulla cumque reiciendis fuga libero sed? Ut eveniet officia suscipit deserunt reprehenderit ab quaerat quis tempore nemo?',
                'visi'          => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptatibus.',
                'misi'          => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium minus perferendis quia maiores non nobis minima laborum, libero ducimus hic!',
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $model->insertBatch($data);
    }
}
