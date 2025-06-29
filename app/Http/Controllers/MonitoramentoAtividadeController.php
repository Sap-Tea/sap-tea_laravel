<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtividadeComunicacao;
use App\Models\AtividadeComportamento;
use App\Models\AtividadeSocioemocional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        
        // Código para salvar os dados do monitoramento
        try {
            DB::beginTransaction();

            // Validar os dados recebidos
            $request->validate([
                'aluno_id' => 'required|integer|exists:aluno,alu_id',
                'comunicacao' => 'sometimes|array',
                'comportamento' => 'sometimes|array',
                'socioemocional' => 'sometimes|array',
            ]);

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
            $this->salvarEixo($alunoId, 'comunicacao', $dadosProcessados['comunicacao'] ?? []);
            $this->salvarEixo($alunoId, 'comportamento', $dadosProcessados['comportamento'] ?? []);
            $this->salvarEixo($alunoId, 'socioemocional', $dadosProcessados['socioemocional'] ?? []);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dados salvos com sucesso!',
                'data' => [
                    'aluno_id' => $alunoId,
                    'fase_cadastro' => $faseCadastro,
                    'registros_salvos' => array_sum(array_map('count', $dadosProcessados))
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
     * @param  int  $alunoId
     * @param  string  $eixo
     * @param  array  $dados
     * @return void
     */
    /**
     * Salva os dados de um eixo específico
     *
     * @param int $alunoId ID do aluno
     * @param string $eixo Nome do eixo (comunicacao, comportamento, socioemocional)
     * @param array $dados Dados a serem salvos
     * @return void
     */
    protected function salvarEixo($alunoId, $eixo, $dados)
    {
        $model = $this->getModelPorEixo($eixo);
        if (!$model) {
            Log::error("Model não encontrada para o eixo: " . $eixo);
            return;
        }

        $faseCadastro = $this->obterFaseAtual();
        $registrosSalvos = 0;
        $timestampBase = now()->timestamp;

        // Loga o array recebido do request antes de qualquer filtro
        Log::debug('Recebido do request para o eixo ' . $eixo, ['dados_recebidos' => $dados]);

        // Filtra atividades inválidas (sem cod_atividade ou array vazio)
        $dados = array_filter($dados, function($a) {
            if (!is_array($a) || empty($a['cod_atividade'])) return false;
            // Só descarta se data, sim e não estiverem todos vazios
            return (
                (!empty($a['data_inicial'])) ||
                (!empty($a['sim_inicial'])) ||
                (!empty($a['nao_inicial']))
            );
        });

        Log::debug('Filtro de atividades válidas para o eixo ' . $eixo, ['dados_validos' => $dados, 'dados_recebidos' => $dados]);

        foreach ($dados as $indice => $atividade) {
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

            // Prepara os dados para salvar
            $registro_timestamp = $timestampBase + $indice; // Garante valor único por linha
            $dadosSalvar = [
                'aluno_id' => $alunoId,
                'cod_atividade' => $codAtividade,
                'fase_cadastro' => $faseCadastro,
                'data_aplicacao' => $atividade['data_inicial'] ?? null,
                'realizado' => $realizado,
                'observacoes' => isset($atividade['observacoes']) ? (string)$atividade['observacoes'] : '', // Força string
                'registro_timestamp' => $registro_timestamp // Agora único por linha
            ];
            
            Log::debug('Dados preparados para salvar', [
                'dados_salvar' => $dadosSalvar,
                'tem_observacoes' => isset($dadosSalvar['observacoes']),
                'valor_observacoes' => $dadosSalvar['observacoes']
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

            // Remove valores vazios, exceto os campos obrigatórios
            $dadosSalvar = array_filter($dadosSalvar, function($value, $key) {
                $camposObrigatorios = ['registro_timestamp', 'observacoes', 'aluno_id', 'cod_atividade', 'fase_cadastro'];
                return ($value !== null && $value !== '') || in_array($key, $camposObrigatorios);
            }, ARRAY_FILTER_USE_BOTH);

            // Log para debug
            Log::info("Salvando dados para o eixo: {$eixo}", [
                'aluno_id' => $alunoId, 
                'cod_atividade' => $codAtividade,
                'dados' => $dadosSalvar,
                'tem_observacoes' => array_key_exists('observacoes', $dadosSalvar)
            ]);

            // Verifica se há dados para salvar (considera que sempre terá pelo menos os campos obrigatórios)
            $camposRelevantes = array_diff(array_keys($dadosSalvar), ['aluno_id', 'cod_atividade', 'fase_cadastro']);
            if (!empty($camposRelevantes)) {
                try {
                    // Para o eixo de comunicação, usamos uma chave única que inclui o timestamp
                    if ($eixo === 'comunicacao') {
                        // Cria um novo registro com o timestamp atual
                        $model::create($dadosSalvar);
                    } else {
                        // Para comportamento e socioemocional, usar create() para garantir múltiplos registros
                        $model::create($dadosSalvar);
                    }
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
     * @param int $alunoId ID do aluno
     * @return array Dados formatados para a view
     */
    public function carregarParaView($alunoId)
    {
        try {
            // Validar se o ID do aluno é válido
            if (!is_numeric($alunoId) || $alunoId <= 0) {
                Log::info("ID de aluno inválido: {$alunoId}");
                return [];
            }
            
            Log::info("Carregando dados de monitoramento para o aluno ID: {$alunoId}");
            
            // Carregar os dados de cada eixo
            $dados = [];
            $eixos = [
                'comunicacao' => AtividadeComunicacao::class,
                'comportamento' => AtividadeComportamento::class,
                'socioemocional' => AtividadeSocioemocional::class
            ];
            
            foreach ($eixos as $tipo => $modelClass) {
                $fase = $this->obterFaseAtual();
                Log::info("Buscando registros do eixo {$tipo} para aluno {$alunoId} na fase {$fase}");
                
                $registros = $modelClass::where('aluno_id', $alunoId)
                    ->where('fase_cadastro', $fase)
                    ->get();
                
                Log::info("Encontrados " . count($registros) . " registros para o eixo {$tipo}");
                
                $dados[$tipo] = [];
                foreach ($registros as $registro) {
                    // Garantir que o registro tenha um código de atividade válido
                    if (empty($registro->cod_atividade)) {
                        Log::warning("Registro sem código de atividade encontrado para o eixo {$tipo}");
                        continue;
                    }
                    
                    Log::info("Processando registro de atividade {$registro->cod_atividade} do eixo {$tipo}");
                    
                    // Formatar a data no formato YYYY-MM-DD para o input type="date"
                    $dataAplicacao = $registro->data_aplicacao;
                    if ($dataAplicacao && strpos($dataAplicacao, '/') !== false) {
                        $partes = explode('/', $dataAplicacao);
                        if (count($partes) === 3) {
                            $dataAplicacao = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
                        }
                    }
                    
                    $dados[$tipo][$registro->cod_atividade] = [
                        'data_inicial' => $dataAplicacao,
                        'sim_inicial' => $registro->realizado == 1 ? '1' : '0',
                        'nao_inicial' => $registro->realizado == 0 ? '1' : '0',
                        'observacoes' => $registro->observacoes,
                        'cod_atividade' => $registro->cod_atividade
                    ];
                    
                    Log::info("Dados formatados para {$registro->cod_atividade}: " . json_encode($dados[$tipo][$registro->cod_atividade]));
                }
            }
            
            Log::info("Dados de monitoramento carregados com sucesso: " . json_encode($dados));
            return $dados;
        } catch (\Exception $e) {
            Log::error('Erro ao carregar dados para view: ' . $e->getMessage());
            return [];
        }
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
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [
                            $item->cod_atividade => [
                                'id' => $item->id,
                                'data_aplicacao' => $item->data_aplicacao ? $item->data_aplicacao->format('Y-m-d') : null,
                                'realizado' => (bool)$item->realizado,
                                'observacoes' => $item->observacoes,
                                'fase_cadastro' => $item->fase_cadastro,
                                'created_at' => $item->created_at ? $item->created_at->toDateTimeString() : null,
                                'updated_at' => $item->updated_at ? $item->updated_at->toDateTimeString() : null
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
}
