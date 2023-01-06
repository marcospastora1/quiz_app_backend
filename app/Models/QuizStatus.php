<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizStatus extends Model
{
    use HasFactory;

    protected $table = 'quiz_status';

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
