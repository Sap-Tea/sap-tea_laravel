<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matricula';

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'fk_id_aluno', 'alu_id');
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'fk_cod_mod', 'id_modalidade');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'fk_cod_valor_turma', 'cod_valor');
    }
}
