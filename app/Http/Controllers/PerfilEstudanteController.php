<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Aluno; // Importa o modelo Aluno
use Carbon\Carbon; // Para manipulação de datas
use App\Models\PerfilEstudante;

 

class PerfilEstudanteController extends Controller
{
    public function rotina_monitoramento_aluno($aluno_id)
    {
        $alunoDetalhado = \App\Models\Aluno::getAlunosDetalhados($aluno_id);
        // Buscar data inicial do eixo comunicação linguagem
        $eixoCom = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $aluno_id)
            ->where('fase_inv_com_lin', 'In')
            ->first();
        $data_inicial_com_lin = $eixoCom ? $eixoCom->data_insert_com_lin : null;
        $professor_logado = auth('funcionario')->user();
        $professor_nome = $professor_logado ? $professor_logado->func_nome : null;
        return view('rotina_monitoramento.monitoramento_aluno', compact('alunoDetalhado', 'data_inicial_com_lin', 'professor_nome'));
    }

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

public function index_inventario(Request $request)
{
    $professor = auth('funcionario')->user();
    $funcId = $professor->func_id;

    $alunos = \App\Models\Aluno::porProfessor($funcId)
        ->orderBy('alu_nome', 'asc')
        ->get();

    // Teste: se vier do menu de rotina, mostre botões diferentes
    $contexto = $request->get('contexto');
    if ($contexto === 'rotina') {
        return view('alunos.imprime_aluno_eixo', [
            'alunos' => $alunos,
            'titulo' => 'Rotina de Monitoramento',
            'botoes' => [
                [
                    'label' => 'Cadastrar Rotina',
                    'rota'  => 'rotina.monitoramento.cadastrar',
                    'classe' => 'btn-success'
                ],
                [
                    'label' => 'Visualizar Rotina',
                    'rota'  => 'rotina.monitoramento.visualizar',
                    'classe' => 'btn-info'
                ]
            ],
            'professor_nome' => $professor->func_nome,
        ]);
    }

    // Default: inventário
    return view('alunos.imprime_aluno_eixo', [
        'alunos' => $alunos,
        'titulo' => 'Alunos do Professor',
        'rota_acao' => 'alunos.inventario',
        'rota_pdf' => 'visualizar.inventario',
        'exibeBotaoInventario' => true,
        'exibeBotaoPdf' => true,
        'professor_nome' => $professor->func_nome,
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
        $professor = auth('funcionario')->user();
        $funcId = $professor->func_id;

        $alunos = \App\Models\Aluno::porProfessor($funcId)
            ->orderBy('alu_nome', 'asc')
            ->get();

        return view('alunos.imprime_aluno_eixo', [
            'alunos' => $alunos,
            'titulo' => 'Rotina de Monitoramento',
            'botoes' => [
                [
                    'label' => 'Cadastrar Rotina',
                    'rota'  => 'rotina.monitoramento.cadastrar',
                    'classe' => 'btn-success'
                ],
                [
                    'label' => 'Visualizar Rotina',
                    'rota'  => 'rotina.monitoramento.visualizar',
                    'classe' => 'btn-info'
                ]
            ],
            'professor_nome' => $professor->func_nome,
        ]);
    }

    /**
     * Exibe a tela de cadastro de rotina para o aluno selecionado
     */
    public function cadastrar_rotina_aluno($id)
    {
        $alunoDetalhado = \App\Models\Aluno::getAlunosDetalhados($id);
        $professor = auth('funcionario')->user();
        if (!$alunoDetalhado) {
            return back()->withErrors(['msg' => 'Não foi possível carregar os dados do aluno. Por favor, acesse o formulário pela rota correta ou verifique se o aluno existe.']);
        }
        // Buscar data inicial do eixo comunicação linguagem, se necessário
        $eixoCom = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $id)
            ->where('fase_inv_com_lin', 'In')
            ->first();
        $data_inicial_com_lin = $eixoCom ? $eixoCom->data_insert_com_lin : null;
        return view('rotina_monitoramento.monitoramento_aluno', [
            'alunoDetalhado' => $alunoDetalhado,
            'professor_nome' => $professor->func_nome,
            'data_inicial_com_lin' => $data_inicial_com_lin,
        ]);
    }

    /**
     * Salva a rotina de monitoramento do aluno
     */
    public function salvar_rotina(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:1000',
        ]);

        // Exemplo genérico de salvamento, ajuste conforme seu modelo real
        \DB::table('rotinas')->insert([
            'aluno_id' => $id,
            'descricao' => $request->descricao,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('rotina.monitoramento.cadastrar', ['id' => $id])
            ->with('success', 'Rotina salva com sucesso!');
    }
}