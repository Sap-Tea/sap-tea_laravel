<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $table = 'turma';
    protected $primaryKey = 'cod_valor';

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'fk_cod_func', 'func_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'fk_cod_valor_turma', 'cod_valor');
    }
}
