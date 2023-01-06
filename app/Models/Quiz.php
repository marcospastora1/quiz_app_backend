<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'descricao',
        'disciplina_id',
        'professor_user_id',
        'quiz_status_id',
        'chave'
    ];

    protected $cast = [];
}
