<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //senha: abc123
        $userJson = '[
            {
                "email": "professor@gmail.com",
                "password": "$2y$10$xsbN2IEHrVRA0fz3xrwE/e.W3YvHqDJ7ojUTDNVSZ5ABqMBwUnAye",
                "status": 1,
                "tipo_user_id": 1
            },
            {
                "email": "aluno@gmail.com",
                "password": "$2y$10$xsbN2IEHrVRA0fz3xrwE/e.W3YvHqDJ7ojUTDNVSZ5ABqMBwUnAye",
                "status": 1,
                "tipo_user_id": 2

            }
        ]';

        $users = json_decode($userJson);

        foreach ($users as $user) {
            User::updateOrcreate(
                [
                    'email' => $user->email,
                    'password' => $user->password,
                    'status' => $user->status,
                    'tipo_user_id' => $user->tipo_user_id
                ]
            );
        }
    }
}
