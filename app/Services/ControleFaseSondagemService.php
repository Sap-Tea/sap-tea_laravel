<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControleFaseSondagemService
{
    /**
     * Atualiza os contadores de fase para um aluno com base na fase de cadastro da atividade.
     *
     * @param int $alunoId
     * @return ControleFaseSondagem|null
     */
    /**
     * Atualiza os contadores de fase para um aluno com base na fase de cadastro da atividade.
     *
     * @param int $alunoId ID do aluno
     * @param string $faseCadastro Fase da atividade ('Inicial', 'Cont1', 'Cont2', 'Final')
     * @param string $eixo Eixo da atividade ('com_lin', 'comportamento', 'socioemocional')
     * @return array Resultado da operação
     */
    /**
     * Atualiza os contadores de fase para um aluno
     * 
     * @param int $alunoId ID do aluno
     * @param string $faseCadastro Fase da atividade ('Inicial', 'Cont1', 'Cont2', 'Final')
     * @param string $eixo Eixo da atividade (não utilizado, mantido para compatibilidade)
     * @return array Resultado da operação
     */
    public function atualizarContadores($alunoId, $faseCadastro = 'Inicial', $eixo = null)
    {
        Log::info('=== INÍCIO ControleFaseSondagemService ===');
        Log::info('Iniciando atualização de contadores', [
            'aluno_id' => $alunoId,
            'fase_cadastro' => $faseCadastro,
            'eixo' => $eixo,
            'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)
        ]);
        
        // Verificação crítica de parâmetros
        if (empty($alunoId)) {
            Log::error('ID do aluno não fornecido!');
            return ['success' => false, 'message' => 'ID do aluno é obrigatório'];
        }
        
        // Usando a tabela existente (sem coluna de eixo)
        $tabelaControle = 'controle_fases_sondagem';
        
        Log::info('Iniciando atualização de contadores', [
            'aluno_id' => $alunoId,
            'fase' => $faseCadastro,
            'tabela' => $tabelaControle,
            'obs' => 'Usando tabela única para todos os eixos, sem distinção por eixo'
        ]);
        
        $anoAtual = date('Y');
        
        // Mapeia a fase de cadastro para o campo de contador correspondente
        $mapFaseParaContador = [
            'Inicial' => 'cont_I',
            'Cont1' => 'cont_fase_c1',
            'Cont2' => 'cont_fase_c2',
            'Final' => 'cont_fase_final'
        ];
        
        // Obtém o nome do campo do contador com base na fase de cadastro
        $campoContador = $mapFaseParaContador[$faseCadastro] ?? 'cont_I';
        
        Log::info('Mapeamento de fase para contador', [
            'fase_cadastro' => $faseCadastro,
            'campo_contador' => $campoContador
        ]);
        
        try {
            // Verifica se a tabela existe
            $tabelaExiste = DB::select("SHOW TABLES LIKE '{$tabelaControle}'");
            
            Log::info('Verificando existência da tabela', [
                'tabela' => $tabelaControle,
                'existe' => !empty($tabelaExiste) ? 'sim' : 'não'
            ]);
            
            if (empty($tabelaExiste)) {
                $erro = "Tabela {$tabelaControle} não existe";
                Log::error($erro);
                return ['success' => false, 'message' => $erro];
            }
            
            // Garante que o registro de controle de fases exista para o aluno e ano
            // Como não temos coluna de eixo, usamos um único registro por aluno/ano para todos os eixos
            $controle = DB::table($tabelaControle)
                ->where('id_aluno', $alunoId)
                ->where('ano', $anoAtual)
                ->first();
                
            Log::info('Registro encontrado na tabela de controle:', [
                'existe' => $controle ? 'sim' : 'não',
                'dados' => $controle ? (array)$controle : null
            ]);
                
            Log::info('Registro de controle encontrado:', [
                'existe' => $controle ? 'sim' : 'não',
                'dados' => $controle ? (array)$controle : null,
                'query' => DB::table($tabelaControle)
                    ->where('id_aluno', $alunoId)
                    ->where('ano', $anoAtual)
                    ->toSql()
            ]);
                
            if (!$controle) {
                // Cria um novo registro se não existir
                $dadosIniciais = [
                    'id_aluno' => $alunoId,
                    'ano' => $anoAtual,
                    'fase_inicial' => 'Pendente',
                    'cont_I' => 0,
                    'fase_cont1' => 'Pendente',
                    'cont_fase_c1' => 0,
                    'fase_cont2' => 'Pendente',
                    'cont_fase_c2' => 0,
                    'fase_final' => 'Pendente',
                    'cont_fase_final' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                Log::info('Criando novo registro com os dados:', [
                    'dados' => $dadosIniciais,
                    'obs' => 'Criando registro de controle para aluno/ano (sem eixo)'
                ]);
                
                Log::info('Criando novo registro na tabela', [
                    'tabela' => $tabelaControle,
                    'dados' => $dadosIniciais
                ]);
                
                $id = DB::table($tabelaControle)->insertGetId($dadosIniciais);
                $controle = DB::table($tabelaControle)->find($id);
                
                Log::info('Novo registro de controle criado', [
                    'id' => $id,
                    'registro' => (array)$controle
                ]);
            }

            // Incrementa o contador específico
            Log::info('Incrementando contador', [
                'tabela' => $tabelaControle,
                'id' => $controle->id,
                'campo' => $campoContador,
                'valor_atual' => $controle->{$campoContador} ?? 0
            ]);
            
            // Busca o registro novamente para garantir que temos os dados mais recentes
            $controleAtual = DB::table($tabelaControle)
                ->where('id', $controle->id)
                ->lockForUpdate() // Bloqueia o registro para evitar condições de corrida
                ->first();
                
            $valorAtual = $controleAtual->{$campoContador} ?? 0;
            
            Log::info('Dados antes do incremento:', [
                'id_registro' => $controle->id,
                'contador_atual' => $valorAtual,
                'campo' => $campoContador,
                'tabela' => $tabelaControle
            ]);
            
            // Usa uma transação para garantir a atomicidade da operação
            DB::beginTransaction();
            
            try {
                // Usando update ao invés de increment para ter mais controle
                $novoValor = $valorAtual + 1;
                $result = DB::table($tabelaControle)
                    ->where('id', $controle->id)
                    ->update([
                        $campoContador => $novoValor,
                        'updated_at' => now()
                    ]);
                    
                DB::commit();
                
                Log::info('Resultado da atualização:', [
                    'linhas_afetadas' => $result,
                    'valor_anterior' => $valorAtual,
                    'novo_valor' => $novoValor,
                    'campo' => $campoContador,
                    'query' => DB::table($tabelaControle)
                        ->where('id', $controle->id)
                        ->toSql(),
                    'bindings' => [$controle->id]
                ]);
                
                // Busca novamente para ver o valor atualizado
                $controleAtualizado = DB::table($tabelaControle)
                    ->where('id', $controle->id)
                    ->first();
                    
                Log::info('Dados após incremento:', [
                    'id_registro' => $controle->id,
                    'contador_atual' => $controleAtualizado->{$campoContador} ?? 0,
                    'campo' => $campoContador,
                    'todos_os_campos' => $controleAtualizado
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao incrementar contador:', [
                    'erro' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
                
            // Atualiza o status da fase se necessário
            $this->atualizarStatusFase($controle->id, $campoContador, $tabelaControle);
            
            // Obtém os valores atualizados
            $controleAtualizado = DB::table($tabelaControle)
                ->where('id', $controle->id)
                ->first();
                
            Log::info('Contador atualizado', [
                'tabela' => $tabelaControle,
                'id' => $controle->id,
                'campo' => $campoContador,
                'novo_valor' => $controleAtualizado->{$campoContador} ?? 0
            ]);
            
            Log::info('Contador incrementado com sucesso', [
                'aluno_id' => $alunoId,
                'fase' => $faseCadastro,
                'campo_incrementado' => $campoContador,
                'novo_valor' => $controleAtualizado->$campoContador
            ]);
            
            return [
                'success' => true, 
                'message' => 'Contador atualizado com sucesso',
                'data' => $controleAtualizado
            ];
            
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar contadores', [
                'aluno_id' => $alunoId,
                'fase' => $faseCadastro,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false, 
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Atualiza o status de uma fase quando o contador atinge 3
     * 
     * @param int $controleId
     * @param string $campoContador
     * @param string $tabelaControle Nome da tabela de controle
     * @return void
     */
    protected function atualizarStatusFase($controleId, $campoContador, $tabelaControle = 'controle_fases_sondagem')
    {
        $mapContadorParaStatus = [
            'cont_I' => 'fase_inicial',
            'cont_fase_c1' => 'fase_cont1',
            'cont_fase_c2' => 'fase_cont2',
            'cont_fase_final' => 'fase_final'
        ];
        
        $mapContadorParaValorStatus = [
            'cont_I' => 'In',
            'cont_fase_c1' => 'Cont1',
            'cont_fase_c2' => 'Cont2',
            'cont_fase_final' => 'Final'
        ];
        
        if (isset($mapContadorParaStatus[$campoContador])) {
            $campoStatus = $mapContadorParaStatus[$campoContador];
            $valorStatus = $mapContadorParaValorStatus[$campoContador];
            
            DB::table($tabelaControle)
                ->where('id', $controleId)
                ->where($campoStatus, 'Pendente')
                ->update([
                    $campoStatus => $valorStatus,
                    'updated_at' => now()
                ]);
                
            Log::info('Status de fase atualizado', [
                'controle_id' => $controleId,
                'campo_status' => $campoStatus,
                'novo_status' => $valorStatus
            ]);
        }
    }
}
