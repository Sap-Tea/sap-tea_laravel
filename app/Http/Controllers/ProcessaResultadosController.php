<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EixoComunicacaoLinguagem;
use App\Models\EixoComportamento;
use App\Models\EixoInteracaoSocEmocional;
use App\Models\HabProComLin;
use App\Models\HabProComportamento;
use App\Models\HabProIntSoc;
use App\Models\ResultEixoComLin;
use App\Models\ResultEixoComportamento;
use App\Models\ResultEixoIntSocio;
use Carbon\Carbon;

class ProcessaResultadosController extends Controller
{
    // Função para exibir o monitoramento do aluno (ajuste o nome conforme o seu controller)
    public function monitoramentoAluno(Request $request)
    {
        // Consulta agrupada Comunicação/Linguagem
        $comunicacao_linguagem_agrupado = \DB::select("
            SELECT 
                r.fk_id_pro_com_lin,
                r.fk_result_alu_id_ecomling,
                r.tipo_fase_com_lin,
                a.cod_ati_com_lin,
                a.desc_ati_com_lin,
                COUNT(*) AS total
            FROM 
                result_eixo_com_lin r
            JOIN 
                atividade_com_lin a ON r.fk_id_pro_com_lin = a.id_ati_com_lin
            GROUP BY
                r.fk_id_pro_com_lin,
                r.fk_result_alu_id_ecomling,
                r.tipo_fase_com_lin,
                a.cod_ati_com_lin,
                a.desc_ati_com_lin
            ORDER BY
                r.fk_result_alu_id_ecomling
        ");
        // Consulta agrupada Comportamento
        $comportamento_agrupado = \DB::select("
            SELECT 
                r.fk_id_pro_comportamento,
                r.fk_result_alu_id_comportamento,
                r.tipo_fase_comportamento,
                a.cod_ati_comportamento,
                a.desc_ati_comportamento,
                COUNT(*) AS total
            FROM 
                result_eixo_comportamento r
            JOIN 
                atividade_comportamento a ON r.fk_id_pro_comportamento = a.id_ati_comportamento
            GROUP BY
                r.fk_id_pro_comportamento,
                r.fk_result_alu_id_comportamento,
                r.tipo_fase_comportamento,
                a.cod_ati_comportamento,
                a.desc_ati_comportamento
            ORDER BY
                r.fk_result_alu_id_comportamento
        ");
        // Consulta agrupada Interação Socioemocional
        $socioemocional_agrupado = \DB::select("
            SELECT 
                r.fk_id_pro_int_socio,
                r.fk_result_alu_id_int_socio,
                r.tipo_fase_int_socio,
                a.cod_ati_int_socio,
                a.desc_ati_int_socio,
                COUNT(*) AS total
            FROM 
                result_eixo_int_socio r
            JOIN 
                atividade_int_socio a ON r.fk_id_pro_int_socio = a.id_ati_int_socio
            GROUP BY
                r.fk_id_pro_int_socio,
                r.fk_result_alu_id_int_socio,
                r.tipo_fase_int_socio,
                a.cod_ati_int_socio,
                a.desc_ati_int_socio
            ORDER BY
                r.fk_result_alu_id_int_socio
        ");

        // Garante arrays vazios se não houver dados
        $comunicacao_linguagem_agrupado = $comunicacao_linguagem_agrupado ?: [];
        $comportamento_agrupado = $comportamento_agrupado ?: [];
        $socioemocional_agrupado = $socioemocional_agrupado ?: [];

        // Retorna para a view
        return view('rotina_monitoramento.monitoramento_aluno', compact(
            'comunicacao_linguagem_agrupado',
            'comportamento_agrupado',
            'socioemocional_agrupado'
        ));
    }

    // Chama todos os processamentos de eixo para o aluno informado
    public function debugEixoComLin($alunoId)
    {
        $eixo = EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $alunoId)
            ->orderByDesc('data_insert_com_lin')
            ->first();
        $indices = [];
        for ($i = 1; $i <= 32; $i++) {
            $campo = 'ecm' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if ($eixo && $eixo->$campo == 1) {
                $indices[] = $i;
            }
        }
        $habilidades = [];
        foreach ($indices as $indice) {
            $hab = HabProComLin::where('fk_id_hab_com_lin', $indice)->first();
            if ($hab) {
                $habilidades[] = [
                    'fk_hab_pro_com_lin' => $hab->id_hab_pro_com_lin,
                    'fk_id_pro_com_lin' => $hab->fk_id_pro_com_lin,
                    'fk_result_alu_id_ecomling' => $eixo->fk_alu_id_ecomling,
                    'date_cadastro' => now(),
                    'tipo_fase_com_lin' => $eixo->fase_inv_com_lin
                ];
            }
        }
        return [
            'indices_sim' => $indices,
            'habilidades_propostas' => $habilidades
        ];
    }

    public function debugEixoComportamento($alunoId)
    {
        $eixo = EixoComportamento::where('fk_alu_id_ecomp', $alunoId)
            ->orderByDesc('data_insert_comportamento')
            ->first();
        $indices = [];
        for ($i = 1; $i <= 17; $i++) {
            $campo = 'ecp' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if ($eixo && $eixo->$campo == 1) {
                $indices[] = $i;
            }
        }
        $habilidades = [];
        foreach ($indices as $indice) {
            $hab = HabProComportamento::where('fk_id_hab_comportamento', $indice)->first();
            if ($hab) {
                $habilidades[] = [
                    'fk_hab_pro_comportamento' => $hab->id_hab_pro_comportamento,
                    'fk_id_pro_comportamento' => $hab->fk_id_pro_comportamento,
                    'fk_result_alu_id_comportamento' => $eixo->fk_alu_id_ecomp,
                    'date_cadastro' => now(),
                    'tipo_fase_comportamento' => $eixo->fase_inv_comportamento
                ];
            }
        }
        return [
            'indices_sim' => $indices,
            'habilidades_propostas' => $habilidades
        ];
    }

    public function debugEixoIntSocio($alunoId)
    {
        $eixo = EixoInteracaoSocEmocional::where('fk_alu_id_eintsoc', $alunoId)
            ->orderByDesc('data_insert_int_socio')
            ->first();
        $indices = [];
        for ($i = 1; $i <= 18; $i++) {
            $campo = 'eis' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if ($eixo && $eixo->$campo == 1) {
                $indices[] = $i;
            }
        }
        $habilidades = [];
        foreach ($indices as $indice) {
            $hab = HabProIntSoc::where('fk_id_hab_int_soc', $indice)->first();
            if ($hab) {
                $habilidades[] = [
                    'fk_hab_pro_int_socio' => $hab->id_hab_pro_int_soc,
                    'fk_id_pro_int_socio' => $hab->fk_id_pro_int_soc,
                    'fk_result_alu_id_int_socio' => $eixo->fk_alu_id_eintsoc,
                    'date_cadastro' => now(),
                    'tipo_fase_int_socio' => $eixo->fase_inv_int_socio
                ];
            }
        }
        return [
            'indices_sim' => $indices,
            'habilidades_propostas' => $habilidades
        ];
    }

    public function inserirTodosEixos($alunoId)
    {
        $resultados = [];
        // Comunicação/Linguagem
        $eixoComunicacao = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $alunoId)
            ->orderByDesc('data_insert_com_lin')
            ->first();
        $resultados['comunicacao_linguagem'] = [];
        if ($eixoComunicacao) {
            $indicesMarcados = [];
            for ($i = 1; $i <= 32; $i++) {
                $campo = 'ecm' . str_pad($i, 2, '0', STR_PAD_LEFT);
                if (isset($eixoComunicacao->$campo) && intval($eixoComunicacao->$campo) === 0) {
                    $indicesMarcados[] = $i;
                }
            }
            if (count($indicesMarcados)) {
                $propostas = \App\Models\HabProComLin::whereIn('fk_id_hab_com_lin', $indicesMarcados)->get();
                $registros = [];
                foreach ($propostas as $proposta) {
                    $registros[] = [
                        'fk_hab_pro_com_lin' => $proposta->fk_id_hab_com_lin,
                        'fk_id_pro_com_lin' => $proposta->fk_id_pro_com_lin,
                        'fk_result_alu_id_ecomling' => $alunoId,
                        'date_cadastro' => now(),
                        'tipo_fase_com_lin' => $eixoComunicacao->fase_inv_com_lin
                    ];
                }
                if (count($registros)) {
                    \App\Models\ResultEixoComLin::insert($registros);
                    $resultados['comunicacao_linguagem'] = $registros;
                }
            }
        }
        // Comportamento
        $eixoComportamento = \App\Models\EixoComportamento::where('fk_alu_id_ecomp', $alunoId)
            ->orderByDesc('data_insert_comportamento')
            ->first();
        $resultados['comportamento'] = [];
        if ($eixoComportamento) {
            $indicesMarcados = [];
            for ($i = 1; $i <= 17; $i++) {
                $campo = 'ecp' . str_pad($i, 2, '0', STR_PAD_LEFT);
                if (isset($eixoComportamento->$campo) && intval($eixoComportamento->$campo) === 0) {
                    $indicesMarcados[] = $i;
                }
            }
            if (count($indicesMarcados)) {
                $propostas = \App\Models\HabProComportamento::whereIn('fk_id_hab_comportamento', $indicesMarcados)->get();
                $registros = [];
                foreach ($propostas as $proposta) {
                    $registros[] = [
                        'fk_hab_pro_comportamento' => $proposta->fk_id_hab_comportamento,
                        'fk_id_pro_comportamento' => $proposta->fk_id_pro_comportamento,
                        'fk_result_alu_id_comportamento' => $alunoId,
                        'date_cadastro' => now(),
                        'tipo_fase_comportamento' => $eixoComportamento->fase_inv_comportamento
                    ];
                }
                if (count($registros)) {
                    \App\Models\ResultEixoComportamento::insert($registros);
                    $resultados['comportamento'] = $registros;
                }
            }
        }
        // Interação Socioemocional
        $eixoIntSocio = \App\Models\EixoInteracaoSocEmocional::where('fk_alu_id_eintsoc', $alunoId)
            ->orderByDesc('data_insert_int_socio')
            ->first();
        $resultados['interacao_socioemocional'] = [];
        if ($eixoIntSocio) {
            $indicesMarcados = [];
            for ($i = 1; $i <= 18; $i++) {
                $campo = 'eis' . str_pad($i, 2, '0', STR_PAD_LEFT);
                if (isset($eixoIntSocio->$campo) && intval($eixoIntSocio->$campo) === 0) {
                    $indicesMarcados[] = $i;
                }
            }
            if (count($indicesMarcados)) {
                $propostas = \App\Models\HabProIntSoc::whereIn('fk_id_hab_int_soc', $indicesMarcados)->get();
                $registros = [];
                foreach ($propostas as $proposta) {
                    $registros[] = [
                        'fk_hab_pro_int_socio' => $proposta->fk_id_hab_int_soc,
                        'fk_id_pro_int_socio' => $proposta->fk_id_pro_int_soc,
                        'fk_result_alu_id_int_socio' => $alunoId,
                        'date_cadastro' => now(),
                        'tipo_fase_int_socio' => $eixoIntSocio->fase_inv_int_socio
                    ];
                }
                if (count($registros)) {
                    \App\Models\ResultEixoIntSocio::insert($registros);
                    $resultados['interacao_socioemocional'] = $registros;
                }
            }
        }
        return $resultados;
    }

    // Exemplo para eixo_com_lin
    public function processaEixoComLin($alunoId)
    {
        $eixo = EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $alunoId)->first();
        if (!$eixo) {
            return response()->json(['error' => 'Inventário não encontrado para o aluno'], 404);
        }
        $indices = [];
        for ($i = 1; $i <= 32; $i++) {
            $campo = 'ecm' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if ($eixo->$campo == 1) {
                $indices[] = $i;
            }
        }
        $habilidades = [];
        foreach ($indices as $indice) {
            $hab = HabProComLin::where('fk_id_hab_com_lin', $indice)->first();
            if ($hab) {
                $habilidades[] = [
                    'fk_hab_pro_com_lin' => $hab->id_hab_pro_com_lin,
                    'fk_id_pro_com_lin' => $hab->fk_id_pro_com_lin,
                    'fk_result_alu_id_ecomling' => $eixo->fk_alu_id_ecomling,
                    'date_cadastro' => \Carbon\Carbon::now(),
                    'tipo_fase_com_lin' => $eixo->fase_inv_com_lin
                ];
            }
        }
        // Otimização: insert em lote com transação
        $resultadosInseridos = [];
        \DB::transaction(function () use (&$habilidades, &$resultadosInseridos) {
            if (count($habilidades) > 0) {
                \App\Models\ResultEixoComLin::insert($habilidades);
                // Para exibir o JSON igual antes, buscamos os registros inseridos (opcional: pode-se retornar só os dados enviados)
                $resultadosInseridos = $habilidades;
            }
        });
        return response()->json(['message' => 'Resultados processados com sucesso', 'dados' => $resultadosInseridos]);
    }
}
