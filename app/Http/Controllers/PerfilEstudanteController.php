<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aluno; // Importa o modelo Aluno
use Carbon\Carbon; // Para manipulação de datas
use App\Models\PerfilEstudante;

 

class PerfilEstudanteController extends Controller
{
    public function index()
{
    // Busca apenas alunos matriculados, ordenados por nome
    $alunos = Aluno::whereHas('matriculas')
                   ->orderBy('alu_nome', 'asc')
                   ->get();

    return view('alunos.imprime_aluno', [
        'alunos' => $alunos,
        'titulo' => 'Alunos Matriculados',
        'rota_inventario' => 'perfil_estudante.index_inventario',
        'flag_teste' => true,
    ]);
}

public function index_inventario()
{
    $professor = auth('funcionario')->user();
    $funcId = $professor->func_id;

    $alunos = \App\Models\Aluno::porProfessor($funcId)
        ->orderBy('alu_nome', 'asc')
        ->get();

    return view('alunos.imprime_aluno_eixo', [
        'alunos' => $alunos,
        'titulo' => 'Alunos do Professor',
        'rota_acao' => 'alunos.inventario',
        'rota_pdf' => 'visualizar.inventario',
        'exibeBotaoInventario' => true,
        'exibeBotaoPdf' => true,
        'flag_teste' => false,
    ]);
}

 
        public function mostrar($id)
        {
            // Busca o aluno pelo ID no banco de dados
            $aluno = Aluno::findOrFail($id);
    
            // Calcula a idade com base na data de nascimento
            $idade = Carbon::parse($aluno->alu_dtnasc)->age;
    
            // Retorna a view com os dados do aluno e a idade
            return view('alunos.perfil_estudante', compact('aluno', 'idade'));
        }

        public function mostra_aluno_eixo($id)
        {
            $aluno = Aluno::findOrFail($id);
            $_eixo = Carbon::parse($aluno->alu_dtnasc)->age;
            //$alunos = Aluno::all(); // Busca todos os alunos no banco de dados
    
            return view('alunos.imprime_aluno_eixo', compact('alunos','idade_eixo'));
        }
        
    public function rotina_monitoramento_inicial()
    {
        // Busca alunos que existem nas três tabelas de eixo e estão matriculados
        $alunos = Aluno::whereHas('matriculas')
                    ->whereHas('eixoComunicacao', function($query) {
                        $query->whereNotNull('data_insert_com_lin')
                              ->whereNotNull('fase_inv_com_lin');
                    })
                    ->whereHas('eixoComportamento', function($query) {
                        $query->whereNotNull('data_insert_comportamento')
                              ->whereNotNull('fase_inv_comportamento');
                    })
                    ->whereHas('eixoSocioEmocional', function($query) {
                        $query->whereNotNull('data_insert_int_socio')
                              ->whereNotNull('fase_inv_int_socio');
                    })
                    ->orderBy('alu_nome', 'asc')
                    ->get();

        return view('rotina_monitoramento.rotina_monitoramento_inicial', compact('alunos'));
    }
}