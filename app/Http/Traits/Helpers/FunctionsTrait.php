<?php

namespace App\Http\Traits\Helpers;

use App\Classes\Retorno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

trait FunctionsTrait
{
    /**
     * Função que retorna data e hora do Brasil
     */
    public function getDateBR()
    {
        return now('America/Sao_Paulo')->format('Y-m-d H:m:s');
    }

    /**
     * Função para cadastrar usuário
     */
    public function cadastroUser(Request $request)
    {
        $tipo_id_professor = DB::table('tipo_users')->select('id')->where('descricao', '=', 'Professor')->get();
        $tipo_id_professor = $tipo_id_professor[0]->id;

        $tipo_id_aluno = DB::table('tipo_users')->select('id')->where('descricao', '=', 'Aluno')->get();
        $tipo_id_aluno = $tipo_id_aluno[0]->id;

        $rota = $request->route()->getName();
        $rota = explode('.', $rota);


        if (!isset($request['email'])) {
            return Retorno::mobileResult(false, null, 2);
        }
        if (isset($request['password'])) {
            $request['password'] = bcrypt($request['password']);
        } else {
            return Retorno::mobileResult(false, null, 3);
        }
        try {
            DB::beginTransaction();
            DB::table('users')->insert([
                'email' => $request['email'],
                'password' => $request['password'],
                'status' => false,
                'tipo_user_id' => last($rota) == 'professor' ? $tipo_id_professor : $tipo_id_aluno,
                'created_at' => $this->getDateBr(),
                'updated_at' => $this->getDateBr()
            ]);


            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            return Retorno::mobileResult(false, null, 8);
        }
    }

    /**
     * Função para gerar chave aleatória
     */
    public function geraChave($n)
    {
        $chave_aleatoria = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

        $len = strlen($domain);

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $chave_aleatoria = $chave_aleatoria . $domain[$index];
        }
        return $chave_aleatoria;
    }
}
