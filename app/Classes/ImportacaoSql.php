<?php

namespace App\Classes;

class ImportacaoSql
{

    protected static $caminhoProcedures = './database/procedures/';
    protected static $caminhoFunctions = './database/functions/';
    protected static $caminhoViews = './database/views/';

    public static function getCaminho(string $tipoArquivo, string $nomeArquivo)
    {
        switch ($tipoArquivo) {
            case 'procedure':
                return self::$caminhoProcedures . $nomeArquivo;
            case 'function':
                return self::$caminhoFunctions . $nomeArquivo;
            case 'view':
                return self::$caminhoViews . $nomeArquivo;
        }
    }

    public static function getConteudo(string $tipoArquivo, string $nomeArquivo)
    {
        return file_get_contents(self::getCaminho($tipoArquivo, $nomeArquivo));
    }

    public static function sobrescreverConteudo(string $tipoArquivo, string $nomeArquivo, string $conteudo)
    {
        file_put_contents(self::getCaminho($tipoArquivo, $nomeArquivo), $conteudo);
    }

    public static function upload(string $tipoArquivo, string $origem, string $destino)
    {
        if (file_exists(self::getCaminho($tipoArquivo, $origem))) {
            self::copiarConteudo($tipoArquivo, $origem, $destino);
            self::excluirArquivo($tipoArquivo, $origem);
        }
    }

    public static function excluirArquivo(string $tipoArquivo, string $nomeArquivo)
    {
        unlink(self::getCaminho($tipoArquivo, $nomeArquivo));
    }

    public static function copiarConteudo(string $tipoArquivo, string $origem, string $destino)
    {
        $conteudo = file_get_contents(self::getCaminho($tipoArquivo, $origem));
        file_put_contents(self::getCaminho($tipoArquivo, $destino), $conteudo);
    }
}
