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
        $comunicacao_atividades = DB::table('atividade_com_lin as acom')
    ->join('result_eixo_com_lin as res', 'res.fk_id_pro_com_lin', '=', 'acom.id_ati_com_lin')
    ->where('res.fk_result_alu_id_ecomling', $aluno_id)
    ->select('acom.id_ati_com_lin', 'acom.cod_ati_com_lin', 'acom.desc_ati_com_lin')
    ->get();

        // Frequência e ordenação para comunicação
        $comunicacao_frequencias = $comunicacao_atividades->groupBy('cod_ati_com_lin')->map->count();
        $comunicacao_atividades_ordenadas = $comunicacao_atividades->sortByDesc(function($item) use ($comunicacao_frequencias) {
            return $comunicacao_frequencias[$item->cod_ati_com_lin];
        })->values();

        $comunicacao_atividades_assoc = [];
        foreach ($comunicacao_atividades as $a) {
            $comunicacao_atividades_assoc[$a->id_ati_com_lin] = [
                'codigo' => $a->cod_ati_com_lin,
                'descricao' => $a->desc_ati_com_lin
            ];
        }

        $comportamento_atividades = DB::table('atividade_comportamento as acom')
    ->join('result_eixo_comportamento as res', 'res.fk_id_pro_comportamento', '=', 'acom.id_ati_comportamento')
    ->where('res.fk_result_alu_id_comportamento', $aluno_id)
    ->select('acom.id_ati_comportamento', 'acom.cod_ati_comportamento', 'acom.desc_ati_comportamento')
    ->get();

        // Frequência e ordenação para comportamento
        $comportamento_frequencias = $comportamento_atividades->groupBy('cod_ati_comportamento')->map->count();
        $comportamento_atividades_ordenadas = $comportamento_atividades->sortByDesc(function($item) use ($comportamento_frequencias) {
            return $comportamento_frequencias[$item->cod_ati_comportamento];
        })->values();

        $comportamento_atividades_assoc = [];
        foreach ($comportamento_atividades as $a) {
            $comportamento_atividades_assoc[$a->id_ati_comportamento] = [
                'codigo' => $a->cod_ati_comportamento,
                'descricao' => $a->desc_ati_comportamento
            ];
        }

        $socioemocional_atividades = DB::table('atividade_int_soc as acom')
    ->join('result_eixo_int_socio as res', 'res.fk_id_pro_int_socio', '=', 'acom.id_ati_int_soc')
    ->where('res.fk_result_alu_id_int_socio', $aluno_id)
    ->select('acom.cod_ati_int_soc', 'acom.desc_ati_int_soc')
    ->get();

        // Frequência e ordenação para socioemocional
        $socioemocional_frequencias = $socioemocional_atividades->groupBy('cod_ati_int_soc')->map->count();
        $socioemocional_atividades_ordenadas = $socioemocional_atividades->sortByDesc(function($item) use ($socioemocional_frequencias) {
            return $socioemocional_frequencias[$item->cod_ati_int_soc];
        })->values();

        // Buscar propostas e indexar por id
        $comunicacao_propostas = \App\Models\PropostaComLin::all()->keyBy('id_pro_com_lin');
        $comportamento_propostas = \App\Models\PropostaComportamento::all()->keyBy('id_pro_comportamento');
        $socioemocional_propostas = \App\Models\PropostaIntSoc::all()->keyBy('id_pro_int_soc');

        // Consultas SQL já trazem as atividades certas por eixo, ordenadas por código
        // Já estão sendo feitas acima e armazenadas em $comunicacao_atividades, $comportamento_atividades, $socioemocional_atividades
        // DEBUG: Agrupamento dos três eixos em um único array
        $debug_atividades_agrupadas = [
            'comunicacao' => DB::table('result_eixo_com_lin')
    ->select(
        'fk_id_pro_com_lin as id_ati_com_lin',
        'fk_hab_pro_com_lin',
        DB::raw('count(*) as qtd'),
        DB::raw('GROUP_CONCAT(id_result_eixo_com_lin) as ids'),
        DB::raw('MAX(date_cadastro) as ultima_data')
    )
    ->where('fk_result_alu_id_ecomling', $aluno_id)
    ->groupBy('fk_id_pro_com_lin', 'fk_hab_pro_com_lin')
    ->get(),
            'comportamento' => DB::table('result_eixo_comportamento')
    ->select(
        'fk_id_pro_comportamento as id_ati_comportamento',
        'fk_hab_pro_comportamento',
        DB::raw('count(*) as qtd'),
        DB::raw('GROUP_CONCAT(id_result_eixo_comportamento) as ids'),
        DB::raw('MAX(date_cadastro) as ultima_data')
    )
    ->where('fk_result_alu_id_comportamento', $aluno_id)
    ->groupBy('fk_id_pro_comportamento', 'fk_hab_pro_comportamento')
    ->get(),
            'socioemocional' => DB::table('result_eixo_int_socio')
    ->select(
        'fk_id_pro_int_socio as id_ati_int_soc',
        'fk_hab_pro_int_socio',
        DB::raw('count(*) as qtd'),
        DB::raw('GROUP_CONCAT(id_result_eixo_int_socio) as ids'),
        DB::raw('MAX(date_cadastro) as ultima_data')
    )
    ->where('fk_result_alu_id_int_socio', $aluno_id)
    ->groupBy('fk_id_pro_int_socio', 'fk_hab_pro_int_socio')
    ->get(),
        ];

        // Calcula o total de todos os eixos (total_eixos)
        // Calcula o total de atividades dos três eixos (cada ocorrência em cada eixo)
        $total_eixos = 0;
        if (isset($comunicacao_frequencias) && is_iterable($comunicacao_frequencias)) {
            foreach ($comunicacao_frequencias as $qtd) {
                $total_eixos += (int)$qtd;
            }
        }
        if (isset($comportamento_frequencias) && is_iterable($comportamento_frequencias)) {
            foreach ($comportamento_frequencias as $qtd) {
                $total_eixos += (int)$qtd;
            }
        }
        if (isset($socioemocional_frequencias) && is_iterable($socioemocional_frequencias)) {
            foreach ($socioemocional_frequencias as $qtd) {
                $total_eixos += (int)$qtd;
            }
        }

        return view('rotina_monitoramento.monitoramento_aluno', compact(
            'alunoDetalhado',
            'data_inicial_com_lin',
            'professor_nome',
            'comunicacao_atividades',
            'comunicacao_atividades_ordenadas',
            'comunicacao_atividades_assoc',
            'comportamento_atividades',
            'comportamento_atividades_ordenadas',
            'comportamento_atividades_assoc',
            'socioemocional_atividades',
            'socioemocional_atividades_ordenadas',
            'socioemocional_atividades_assoc',
            'debug_atividades_agrupadas',
            'total_eixos'
        ));
    }

    public function index()
{
    // Busca apenas alunos das turmas do professor logado
    $professor = auth('funcionario')->user();
    $funcId = $professor->func_id;
    $alunos = \App\Models\Aluno::porProfessor($funcId)
        ->orderBy('alu_nome', 'asc')
        ->get();

    return view('alunos.imprime_aluno', [
        'alunos' => $alunos,
        'titulo' => 'Alunos Matriculados',
        'rota_inventario' => 'perfil_estudante.index_inventario',
        'flag_teste' => true,
        'professor_nome' => $professor->func_nome ?? '',
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
    // Busca o aluno com detalhes completos pelo ID no banco de dados
    $aluno = Aluno::findOrFail($id);
    $alunoDetalhado = Aluno::getAlunosDetalhados($id);
    
    
    // getAlunosDetalhados retorna uma coleção, mas precisamos do primeiro item
    $alunoInfo = !empty($alunoDetalhado) ? $alunoDetalhado[0] : null;

    // Calcula a idade com base na data de nascimento
    $idade = Carbon::parse($aluno->alu_dtnasc)->age;

    // Retorna a view com os dados do aluno e a idade
    return view('alunos.perfil_estudante', [
        'aluno' => $aluno,
        'alunoDetalhado' => $alunoInfo,
        'idade' => $idade
    ]);
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
        $comunicacao_atividades = DB::table('atividade_com_lin as acom')
            ->join('result_eixo_com_lin as res', 'acom.id_ati_com_lin', '=', 'res.fk_id_pro_com_lin')
            ->where('res.fk_result_alu_id_ecomling', $id)
            ->select('acom.cod_ati_com_lin', 'acom.desc_ati_com_lin')
            ->get();
        $comunicacao_frequencias = $comunicacao_atividades->groupBy('cod_ati_com_lin')->map->count();
        $comunicacao_atividades_ordenadas = collect();
        foreach ($comunicacao_atividades as $item) {
            $freq = $comunicacao_frequencias[$item->cod_ati_com_lin];
            for ($i = 0; $i < $freq; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_com_lin = $item->cod_ati_com_lin;
                $obj->desc_ati_com_lin = $item->desc_ati_com_lin;
                $comunicacao_atividades_ordenadas->push($obj);
            }
            // Para não repetir além do necessário, zera a frequência
            $comunicacao_frequencias[$item->cod_ati_com_lin] = 0;
        }
        // Ordena por código, pode ajustar se quiser por frequência
        $comunicacao_atividades_ordenadas = $comunicacao_atividades_ordenadas->sortByDesc('cod_ati_com_lin')->values();
        // Buscar atividades do eixo comportamento do aluno via JOIN
        $comportamento_atividades = DB::table('atividade_comportamento as aco')
            ->join('result_eixo_comportamento as res', 'aco.id_ati_comportamento', '=', 'res.fk_id_pro_comportamento')
            ->where('res.fk_result_alu_id_comportamento', $id)
            ->select('aco.cod_ati_comportamento', 'aco.desc_ati_comportamento')
            ->get();
        $comportamento_frequencias = $comportamento_atividades->groupBy('cod_ati_comportamento')->map->count();
        $comportamento_atividades_ordenadas = collect();
        foreach ($comportamento_atividades as $item) {
            $freq = $comportamento_frequencias[$item->cod_ati_comportamento];
            for ($i = 0; $i < $freq; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_comportamento = $item->cod_ati_comportamento;
                $obj->desc_ati_comportamento = $item->desc_ati_comportamento;
                $comportamento_atividades_ordenadas->push($obj);
            }
            $comportamento_frequencias[$item->cod_ati_comportamento] = 0;
        }
        $comportamento_atividades_ordenadas = $comportamento_atividades_ordenadas->sortByDesc('cod_ati_comportamento')->values();
        // Buscar atividades do eixo interação socioemocional via JOIN
        $socioemocional_atividades = DB::table('atividade_int_soc as ais')
            ->join('result_eixo_int_socio as res', 'ais.id_ati_int_soc', '=', 'res.fk_id_pro_int_socio')
            ->where('res.fk_result_alu_id_int_socio', $id)
            ->select('ais.cod_ati_int_soc', 'ais.desc_ati_int_soc')
            ->get();
        $socioemocional_frequencias = $socioemocional_atividades->groupBy('cod_ati_int_soc')->map->count();
        $socioemocional_atividades_ordenadas = collect();
        foreach ($socioemocional_atividades as $item) {
            $freq = $socioemocional_frequencias[$item->cod_ati_int_soc];
            for ($i = 0; $i < $freq; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_int_soc = $item->cod_ati_int_soc;
                $obj->desc_ati_int_soc = $item->desc_ati_int_soc;
                $socioemocional_atividades_ordenadas->push($obj);
            }
            $socioemocional_frequencias[$item->cod_ati_int_soc] = 0;
        }
        $socioemocional_atividades_ordenadas = $socioemocional_atividades_ordenadas->sortByDesc('cod_ati_int_socio')->values();

        // Buscar propostas e indexar por id
        $comunicacao_propostas = \App\Models\PropostaComLin::all()->keyBy('id_pro_com_lin');
        $comportamento_propostas = \App\Models\PropostaComportamento::all()->keyBy('id_pro_comportamento');
        $socioemocional_propostas = \App\Models\PropostaIntSoc::all()->keyBy('id_pro_int_soc');
        // Agrupamento debug igual rotina_monitoramento_aluno
        $debug_atividades_agrupadas = [
            'comunicacao' => DB::table('result_eixo_com_lin')
                ->select(
                    'fk_id_pro_com_lin as cod_ati_com_lin',
                    'fk_hab_pro_com_lin',
                    DB::raw('count(*) as qtd'),
                    DB::raw('GROUP_CONCAT(id_result_eixo_com_lin) as ids'),
                    DB::raw('MAX(date_cadastro) as ultima_data')
                )
                ->where('fk_result_alu_id_ecomling', $id)
                ->groupBy('fk_id_pro_com_lin', 'fk_hab_pro_com_lin')
                ->orderByRaw('cod_ati_com_lin DESC, qtd DESC')
                ->get(),
            'comportamento' => DB::table('result_eixo_comportamento')
                ->select(
                    'fk_id_pro_comportamento as cod_ati_comportamento',
                    'fk_hab_pro_comportamento',
                    DB::raw('count(*) as qtd'),
                    DB::raw('GROUP_CONCAT(id_result_eixo_comportamento) as ids'),
                    DB::raw('MAX(date_cadastro) as ultima_data')
                )
                ->where('fk_result_alu_id_comportamento', $id)
                ->groupBy('fk_id_pro_comportamento', 'fk_hab_pro_comportamento')
                ->orderByRaw('cod_ati_comportamento DESC, qtd DESC')
                ->get(),
            'socioemocional' => DB::table('result_eixo_int_socio')
                ->select(
                    'fk_id_pro_int_socio as cod_ati_int_soc',
                    'fk_hab_pro_int_socio',
                    DB::raw('count(*) as qtd'),
                    DB::raw('GROUP_CONCAT(id_result_eixo_int_socio) as ids'),
                    DB::raw('MAX(date_cadastro) as ultima_data')
                )
                ->where('fk_result_alu_id_int_socio', $id)
                ->groupBy('fk_id_pro_int_socio', 'fk_hab_pro_int_socio')
                ->orderByRaw('cod_ati_int_soc DESC, qtd DESC')
                ->get(),
        ];
        // --- Agrupamento Comunicação/Linguagem ---
$comunicacao_linguagem_agrupado = DB::select("
    SELECT 
        r.fk_id_pro_com_lin,
        r.fk_result_alu_id_ecomling,
        r.tipo_fase_com_lin,
        a.cod_ati_com_lin,
        a.desc_ati_com_lin,
        COUNT(*) AS total
    FROM result_eixo_com_lin r
    JOIN atividade_com_lin a ON r.fk_id_pro_com_lin = a.id_ati_com_lin
    WHERE r.fk_result_alu_id_ecomling = ?
    GROUP BY r.fk_id_pro_com_lin, r.fk_result_alu_id_ecomling, r.tipo_fase_com_lin, a.cod_ati_com_lin, a.desc_ati_com_lin
    ORDER BY total DESC
", [$id]);

// --- Agrupamento Comportamento ---
$comportamento_agrupado = DB::select("
    SELECT 
        r.fk_id_pro_comportamento,
        r.fk_result_alu_id_comportamento,
        r.tipo_fase_comportamento,
        a.cod_ati_comportamento,
        a.desc_ati_comportamento,
        COUNT(*) AS total
    FROM result_eixo_comportamento r
    JOIN atividade_comportamento a ON r.fk_id_pro_comportamento = a.id_ati_comportamento
    WHERE r.fk_result_alu_id_comportamento = ?
    GROUP BY r.fk_id_pro_comportamento, r.fk_result_alu_id_comportamento, r.tipo_fase_comportamento, a.cod_ati_comportamento, a.desc_ati_comportamento
    ORDER BY total DESC
", [$id]);

// --- Agrupamento Socioemocional ---
$socioemocional_agrupado = DB::select("
    SELECT 
        r.fk_id_pro_int_socio,
        r.fk_result_alu_id_int_socio,
        r.tipo_fase_int_socio,
        a.cod_ati_int_soc,
        a.desc_ati_int_soc,
        COUNT(*) AS total
    FROM result_eixo_int_socio r
    JOIN atividade_int_soc a ON r.fk_id_pro_int_socio = a.id_ati_int_soc
    WHERE r.fk_result_alu_id_int_socio = ?
    GROUP BY r.fk_id_pro_int_socio, r.fk_result_alu_id_int_socio, r.tipo_fase_int_socio, a.cod_ati_int_soc, a.desc_ati_int_soc
    ORDER BY total DESC
", [$id]);

// Calcula o total de atividades em todos os eixos (soma dos campos 'total' dos agrupados)
$total_eixos = 0;
foreach ($comunicacao_linguagem_agrupado as $item) {
    if (isset($item->total)) $total_eixos += (int)$item->total;
}
foreach ($comportamento_agrupado as $item) {
    if (isset($item->total)) $total_eixos += (int)$item->total;
}
foreach ($socioemocional_agrupado as $item) {
    if (isset($item->total)) $total_eixos += (int)$item->total;
}

// Carregar dados de monitoramento já cadastrados
$monitoramentoController = new \App\Http\Controllers\MonitoramentoAtividadeController();
$dadosMonitoramento = $monitoramentoController->carregarParaView($id);

return view('rotina_monitoramento.monitoramento_aluno', [
    'alunoDetalhado' => $alunoDetalhado,
    'professor_nome' => $professor->func_nome,
    'data_inicial_com_lin' => $data_inicial_com_lin,
    'comunicacao_resultados' => $comunicacao_resultados,
    'comunicacao_linguagem_agrupado' => $comunicacao_linguagem_agrupado,
    'comportamento_agrupado' => $comportamento_agrupado,
    'socioemocional_agrupado' => $socioemocional_agrupado,
    'comunicacao_atividades' => $comunicacao_atividades,
    'comportamento_atividades' => $comportamento_atividades,
    'socioemocional_atividades' => $socioemocional_atividades,
    'comunicacao_atividades_ordenadas' => $comunicacao_atividades_ordenadas,
    'comportamento_atividades_ordenadas' => $comportamento_atividades_ordenadas,
    'socioemocional_atividades_ordenadas' => $socioemocional_atividades_ordenadas,
    'comportamento_resultados' => $comportamento_resultados,
    'socioemocional_resultados' => $socioemocional_resultados,
    'comunicacao_propostas' => $comunicacao_propostas,
    'comportamento_propostas' => $comportamento_propostas,
    'socioemocional_propostas' => $socioemocional_propostas,
    'debug_atividades_agrupadas' => $debug_atividades_agrupadas,
    'total_eixos' => $total_eixos,
    'dadosMonitoramento' => $dadosMonitoramento, // Adiciona os dados de monitoramento para a view
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
        DB::table('rotinas')->insert([
            'aluno_id' => $id,
            'descricao' => $request->descricao,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('rotina.monitoramento.cadastrar', ['id' => $id])
            ->with('success', 'Rotina salva com sucesso!');
    }
}