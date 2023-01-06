<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pontuacao extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'aluno_user_id',
        'quiz_id',
        'pontos'
    ];

    protected $cast = [];
}
