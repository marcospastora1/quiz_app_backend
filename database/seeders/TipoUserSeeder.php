<?php

namespace Database\Seeders;

use App\Models\TipoUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoUserJson = '[
            {
                "descricao": "Professor"
            },
            {
                "descricao": "Aluno"
            }
        ]';

        $tipos = json_decode($tipoUserJson);

        foreach ($tipos as $tipo) {
            TipoUser::updateOrcreate(
                [
                    'descricao' => $tipo->descricao
                ]
            );
        }
    }
}
