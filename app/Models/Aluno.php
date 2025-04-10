<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aluno extends Model
{
    protected $table = 'aluno';
    protected $primaryKey = 'alu_id';

    // Relacionamento com a tabela matricula
    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'fk_id_aluno', 'alu_id');
    }

    public static function getAlunosDetalhados($id)
    {
        $query = "SELECT DISTINCT 
                      alu.alu_id, 
                      alu.alu_nome, 
                      alu.alu_dtnasc, 
                      mat.numero_matricula,
                      esc.esc_inep, 
                      esc.esc_razao_social, -- Corrigido para esc.esc_razao_social
                      moda.desc_modalidade, 
                      moda.desc_serie_modalidade,
                      fun.func_nome, 
                      tp.desc_tipo_funcao
                  FROM aluno AS alu
                  LEFT JOIN matricula AS mat ON alu.alu_id = mat.fk_id_aluno
                  LEFT JOIN modalidade AS moda ON mat.fk_cod_mod = moda.id_modalidade
                  LEFT JOIN turma AS tur ON tur.cod_valor = mat.fk_cod_valor_turma
                  LEFT JOIN funcionario AS fun ON fun.func_id = tur.fk_cod_func
                  LEFT JOIN escola AS esc ON esc.esc_inep = tur.fk_inep
                  LEFT JOIN tipo_funcao AS tp ON tp.tipo_funcao_id = fun.func_cod_funcao
                  WHERE alu.alu_id = ?";

        return DB::select($query, [$id]);
    }
}
