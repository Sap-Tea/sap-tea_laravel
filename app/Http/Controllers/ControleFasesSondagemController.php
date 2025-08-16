<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControleFasesSondagemController extends Controller
{
    /**
     * Garante a criação do registro inicial em controle_fases_sondagem
     * somente se NÃO existir para (id_aluno, ano).
     * - fase_inicial deve ficar 'In' na criação
     * - Demais campos permanecem com defaults do schema
     *
     * @param int $alunoId
     * @param int|null $ano Se nulo, usa ano corrente (Y)
     * @return array { created: bool, id?: int }
     */
    public function registrarInicialSeNaoExiste(int $alunoId, ?int $ano = null): array
    {
        $anoAtual = $ano ?? (int)date('Y');

        Log::info('[ControleFases] Verificando registro inicial', [
            'aluno_id' => $alunoId,
            'ano' => $anoAtual,
        ]);

        try {
            // Verifica existência por índice único (id_aluno, ano)
            $existe = DB::table('controle_fases_sondagem')
                ->where('id_aluno', $alunoId)
                ->where('ano', $anoAtual)
                ->exists();

            if ($existe) {
                Log::info('[ControleFases] Registro já existe, nenhuma ação necessária', [
                    'aluno_id' => $alunoId,
                    'ano' => $anoAtual,
                ]);
                return ['created' => false];
            }

            // Criação atômica com transação
            return DB::transaction(function () use ($alunoId, $anoAtual) {
                $now = now();
                $dados = [
                    'id_aluno' => $alunoId,
                    'ano' => $anoAtual,
                    'fase_inicial' => 'In', // conforme schema
                    // demais campos usam defaults do schema
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $id = DB::table('controle_fases_sondagem')->insertGetId($dados);

                Log::info('[ControleFases] Registro inicial criado com sucesso', [
                    'id' => $id,
                    'dados' => $dados,
                ]);

                return ['created' => true, 'id' => $id];
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Se outra transação criou no meio do caminho (violação de UNIQUE), tratamos como já existente
            $codigo = $e->errorInfo[1] ?? null; // MySQL duplicate key code é 1062
            if ((int)$codigo === 1062) {
                Log::warning('[ControleFases] Duplicate key detectado, tratando como já existente', [
                    'aluno_id' => $alunoId,
                    'ano' => $anoAtual,
                    'erro' => $e->getMessage(),
                ]);
                return ['created' => false];
            }

            Log::error('[ControleFases] Erro ao criar registro inicial', [
                'aluno_id' => $alunoId,
                'ano' => $anoAtual,
                'erro' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Throwable $e) {
            Log::error('[ControleFases] Erro inesperado ao criar registro inicial', [
                'aluno_id' => $alunoId,
                'ano' => $anoAtual,
                'erro' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
