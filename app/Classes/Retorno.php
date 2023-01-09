<?php

namespace App\Classes;

class Retorno
{
    private bool $status;
    private $data;
    private $mensagem;
    private bool $isJson;
    private int $codigo;

    public static function webResult(bool $status, $data, $mensagem, bool $isJson = true)
    {
        $result = [
            'status' => $status,
            'data' => $data,
            'mensagem' => $mensagem
        ];
        if ($isJson == true) {
            return response()->json($result);
        } else {
            return $result;
        }
    }

    public static function mobileResult(bool $status, $data, int $codigo = null)
    {
        $message = config('mobileCodeMessage');
        if ($codigo) {
            $erro = [
                'code' => $codigo,
                'message' => (isset($message[$codigo])) ? $message[$codigo] : $message['default']
            ];
        }
        $result = [
            'success' => $status,
            'data' => $data,
            'error' => (isset($erro)) ? $erro : null
        ];
        return response()->json($result);
    }
}
