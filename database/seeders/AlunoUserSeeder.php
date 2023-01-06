<?php

namespace Database\Seeders;

use App\Models\AlunoUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlunoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alunoJson = '[
            {
                "user_id": 1,
                "nome": "Marcos Pastora Santos",
                "tipo_user_id": 2,
                "matricula": "12345678",
                "data_nascimento": "1996-09-28",
                "whatsapp": "2799612123"

            }
        ]';

        $alunos = json_decode($alunoJson);

        foreach ($alunos as $aluno) {
            AlunoUser::updateOrcreate(
                [
                    'user_id' => $aluno->user_id,
                    'nome' => $aluno->nome,
                    'tipo_user_id' => $aluno->tipo_user_id,
                    'matricula' => $aluno->matricula,
                    'data_nascimento' => $aluno->data_nascimento,
                    'whatsapp' => $aluno->whatsapp
                ]
            );
        }
    }
}
