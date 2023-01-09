<?php

namespace Database\Seeders;

use App\Models\QuizStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusQuiz = '[
            {
                "descricao": "Ativo"
            },
            {
                "descricao": "Desativado"
            }
        ]';

        $status = json_decode($statusQuiz);

        foreach ($status as $statu) {
            QuizStatus::updateOrcreate(
                [
                    'descricao' => $statu->descricao
                ]
            );
        }
    }
}
