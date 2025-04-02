<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aluno extends Model
{
    protected $table = 'aluno';
    protected $primaryKey = 'alu_id';

    public static function getAlunosDetalhados($id)
    {
        $query = "SELECT alu.alu_id, alu.alu_nome, alu.alu_dtnasc,
                         moda.desc_modalidade, moda.desc_serie_modalidade,
                         fun.func_nome, tp.desc_tipo_funcao,tur.fk_cod_func
                  FROM aluno AS alu 
                  LEFT JOIN matricula AS mat ON alu.alu_id = mat.fk_id_aluno
                  LEFT JOIN modalidade AS moda ON mat.fk_cod_mod = moda.id_modalidade
                  LEFT JOIN turma AS tur ON tur.cod_valor = mat.fk_cod_valor_turma
                  LEFT JOIN funcionario AS fun ON fun.func_id = 37
                  LEFT JOIN tipo_funcao AS tp ON tp.tipo_funcao_id = fun.func_cod_funcao
                  WHERE alu.alu_id = ?";
    
        return DB::select($query, [$id]);
    }
    

}


