<?php

namespace Database\Seeders;

use App\Models\ProfessorUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professorJson = '[
            {
                "user_id": 1,
                "nome": "Albert Einstein",
                "tipo_user_id": 1,
                "registro_professor": "12345678",
                "data_nascimento": "1943-09-28",
                "whatsapp": "27988537903"
            }
        ]';

        $professores = json_decode($professorJson);

        foreach ($professores as $professor) {
            ProfessorUser::updateOrcreate(
                [
                    'user_id' => $professor->user_id,
                    'nome' => $professor->nome,
                    'tipo_user_id' => $professor->tipo_user_id,
                    'registro_professor' => $professor->registro_professor,
                    'data_nascimento' => $professor->data_nascimento,
                    'whatsapp' => $professor->whatsapp
                ]
            );
        }
    }
}
