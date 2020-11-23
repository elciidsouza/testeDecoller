<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turmas extends Model
{
    protected $table = 'turmas';
    protected $fillable = [
        'nome_turma',
        'qtd_vagas',
        'dt_inicio',
    ];
    public $timestamps = false;
}
