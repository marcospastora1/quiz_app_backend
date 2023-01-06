<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoUser extends Model
{
    use HasFactory;

    protected $table = 'aluno_users';

    protected $fillable = [
        'user_id',
        'nome',
        'tipo_user_id',
        'matricula',
        'data_nascimento',
        'whatsapp'
    ];

    protected $cast = [];
}
