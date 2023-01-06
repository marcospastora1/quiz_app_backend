<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorUser extends Model
{
    use HasFactory;

    protected $table = 'professor_users';

    protected $fillable = [
        'user_id',
        'nome',
        'tipo_user_id',
        'registro_professor',
        'data_nascimento',
        'whatsapp'
    ];

    protected $cast = [];
}
