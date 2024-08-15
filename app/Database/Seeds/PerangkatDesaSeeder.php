<?php

namespace App\Database\Seeds;

use App\Models\PerangkatDesaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class PerangkatDesaSeeder extends Seeder
{
    public function run()
    {
        $perangkatDesaModel = new PerangkatDesaModel();
        $userModel = new UserModel();

        // Insert data
        $email          = 'kades@gmail.com';
        $username       = 'kades';
        $fullname       = 'Anonim';
        $jabatan        = 'Kepala Desa';
        $nip            = '1234567890';
        $deskripsi      = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, rem!';
        $level          = 'kepala desa';
        $foto           = 'default.svg';
        $staff_id       = uniqid();
        $password_hash  = 'kades';


        $dataStaff = [
            [
                'nama'          => $fullname,
                'jabatan'       => $jabatan,
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

        $perangkatDesaModel->insertBatch($dataStaff);
        $userModel->insertBatch($dataUser);
    }
}
