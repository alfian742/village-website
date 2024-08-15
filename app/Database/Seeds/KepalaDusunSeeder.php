<?php

namespace App\Database\Seeds;

use App\Models\KepalaDusunModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class KepalaDusunSeeder extends Seeder
{
    public function run()
    {
        $kepalaDusunModel = new KepalaDusunModel();
        $userModel = new UserModel();

        // Insert data
        $email          = 'kadus@gmail.com';
        $username       = 'kadus';
        $fullname       = 'Anonim';
        $nip            = '1234567890';
        $deskripsi      = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, rem!';
        $level          = 'kepala dusun';
        $foto           = 'default.svg';
        $staff_id       = uniqid();
        $password_hash  = 'kadus';

        $dataKepalaDusun = [
            [
                'nama'          => $fullname,
                'nip'           => $nip,
                'deskripsi'     => $deskripsi,
                'foto'          => $foto,
                'staff_id'      => $staff_id,
                'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ],
        ];

        $dataUser = [
            [
                'email'         => $email,
                'username'      => $username,
                'fullname'      => $fullname,
                'level'         => $level,
                'user_img'      => $foto,
                'staff_id'      => $staff_id,
                'password_hash' => Password::hash($password_hash),
                'active'        => 1,
            ],
        ];

        $kepalaDusunModel->insertBatch($dataKepalaDusun);
        $userModel->insertBatch($dataUser);
    }
}
