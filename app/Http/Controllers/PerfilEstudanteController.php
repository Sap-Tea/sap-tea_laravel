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
        
        $professor_logado = auth('funcionario')->user();
        $professor_id = $professor_logado ? $professor_logado->func_id : null;

        // Garante que o aluno pertence ao professor logado
        $aluno = \App\Models\Aluno::where('alu_id', $aluno_id)
            ->whereHas('matriculas.turma', function($q) use ($professor_id) {
                $q->where('fk_cod_func', $professor_id);
            })->first();
        if (!$aluno) {
            return back()->withErrors(['msg' => 'Aluno não pertence ao professor logado ou não existe.']);
        }

        // Garante que existe registro nas três tabelas-eixo
        $tem_eixo_com = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $aluno_id)->exists();
        $tem_eixo_int = \App\Models\EixoInteracaoSocEmocional::where('fk_alu_id_eintsoc', $aluno_id)->exists();
        $tem_eixo_comp = \App\Models\EixoComportamento::where('fk_alu_id_ecomp', $aluno_id)->exists();
        if (!($tem_eixo_com && $tem_eixo_int && $tem_eixo_comp)) {
            return back()->withErrors(['msg' => 'O aluno precisa ter registros em todos os eixos (Comunicação, Interação Socioemocional e Comportamento) para acessar esta rotina.']);
        }

        $alunoDetalhado = \App\Models\Aluno::getAlunosDetalhados($aluno_id);
        $eixoCom = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $aluno_id)
            ->where('fase_inv_com_lin', 'In')
            ->first();
        $data_inicial_com_lin = $eixoCom ? $eixoCom->data_insert_com_lin : null;
        $professor_nome = $professor_logado ? $professor_logado->func_nome : null;

        $comunicacao_resultados = \App\Models\ResultEixoComLin::with('proposta')->where('fk_result_alu_id_ecomling', $aluno_id)->get();
        $comunicacao_resultados = $comunicacao_resultados->sortBy(function($item) {
            return optional($item->proposta)->cod_pro_com_lin;
        })->values();

        $comportamento_resultados = \App\Models\ResultEixoComportamento::with('proposta')->where('fk_result_alu_id_comportamento', $aluno_id)->get();
        $comportamento_resultados = $comportamento_resultados->sortBy(function($item) {
            return optional($item->proposta)->cod_pro_comportamento;
        })->values();

        $socioemocional_resultados = \App\Models\ResultEixoIntSocio::with('proposta')->where('fk_result_alu_id_int_socio', $aluno_id)->get();
        $socioemocional_resultados = $socioemocional_resultados->sortBy(function($item) {
            return optional($item->proposta)->cod_pro_int_soc;
        })->values();

        // Buscar atividades do eixo comunicação/linguagem do aluno via JOIN
        $comunicacao_atividades = \DB::table('atividade_com_lin as acom')
            ->join('result_eixo_com_lin as res', 'acom.id_ati_com_lin', '=', 'res.fk_id_pro_com_lin')
            ->orderBy('acom.cod_ati_com_lin')
            ->select('acom.cod_ati_com_lin', 'acom.desc_ati_com_lin')
            ->get();

        $comportamento_atividades = \DB::table('atividade_comportamento as acom')
            ->join('result_eixo_comportamento as res', 'acom.id_ati_comportamento', '=', 'res.fk_id_pro_comportamento')
            ->orderBy('acom.cod_ati_comportamento')
            ->select('acom.cod_ati_comportamento', 'acom.desc_ati_comportamento')
            ->get();

        $socioemocional_atividades = \DB::table('atividade_int_soc as acom')
            ->join('result_eixo_int_socio as res', 'acom.id_ati_int_soc', '=', 'res.fk_id_pro_int_socio')
            ->orderBy('acom.cod_ati_int_soc')
            ->select('acom.cod_ati_int_soc', 'acom.desc_ati_int_soc')
            ->get();

        // Buscar propostas e indexar por id
        $comunicacao_propostas = \App\Models\PropostaComLin::all()->keyBy('id_pro_com_lin');
        $comportamento_propostas = \App\Models\PropostaComportamento::all()->keyBy('id_pro_comportamento');
        $socioemocional_propostas = \App\Models\PropostaIntSoc::all()->keyBy('id_pro_int_soc');

        return view('rotina_monitoramento.monitoramento_aluno', compact(
            'alunoDetalhado',
            'data_inicial_com_lin',
            'professor_nome',
            'comunicacao_resultados',
            'comunicacao_atividades',
            'comportamento_resultados',
            'socioemocional_resultados',
            'socioemocional_atividades',
            'comunicacao_propostas',
            'comportamento_propostas',
            'socioemocional_propostas'
        ));
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
            ->whereHas('eixoComunicacao')
            ->whereHas('eixoSocioEmocional')
            ->whereHas('eixoComportamento')
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

        // Buscar resultados dos três eixos
        $comunicacao_resultados = \App\Models\ResultEixoComLin::where('fk_id_pro_com_lin', $id)->paginate(20);
        $comportamento_resultados = \App\Models\ResultEixoComportamento::where('fk_result_alu_id_comportamento', $id)->paginate(20);
        $socioemocional_resultados = \App\Models\ResultEixoIntSocio::where('fk_result_alu_id_int_socio', $id)->paginate(20);

        // Buscar atividades do eixo comunicação/linguagem do aluno via JOIN
        $comunicacao_atividades = \DB::table('atividade_com_lin as acom')
            ->join('result_eixo_com_lin as res', 'acom.id_ati_com_lin', '=', 'res.fk_id_pro_com_lin')
            ->where('res.fk_result_alu_id_ecomling', $id)
            ->orderBy('acom.cod_ati_com_lin')
            ->select('acom.cod_ati_com_lin', 'acom.desc_ati_com_lin')
            ->get();
        // Buscar atividades do eixo comportamento do aluno via JOIN
        $comportamento_atividades = \DB::table('atividade_comportamento as aco')
            ->join('result_eixo_comportamento as res', 'aco.id_ati_comportamento', '=', 'res.fk_id_pro_comportamento')
            ->where('res.fk_result_alu_id_comportamento', $id)
            ->orderBy('aco.cod_ati_comportamento')
            ->select('aco.cod_ati_comportamento', 'aco.desc_ati_comportamento')
            ->get();
        // Buscar atividades do eixo interação socioemocional via JOIN
        $socioemocional_atividades = \DB::table('atividade_int_soc as ais')
            ->join('result_eixo_int_socio as res', 'ais.id_ati_int_soc', '=', 'res.fk_id_pro_int_socio')
            ->where('res.fk_result_alu_id_int_socio', $id)
            ->orderBy('ais.cod_ati_int_soc')
            ->select('ais.cod_ati_int_soc', 'ais.desc_ati_int_soc')
            ->get();

        // Buscar propostas e indexar por id
        $comunicacao_propostas = \App\Models\PropostaComLin::all()->keyBy('id_pro_com_lin');
        $comportamento_propostas = \App\Models\PropostaComportamento::all()->keyBy('id_pro_comportamento');
        $socioemocional_propostas = \App\Models\PropostaIntSoc::all()->keyBy('id_pro_int_soc');

        return view('rotina_monitoramento.monitoramento_aluno', [
            'alunoDetalhado' => $alunoDetalhado,
            'professor_nome' => $professor->func_nome,
            'data_inicial_com_lin' => $data_inicial_com_lin,
            'comunicacao_resultados' => $comunicacao_resultados,
            'comunicacao_atividades' => $comunicacao_atividades,
            'comportamento_atividades' => $comportamento_atividades,
            'socioemocional_atividades' => $socioemocional_atividades,
            'comportamento_resultados' => $comportamento_resultados,
            'socioemocional_resultados' => $socioemocional_resultados,
            'comunicacao_propostas' => $comunicacao_propostas,
            'comportamento_propostas' => $comportamento_propostas,
            'socioemocional_propostas' => $socioemocional_propostas,
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