<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();

        $data = [
            [
                'email'         => 'superadmin@gmail.com',
                'username'      => 'superadmin',
                'fullname'      => 'Super Admin',
                'level'         => 'super admin', // Custom level
                'user_img'      => 'default.svg',
                'staff_id'      => uniqid(),
                'password_hash' => Password::hash('superadmin'), // Myth Auth Hash
                'active'        => 1, // 1 (actived), 2 (nonactived)
            ],
            [
                'email'         => 'admin@gmail.com',
                'username'      => 'admin',
                'fullname'      => 'Admin',
                'level'         => 'admin',
                'user_img'      => 'default.svg',
                'staff_id'      => uniqid(),
                'password_hash' => Password::hash('admin'),
                'active'        => 1,
            ],
        ];

        $model->insertBatch($data);
    }
}
