<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUser extends Model
{
    use HasFactory;

    protected $table = 'tipo_users';

    protected $fillable = [
        'descricao'
    ];

    protected $cast = [];

    public function retornaTipos()
    {
        $tipos = self::select('id', 'descricao')->get();
        return $tipos;
    }
}
