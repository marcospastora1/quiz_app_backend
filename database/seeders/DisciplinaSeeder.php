<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disciplinasJson = '[
            {
                "descricao": "Português"
            },
            {
                "descricao": "Matemática"
            }
        ]';

        $disciplinas = json_decode($disciplinasJson);

        foreach ($disciplinas as $disciplina) {
            Disciplina::updateOrcreate(
                [
                    'descricao' => $disciplina->descricao
                ]
            );
        }
    }
}
