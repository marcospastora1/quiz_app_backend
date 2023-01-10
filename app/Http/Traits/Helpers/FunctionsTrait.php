<?php

namespace App\Http\Traits\Helpers;

trait FunctionsTrait
{
    /**
     * Função que retorna data e hora do Brasil
     */
    public function getDateBR()
    {
        return now('America/Sao_Paulo')->format('Y-m-d H:m:s');
    }
}
