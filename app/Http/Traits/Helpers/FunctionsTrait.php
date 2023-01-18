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

    public function cadastroUser(Request $request)
    {
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
                'created_at' => $this->getDateBr(),
                'updated_at' => $this->getDateBr()
            ]);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            return Retorno::mobileResult(false, null, 8);
        }
    }
}
