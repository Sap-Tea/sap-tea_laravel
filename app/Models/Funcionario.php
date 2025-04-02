<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionario';
    protected $primaryKey = 'func_id';

    public function tipoFuncao()
    {
        return $this->belongsTo(TipoFuncao::class, 'func_cod_funcao', 'tipo_funcao_id');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'fk_cod_func', 'func_id');
    }
}
