<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Aluno;

class AtualizaPerfinEstudante extends Controller
{

    public function atualizaPerfil($id)
{
    // Consulta para obter dados do aluno

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
    
    $dados= DB::select($query, [$id]);
   // dd($dados);
    if (empty($dados)) {
        abort(404); // Aluno não encontrado
    }

    // Consulta para obter dados do perfil estudante
    $results = DB::select("
        SELECT * 
        FROM perfil_estudante AS pes 
        INNER JOIN personalidade AS per 
        ON pes.fk_id_aluno = per.fk_id_aluno
        INNER JOIN preferencia AS pre 
        ON per.fk_id_aluno = pre.fk_id_aluno
        INNER JOIN comunicacao AS com 
        ON pre.fk_id_aluno = com.fk_id_aluno
        INNER JOIN perfil_familia AS pfa 
        ON pfa.fk_id_aluno = com.fk_id_aluno
        WHERE pes.fk_id_aluno = ?
    ", [$id]);
    

    // Redireciona para a view com os dados
    return view('alunos.atualiza_perfil_estudante', compact('dados', 'results'));
}

    



}
