<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Atividade;
use App\Models\AtividadeComunicacao;
use App\Models\AtividadeComportamento;
use App\Models\AtividadeSocioemocional;
use App\Models\ResultEixoComLin;
use App\Models\ResultEixoComport;
use App\Models\ResultEixoSocio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitoramentoAtividadeController extends Controller
{
    /**
     * Salva os dados de monitoramento do aluno
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // Método obterFaseAtual já definido abaixo
    
    public function salvar(Request $request)
    {
        // Logs detalhados para debug
        \Log::debug('=================== INÍCIO DO SALVAMENTO ===================');
        \Log::debug('[monitoramento] Payload completo recebido', $request->all());
        \Log::debug('[monitoramento] aluno_id recebido:', ['aluno_id' => $request->input('aluno_id')]);
        \Log::debug('[monitoramento] Tipo do aluno_id:', ['tipo' => gettype($request->input('aluno_id'))]);
        \Log::debug('[monitoramento] Headers da requisição:', ['headers' => $request->header()]);
        \Log::debug('[monitoramento] Método da requisição:', ['método' => $request->method()]);
        \Log::debug('[monitoramento] Content-Type:', ['content-type' => $request->header('Content-Type')]);
        \Log::debug('[monitoramento] Request tem JSON?', ['isJson' => $request->isJson()]);
        \Log::debug('[monitoramento] Request é AJAX?', ['ajax' => $request->ajax()]);
        \Log::debug('[monitoramento] Comunicação recebida:', ['comunicacao' => $request->input('comunicacao')]);
        \Log::debug('[monitoramento] Comportamento recebido:', ['comportamento' => $request->input('comportamento')]);
        \Log::debug('[monitoramento] Socioemocional recebido:', ['socioemocional' => $request->input('socioemocional')]);
        
        // Código para salvar os dados do monitoramento
        try {
            DB::beginTransaction();



            $alunoId = $request->input('aluno_id');
            $faseCadastro = $this->obterFaseAtual();
            
            // Processar cada eixo de atividade
            $eixos = ['comunicacao', 'comportamento', 'socioemocional'];
            $dadosProcessados = [];
            
            foreach ($eixos as $eixo) {
                $input = $request->input($eixo);
                if (empty($input)) {
                    $dadosProcessados[$eixo] = [];
                } elseif (is_array($input)) {
                    // Formulário tradicional: já é array
                    $dadosProcessados[$eixo] = $input;
                } elseif (is_string($input)) {
                    // AJAX: é string JSON
                    $dadosEixo = json_decode($input, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $dadosProcessados[$eixo] = $dadosEixo;
                    } else {
                        Log::error("Erro ao decodificar JSON para o eixo: {$eixo}", [
                            'json' => $input,
                            'erro' => json_last_error_msg()
                        ]);
                        $dadosProcessados[$eixo] = [];
                    }
                } else {
                    $dadosProcessados[$eixo] = [];
                }
            }

            // Salvar os dados de cada eixo
            $salvos = 0;
            $salvos += $this->salvarEixo($alunoId, 'comunicacao', $dadosProcessados['comunicacao'] ?? []);
            $salvos += $this->salvarEixo($alunoId, 'comportamento', $dadosProcessados['comportamento'] ?? []);
            $salvos += $this->salvarEixo($alunoId, 'socioemocional', $dadosProcessados['socioemocional'] ?? []);

            DB::commit();

            if ($salvos === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum registro foi salvo porque todos já existem para este aluno, atividade, flag e fase de cadastro.',
                    'data' => [
                        'aluno_id' => $alunoId,
                        'fase_cadastro' => $faseCadastro,
                        'registros_salvos' => 0
                    ]
                ], 409);
            }

            return response()->json([
                'success' => true,
                'message' => 'Dados salvos com sucesso!',
                'data' => [
                    'aluno_id' => $alunoId,
                    'fase_cadastro' => $faseCadastro,
                    'registros_salvos' => $salvos
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar monitoramento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao salvar os dados. Por favor, tente novamente.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Salva os dados de um eixo específico
     *
     * @param int $alunoId ID do aluno
     * @param string $eixo Nome do eixo (comunicacao, comportamento, socioemocional)
     * @param array $dados Dados a serem salvos
     * @return int
     */
    protected function salvarEixo($alunoId, $eixo, $dados)
    {
        // Logs detalhados para debug
        \Log::debug('=================== INICIANDO SALVAR EIXO ' . $eixo . ' ===================');
        \Log::debug('ID do aluno recebido: ' . $alunoId);
        \Log::debug('Tipo do ID do aluno: ' . gettype($alunoId));
        
        // Garantir que aluno_id seja um inteiro válido
        if (empty($alunoId) || !is_numeric($alunoId)) {
            \Log::error("ERRO CRÍTICO: aluno_id inválido ou vazio: " . var_export($alunoId, true));
            return 0;
        }
        
        // Forçar conversão para inteiro
        $alunoId = (int)$alunoId;
        \Log::debug('ID do aluno após conversão para int: ' . $alunoId);
        
        $model = $this->getModelPorEixo($eixo);
        if (!$model) {
            \Log::error("Model não encontrada para o eixo: " . $eixo);
            return 0;
        }

        $faseCadastro = $this->obterFaseAtual();
        $registrosSalvos = 0;
        $timestampBase = now()->timestamp;

        // Loga o array recebido do request antes de qualquer filtro
        \Log::debug('Recebido do request para o eixo ' . $eixo, ['dados_recebidos' => $dados]);

        // NÃO filtra nada aqui, apenas garante que é array
        $dados = array_filter($dados, function($a) {
            return is_array($a);
        });
        \Log::debug('Filtro apenas para garantir array para o eixo ' . $eixo, ['dados_recebidos' => $dados]);

        foreach ($dados as $indice => $atividade) {
            // Verifica se já existe registro para este aluno, atividade, fase e flag
            $flag = isset($atividade['flag']) ? intval($atividade['flag']) : 1;
            $existe = $model::where('aluno_id', $alunoId)
                ->where('cod_atividade', $atividade['cod_atividade'])
                ->where('fase_cadastro', $faseCadastro)
                ->where('flag', $flag)
                ->exists();
            if ($existe) {
                Log::info("Atividade já cadastrada para o aluno {$alunoId}, eixo {$eixo}, atividade {$atividade['cod_atividade']}, flag {$flag} - ignorando novo cadastro.");
                continue;
            }
            Log::debug('Preparando para salvar registro', [
                'eixo' => $eixo,
                'atividade' => $atividade
            ]);

            // Verifica se há um código de atividade válido
            if (empty($atividade['cod_atividade'])) {
                Log::warning('Código de atividade não informado para o eixo: ' . $eixo, $atividade);
                continue;
            }

            $codAtividade = $atividade['cod_atividade'];
            
            // Determina o valor de 'realizado' com base nos checkboxes
            $realizado = null;
            if (isset($atividade['sim_inicial']) && $atividade['sim_inicial'] == '1') {
                $realizado = 1; // true no banco
            } elseif (isset($atividade['nao_inicial']) && $atividade['nao_inicial'] == '1') {
                $realizado = 0; // false no banco
            }

            // Log dos dados recebidos
            Log::debug("Dados recebidos para o eixo {$eixo} - Atividade {$codAtividade}", [
                'dados_completos' => $atividade,
                'observacoes_recebidas' => $atividade['observacoes'] ?? 'N/A',
                'tipo_observacoes' => gettype($atividade['observacoes'] ?? null)
            ]);

            // Validação linha a linha: só salva se data_aplicacao estiver preenchida E pelo menos um dos checkboxes de apoio estiver marcado
            $sim = isset($atividade['sim_inicial']) && $atividade['sim_inicial'] == '1';
            $nao = isset($atividade['nao_inicial']) && $atividade['nao_inicial'] == '1';
            if (empty($atividade['data_inicial']) || (!$sim && !$nao)) {
                Log::info("Linha ignorada por faltar data_inicial ou apoio (sim/nao)", ['atividade' => $atividade]);
                continue; // Pula linhas incompletas
            }

            // Prepara os dados para salvar
            $registro_timestamp = $timestampBase + $indice; // Garante valor único por linha
            $dadosSalvar = [
                'aluno_id' => $alunoId,
                'cod_atividade' => $codAtividade,
                'fase_cadastro' => $faseCadastro,
                'data_aplicacao' => $atividade['data_inicial'],
                'realizado' => $realizado,
                'observacoes' => isset($atividade['observacoes']) ? (string)$atividade['observacoes'] : '', // Força string
                'registro_timestamp' => $registro_timestamp, // Agora único por linha
                'flag' => isset($atividade['flag']) ? intval($atividade['flag']) : 1 // Usa o valor exato do flag da linha
            ];
            
            Log::debug('Dados preparados para salvar', [
                'dados_salvar' => $dadosSalvar,
                'tem_observacoes' => isset($dadosSalvar['observacoes']),
                'valor_observacoes' => $dadosSalvar['observacoes'],
                'flag_recebido' => $atividade['flag'] ?? 'não definido',
                'flag_processado' => $dadosSalvar['flag']
            ]);

            // Garante que observacoes sempre exista no array, mesmo que vazio
            if (!array_key_exists('observacoes', $dadosSalvar)) {
                $dadosSalvar['observacoes'] = '';
                Log::debug('Campo observacoes não existia, foi adicionado como string vazia');
            } else {
                Log::debug('Campo observacoes existe', [
                    'valor' => $dadosSalvar['observacoes'],
                    'tipo' => gettype($dadosSalvar['observacoes'])
                ]);
            }

            try {
                // Logs detalhados antes de salvar
                Log::debug("Salvando registro {$model}", [
                    'dados' => $dadosSalvar,
                    'observacoes' => $dadosSalvar['observacoes'],
                    'isDirty_observacoes' => true,
                    'original_observacoes' => 'N/A'
                ]);
                
                // Cria nova instância e salva
                Log::debug("Criando registro {$model}", [
                    'dados' => $dadosSalvar,
                    'attributes' => $dadosSalvar,
                    'observacoes' => $dadosSalvar['observacoes'],
                    'exists' => false,
                    'isDirty' => true,
                    'original' => 'N/A'
                ]);
                
                $registro = $model::create($dadosSalvar);
                
                Log::debug("Registro {$model} criado", [
                    'id' => $registro->id ?? 'N/A',
                    'observacoes' => $registro->observacoes ?? 'N/A',
                    'attributes' => $registro->getAttributes() ?? []
                ]);
                
                Log::info("Registro inserido com sucesso na tabela do eixo $eixo", ['dados' => $dadosSalvar]);
                Log::info("Salvando dados para o eixo: $eixo", [
                    'aluno_id' => $alunoId,
                    'cod_atividade' => $codAtividade,
                    'dados' => $dadosSalvar,
                    'tem_observacoes' => isset($dadosSalvar['observacoes'])
                ]);
                
                $registrosSalvos++;
            } catch (\Exception $e) {
                Log::error("Erro ao salvar atividade do eixo $eixo: " . $e->getMessage(), [
                    'aluno_id' => $alunoId,
                    'cod_atividade' => $codAtividade,
                    'dados' => $dadosSalvar,
                    'trace' => $e->getTraceAsString()
                ]);
                    
                // Se for erro de chave duplicada no eixo de comunicação, tenta com um novo timestamp
                if ($e->getCode() == 23000 && $eixo === 'comunicacao') { // Código para violação de chave única
                    try {
                        $dadosSalvar['registro_timestamp'] = now()->timestamp + 1; // Adiciona 1 segundo
                        $model::create($dadosSalvar);
                        $registrosSalvos++;
                        Log::info("Registro salvo com sucesso após ajuste do timestamp");
                    } catch (\Exception $e2) {
                        Log::error("Erro ao salvar após ajuste do timestamp: " . $e2->getMessage());
                    }
                }
            }
        }

        Log::info("Foram salvos $registrosSalvos registros para o eixo $eixo");
    }

    /**
     * Retorna o model correspondente ao eixo
     * 
     * @param  string  $eixo
     * @return string|null
     */
    protected function getModelPorEixo($eixo)
    {
        switch ($eixo) {
            case 'comunicacao':
                return AtividadeComunicacao::class;
            case 'comportamento':
                return AtividadeComportamento::class;
            case 'socioemocional':
                return AtividadeSocioemocional::class;
            default:
                return null;
        }
    }

    /**
     * Carrega os dados salvos de um aluno
     * 
     * @param  int  $alunoId
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Carrega os dados de monitoramento de um aluno
     *
     * @param int $alunoId ID do aluno
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Carrega os dados de monitoramento para exibição na view
     *
     * @param int $alunoId
     * @return array
     */
    public function carregarParaView($alunoId)
    {
        try {
            $eixos = [
                'comunicacao' => AtividadeComunicacao::class,
                'comportamento' => AtividadeComportamento::class,
                'socioemocional' => AtividadeSocioemocional::class
            ];
            $dados = [];
            $faseCadastro = $this->obterFaseAtual();
            // Adiciona também uma lista de combinações já cadastradas para marcação na view
            $jaCadastradas = [
                'comunicacao' => [],
                'comportamento' => [],
                'socioemocional' => []
            ];
            foreach ($eixos as $tipo => $modelClass) {
                // Busca todos os registros do aluno e fase
                $registros = $modelClass::where('aluno_id', $alunoId)
                    ->where('fase_cadastro', $faseCadastro)
                    ->orderBy('registro_timestamp', 'desc')
                    ->get();
                $dados[$tipo] = [];
                foreach ($registros as $item) {
                    // Marca a combinação já cadastrada
                    $chaveFlag = $item->cod_atividade . '-' . ($item->flag ?? 1);
                    $jaCadastradas[$tipo][$chaveFlag] = true;

                    $dados[$tipo][$item->cod_atividade][] = [
                        'id' => $item->id,
                        'registro_timestamp' => $item->registro_timestamp,
                        'data_aplicacao' => (is_object($item->data_aplicacao) && method_exists($item->data_aplicacao, 'format'))
                            ? $item->data_aplicacao->format('Y-m-d')
                            : ($item->data_aplicacao ?? null),
                        'realizado' => (bool)$item->realizado,
                        'observacoes' => $item->observacoes,
                        'fase_cadastro' => $item->fase_cadastro,
                        'flag' => $item->flag ?? 1, // Inclui o campo flag com valor padrão 1
                        'created_at' => ($item->created_at && method_exists($item->created_at, 'toDateTimeString'))
                            ? $item->created_at->toDateTimeString() : ($item->created_at ?? null),
                        'updated_at' => ($item->updated_at && method_exists($item->updated_at, 'toDateTimeString'))
                            ? $item->updated_at->toDateTimeString() : ($item->updated_at ?? null),
                    ];
                }
            }
            // Retorna os dados e as combinações já cadastradas para a view
            return [
                'dados' => $dados,
                'jaCadastradas' => $jaCadastradas
            ];
        } catch (\Throwable $e) {
            \Log::error("Erro ao carregar dados de monitoramento: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Exemplo mínimo para debug visual na Blade
     */
    public function exemploMonitoramento($alunoId)
    {
        $dados = $this->carregarParaView($alunoId);
        return view('rotina_monitoramento.monitoramento_blade_exemplo', [
            'alunoId' => $alunoId,
            'dados' => $dados,
        ]);
    }

    /**
     * Obtém a fase atual do monitoramento (In = Inicial)
     * 
     * @return string Código da fase atual
     */
    protected function obterFaseAtual()
    {
        // Por padrão, usamos a fase inicial (In)
        return 'In';
    }
    
    public function carregar($alunoId)
    {
        try {
            // Validar se o ID do aluno é válido
            if (!is_numeric($alunoId) || $alunoId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do aluno inválido.'
                ], 400);
            }
            
            // Carregar os dados de cada eixo
            $dados = [];
            $eixos = [
                'comunicacao' => AtividadeComunicacao::class,
                'comportamento' => AtividadeComportamento::class,
                'socioemocional' => AtividadeSocioemocional::class
            ];
            
            foreach ($eixos as $tipo => $modelClass) {
                $dados[$tipo] = $modelClass::where('aluno_id', $alunoId)
                    ->where('fase_cadastro', $this->obterFaseAtual())
                    ->orderBy('registro_timestamp', 'desc')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [
                            $item->cod_atividade => [
                                'id' => $item->id,
                                'data_aplicacao' => (is_object($item->data_aplicacao) && method_exists($item->data_aplicacao, 'format'))
                                    ? $item->data_aplicacao->format('Y-m-d')
                                    : ($item->data_aplicacao ?? null),
                                'realizado' => (bool)$item->realizado,
                                'observacoes' => $item->observacoes,
                                'fase_cadastro' => $item->fase_cadastro,
                                'flag' => $item->flag ?? 1, // Inclui o campo flag com valor padrão 1
                                'registro_timestamp' => $item->registro_timestamp, // Inclui o registro_timestamp
                                'created_at' => ($item->created_at && method_exists($item->created_at, 'toDateTimeString'))
                                    ? $item->created_at->toDateTimeString() : ($item->created_at ?? null),
                                'updated_at' => ($item->updated_at && method_exists($item->updated_at, 'toDateTimeString'))
                                    ? $item->updated_at->toDateTimeString() : ($item->updated_at ?? null),
                            ]
                        ];
                    })
                    ->toArray();
            }

            return response()->json([
                'success' => true,
                'data' => $dados,
                'metadata' => [
                    'aluno_id' => (int)$alunoId,
                    'fase_cadastro' => $this->obterFaseAtual(),
                    'total_registros' => array_sum(array_map('count', $dados)),
                    'timestamp' => now()->toDateTimeString()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao carregar monitoramento: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao carregar os dados.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
    /**
     * Exibe o formulário de Indicativo Inicial para o aluno selecionado
     * 
     * @param int $id ID do aluno
     * @return \Illuminate\View\View
     */
    public function indicativoInicial($id)
    {
        // Verifica se o aluno pertence ao professor logado
        $professor_logado = auth('funcionario')->user();
        $professor_id = $professor_logado ? $professor_logado->func_id : null;

        // Valida se aluno pertence ao professor
        $aluno = \App\Models\Aluno::where('alu_id', $id)
            ->whereHas('matriculas.turma', function($q) use ($professor_id) {
                $q->where('fk_cod_func', $professor_id);
            })->first();
        if (!$aluno) {
            return back()->withErrors(['msg' => 'Aluno não pertence ao professor logado ou não existe.']);
        }

        // Garante que existe registro nas três tabelas-eixo
        $tem_eixo_com = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $id)->exists();
        $tem_eixo_int = \App\Models\EixoInteracaoSocEmocional::where('fk_alu_id_eintsoc', $id)->exists();
        $tem_eixo_comp = \App\Models\EixoComportamento::where('fk_alu_id_ecomp', $id)->exists();
        if (!($tem_eixo_com && $tem_eixo_int && $tem_eixo_comp)) {
            return back()->withErrors(['msg' => 'O aluno precisa ter registros em todos os eixos (Comunicação, Interação Socioemocional e Comportamento) para acessar esta rotina.']);
        }

        // Carrega os dados detalhados do aluno
        $alunoDetalhado = \App\Models\Aluno::getAlunosDetalhados($id);
        if (!$alunoDetalhado) {
            return back()->withErrors(['msg' => 'Não foi possível carregar os dados do aluno.']);
        }
        
        // Carrega os dados de monitoramento para a view
        $dados = $this->carregarParaView($id);
        
        // Buscar data inicial do eixo comunicação linguagem, se necessário
        $eixoCom = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $id)
            ->where('fase_inv_com_lin', 'In')
            ->first();
        $data_inicial_com_lin = $eixoCom ? $eixoCom->data_insert_com_lin : null;
        
        // Buscar resultados dos três eixos
        $comunicacao_resultados = \App\Models\ResultEixoComLin::where('fk_id_pro_com_lin', $id)->paginate(20);
        $comportamento_resultados = \App\Models\ResultEixoComportamento::where('fk_result_alu_id_comportamento', $id)->paginate(20);
        $socioemocional_resultados = \App\Models\ResultEixoIntSocio::where('fk_result_alu_id_int_socio', $id)->paginate(20);
        
        // DATA DE HOJE PARA FILTRO
        $hoje = date('Y-m-d');
        // Consultar quantas vezes cada código de atividade já foi registrado HOJE por eixo
        $comportamentoRegistrosHoje = DB::table('cad_ativ_eixo_comportamento')
            ->select('cod_atividade', DB::raw('COUNT(*) as total'))
            ->where('aluno_id', $id)
            ->where('data_aplicacao', $hoje)
            ->groupBy('cod_atividade')
            ->pluck('total', 'cod_atividade')
            ->toArray();
        $comunicacaoRegistrosHoje = DB::table('cad_ativ_eixo_com_lin')
            ->select('cod_atividade', DB::raw('COUNT(*) as total'))
            ->where('aluno_id', $id)
            ->where('data_aplicacao', $hoje)
            ->groupBy('cod_atividade')
            ->pluck('total', 'cod_atividade')
            ->toArray();
        $socioemocionalRegistrosHoje = DB::table('cad_ativ_eixo_int_socio')
            ->select('cod_atividade', DB::raw('COUNT(*) as total'))
            ->where('aluno_id', $id)
            ->where('data_aplicacao', $hoje)
            ->groupBy('cod_atividade')
            ->pluck('total', 'cod_atividade')
            ->toArray();

        // 1. Buscar todas as atividades realizadas pelo aluno
        $comunicacao_atividades_realizadas = DB::table('cad_ativ_eixo_com_lin as caecl')
            ->join('atividade_com_lin as acl', 'caecl.cod_atividade', '=', 'acl.cod_ati_com_lin')
            ->where('caecl.aluno_id', $id)
            ->select('acl.desc_ati_com_lin as descricao_atividade', 'acl.cod_ati_com_lin as cod_atividade')
            ->distinct()
            ->orderBy('acl.desc_ati_com_lin')
            ->get();

        // Extrair os códigos das atividades realizadas
        $codigos_atividades_realizadas = $comunicacao_atividades_realizadas->pluck('cod_atividade');

        // 2. Buscar todas as habilidades relacionadas a essas atividades
        $comunicacao_habilidades_encontradas = [];
        if ($codigos_atividades_realizadas->isNotEmpty()) {
            $comunicacao_habilidades_encontradas = DB::table('hab_pro_com_lin as hpc')
                ->join('habilidade_com_lin as hcl', 'hpc.fk_id_hab_com_lin', '=', 'hcl.id_hab_com_lin')
                ->whereIn('hpc.cod_atividade', $codigos_atividades_realizadas)
                ->select('hcl.desc_hab_com_lin as descricao_habilidade')
                ->distinct()
                ->orderBy('hcl.desc_hab_com_lin')
                ->get();
        }

        // Consulta agrupada: atividades e habilidades do eixo Comportamento para o aluno
        $comportamento_agrupado = DB::select("
            SELECT 
              ac.desc_ati_comportamento AS atividade,
              hc.desc_hab_comportamento AS habilidade
            FROM 
              cad_ativ_eixo_comportamento cae
            INNER JOIN 
              atividade_comportamento ac ON cae.cod_atividade = ac.cod_ati_comportamento
            LEFT JOIN 
              hab_pro_comportamento hpc ON ac.id_ati_comportamento = hpc.fk_id_pro_comportamento
            LEFT JOIN 
              habilidade_comportamento hc ON hpc.fk_id_hab_comportamento = hc.id_hab_comportamento
            WHERE cae.aluno_id = ?
            GROUP BY ac.id_ati_comportamento, hc.id_hab_comportamento
            ORDER BY ac.desc_ati_comportamento, hc.desc_hab_comportamento
        ", [$id]);

        // Consulta agrupada: atividades e habilidades do eixo Socioemocional para o aluno
        $socioemocional_agrupado = DB::select("
            SELECT 
              ais.desc_ati_int_soc AS atividade,
              his.desc_hab_int_soc AS habilidade
            FROM 
              cad_ativ_eixo_int_socio caeis
            INNER JOIN 
              atividade_int_soc ais ON caeis.cod_atividade = ais.cod_ati_int_soc
            LEFT JOIN 
              hab_pro_int_soc hpis ON ais.id_ati_int_soc = hpis.fk_id_pro_int_soc
            LEFT JOIN 
              habilidade_int_soc his ON hpis.fk_id_hab_int_soc = his.id_hab_int_soc
            WHERE caeis.aluno_id = ?
            GROUP BY ais.id_ati_int_soc, his.id_hab_int_soc
            ORDER BY ais.desc_ati_int_soc, his.desc_hab_int_soc
        ", [$id]);

        // Retorna a view com os dados necessários
        return view('rotina_monitoramento.IndicativoInicial', array_merge($dados, [
            'alunoDetalhado' => $alunoDetalhado,
            'data_inicial_com_lin' => $data_inicial_com_lin,
            'comunicacao_resultados' => $comunicacao_resultados,
            'comportamento_resultados' => $comportamento_resultados,
            'socioemocional_resultados' => $socioemocional_resultados,
            'comportamentoRegistrosHoje' => $comportamentoRegistrosHoje,
            'comunicacaoRegistrosHoje' => $comunicacaoRegistrosHoje,
            'socioemocionalRegistrosHoje' => $socioemocionalRegistrosHoje,
            'comunicacao_atividades_realizadas' => $comunicacao_atividades_realizadas,
            'comunicacao_habilidades_encontradas' => $comunicacao_habilidades_encontradas,
            'comportamento_agrupado' => $comportamento_agrupado,
            'socioemocional_agrupado' => $socioemocional_agrupado,
        ]));
    }
}

// ... (rest of the code remains the same)
