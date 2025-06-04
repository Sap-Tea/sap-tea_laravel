<?php
-------
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
use App\Models\HabProIntSoc;

class ProcessaResultadosController extends Controller
{
    // Função para exibir o monitoramento do aluno (ajuste o nome conforme o seu controller)
    public function monitoramentoAluno(Request $request)
    {
        // Obter o ID do aluno da requisição
        $alunoId = $request->route('id');
        
        // Consulta agrupada Comunicação/Linguagem para o aluno específico
        $comunicacao_linguagem_agrupado = DB::select("
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
            WHERE
                r.fk_result_alu_id_ecomling = ?
            GROUP BY
                r.fk_id_pro_com_lin,
                r.fk_result_alu_id_ecomling,
                r.tipo_fase_com_lin,
                a.cod_ati_com_lin,
                a.desc_ati_com_lin
            ORDER BY
                COUNT(*) DESC
        ", [$alunoId]);
        // Consulta agrupada Comportamento - EXCLUINDO a atividade ECP03 (id=3) para o aluno específico
        $comportamento_agrupado = DB::select("
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
            WHERE
                r.fk_result_alu_id_comportamento = ? AND
                a.id_ati_comportamento != 3 AND 
                a.cod_ati_comportamento != 'ECP03'
            GROUP BY
                r.fk_id_pro_comportamento,
                r.fk_result_alu_id_comportamento,
                r.tipo_fase_comportamento,
                a.cod_ati_comportamento,
                a.desc_ati_comportamento
            ORDER BY
                COUNT(*) DESC
        ", [$alunoId]);
        // Consulta agrupada Interação Socioemocional - EXCLUINDO a atividade EIS01 (id=1) para o aluno específico
        $socioemocional_agrupado = DB::select("
            SELECT 
                r.fk_id_pro_int_socio,
                r.fk_result_alu_id_int_socio,
                r.tipo_fase_int_socio,
                a.cod_ati_int_soc,
                a.desc_ati_int_soc,
                a.id_ati_int_soc,
                COUNT(*) AS total
            FROM 
                result_eixo_int_soc r
            JOIN 
                atividade_int_soc a ON r.fk_id_pro_int_socio = a.id_ati_int_soc
            WHERE
                r.fk_result_alu_id_int_socio = ?
                AND a.id_ati_int_soc != 1
                AND a.cod_ati_int_soc != 'EIS01'
                AND r.fk_id_pro_int_socio != 1
            GROUP BY
                r.fk_id_pro_int_socio,
                r.fk_result_alu_id_int_socio,
                r.tipo_fase_int_socio,
                a.cod_ati_int_soc,
                a.desc_ati_int_soc,
                a.id_ati_int_soc
            ORDER BY
                COUNT(*) DESC
        ", [$alunoId]);

        // Garante arrays vazios se não houver dados
        $comunicacao_linguagem_agrupado = $comunicacao_linguagem_agrupado ?: [];
        $comportamento_agrupado = $comportamento_agrupado ?: [];
        $socioemocional_agrupado = $socioemocional_agrupado ?: [];

        // --- NOVO: calcular e passar as variáveis *_atividades_ordenadas ---
        // Comunicação/Linguagem (EIS01 aparece apenas uma vez, sem contagem de frequência)
        $comunicacao_frequencias = [];
        foreach ($comunicacao_linguagem_agrupado as $item) {
            $cod = $item->cod_ati_com_lin;
            $desc = $item->desc_ati_com_lin;
            // Se for EIS01, adiciona apenas uma vez e ignora a contagem
            if (strpos($cod, 'EIS01') === 0) {
                if (!isset($comunicacao_frequencias[$cod])) {
                    $comunicacao_frequencias[$cod] = [
                        'codigo' => $cod,
                        'descricao' => $desc,
                        'total' => 1 // Sempre 1
                    ];
                }
                continue;
            }
            // Para os demais, faz a contagem normalmente
            $total = $item->total;
            if (!isset($comunicacao_frequencias[$cod])) {
                $comunicacao_frequencias[$cod] = [
                    'codigo' => $cod,
                    'descricao' => $desc,
                    'total' => 0
                ];
            }
            $comunicacao_frequencias[$cod]['total'] += $total;
        }
        // Ordena por total desc
        usort($comunicacao_frequencias, function($a, $b) { return $b['total'] <=> $a['total']; });
        // Gera lista conforme frequência (EIS01 só entra uma vez)
        $comunicacao_atividades_ordenadas = [];
        foreach ($comunicacao_frequencias as $item) {
            $repeticoes = $item['total'];
            for ($i = 0; $i < $repeticoes; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_com_lin = $item['codigo'];
                $obj->desc_ati_com_lin = $item['descricao'];
                $comunicacao_atividades_ordenadas[] = $obj;
                // Se for EIS01, só adiciona uma vez
                if (strpos($item['codigo'], 'EIS01') === 0) {
                    break;
                }
            }
        }

        // Comportamento - IMPORTANTE: Excluir COMPLETAMENTE a atividade id=3 e código ECP03 de todas as contagens e resumos
        $comportamento_frequencias = [];
        foreach ($comportamento_agrupado as $item) {
            // Filtro mais abrangente: exclui a atividade ECP03 (id=3) de todas as contagens
            // Verifica se é a atividade com id=3 OU código ECP03
            if (
                (isset($item->id_ati_comportamento) && $item->id_ati_comportamento == 3) ||
                (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03')
            ) {
                // Pula completamente esta atividade
                continue;
            }
            
            $cod = $item->cod_ati_comportamento;
            $desc = $item->desc_ati_comportamento;
            $total = $item->total;
            
            // Verifica novamente pelo código para garantir que não seja ECP03
            if (strpos($cod, 'ECP03') === 0) {
                continue;
            }
            
            if (!isset($comportamento_frequencias[$cod])) {
                $comportamento_frequencias[$cod] = [
                    'codigo' => $cod,
                    'descricao' => $desc,
                    'total' => 0
                ];
            }
            $comportamento_frequencias[$cod]['total'] += $total;
        }
        
        // Ordena por total desc
        usort($comportamento_frequencias, function($a, $b) { return $b['total'] <=> $a['total']; });
        
        // Gera lista conforme frequência
        $comportamento_atividades_ordenadas = [];
        foreach ($comportamento_frequencias as $item) {
            // Garantia extra: nunca incluir ECP03 na lista ordenada
            if (strpos($item['codigo'], 'ECP03') === 0) {
                continue;
            }
            
            $repeticoes = $item['total'];
            for ($i = 0; $i < $repeticoes; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_comportamento = $item['codigo'];
                $obj->desc_ati_comportamento = $item['descricao'];
                $comportamento_atividades_ordenadas[] = $obj;
                // Se for ECP03, só adiciona uma vez
                if (strpos($item['codigo'], 'ECP03') === 0) {
                    break;
                }
            }
        }

        // Socioemocional - IMPORTANTE: Excluir COMPLETAMENTE a atividade id=1 e código EIS01
        $socioemocional_frequencias = [];
        foreach ($socioemocional_agrupado as $item) {
            // Excluir EIS01 por id da atividade, código OU fk_id_pro_int_socio
            if (
                (isset($item->id_ati_int_soc) && $item->id_ati_int_soc == 1) ||
                (isset($item->cod_ati_int_soc) && $item->cod_ati_int_soc === 'EIS01') ||
                (isset($item->fk_id_pro_int_socio) && $item->fk_id_pro_int_socio == 1)
            ) {
                continue;
            }
            $cod = $item->cod_ati_int_soc;
            $desc = $item->desc_ati_int_soc;
            $total = $item->total;
            if (!isset($socioemocional_frequencias[$cod])) {
                $socioemocional_frequencias[$cod] = [
                    'codigo' => $cod,
                    'descricao' => $desc,
                    'total' => 0
                ];
            }
            $socioemocional_frequencias[$cod]['total'] += $total;
        }
        
        // Ordena por total desc
        usort($socioemocional_frequencias, function($a, $b) { return $b['total'] <=> $a['total']; });
        
        // Gera lista conforme frequência
        $socioemocional_atividades_ordenadas = [];
        foreach ($socioemocional_frequencias as $item) {
            // Exatamente como no comportamento: não precisa filtrar aqui, já está filtrado
            $repeticoes = $item['total'];
            for ($i = 0; $i < $repeticoes; $i++) {
                $obj = new \stdClass();
                $obj->cod_ati_int_soc = $item['codigo'];
                $obj->desc_ati_int_soc = $item['descricao'];
                $socioemocional_atividades_ordenadas[] = $obj;
            }
        }
        // --- FIM NOVO ---

        // Manter o cálculo original para os totais dos resumos
        $total_eixos = 0;
        
        // Soma as atividades do eixo Comunicação/Linguagem
        foreach ($comunicacao_linguagem_agrupado as $item) {
            // Pula a atividade EIS01 se por acaso estiver aqui
            if (isset($item->cod_ati_com_lin) && $item->cod_ati_com_lin === 'EIS01') {
                continue;
            }
            if (isset($item->total)) {
                $total_eixos += (int)$item->total;
            }
        }

        // Soma as atividades de todos os eixos para o total_atividades, excluindo EIS01
        $total_atividades = 0;
        foreach ($comunicacao_linguagem_agrupado as $item) {
            if (isset($item->cod_ati_com_lin) && $item->cod_ati_com_lin === 'EIS01') {
                continue;
            }
            if (isset($item->total)) {
                $total_atividades += (int)$item->total;
            }
        }
        foreach ($comportamento_agrupado as $item) {
            if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') {
                continue;
            }
            if (isset($item->total)) {
                $total_atividades += (int)$item->total;
            }
        }
        foreach ($socioemocional_agrupado as $item) {
            if (
                (isset($item->cod_ati_int_soc) && $item->cod_ati_int_soc === 'EIS01') ||
                (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') ||
                (isset($item->fk_id_pro_int_socio) && $item->fk_id_pro_int_socio == 1)
            ) {
                continue;
            }
            if (isset($item->total)) {
                $total_atividades += (int)$item->total;
            }
        }
        
        // Soma as atividades do eixo Comportamento, EXCLUINDO a ECP03
        foreach ($comportamento_agrupado as $item) {
            // Pula a atividade ECP03
            if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') {
                continue;
            }
            
            if (isset($item->total)) {
                $total_eixos += (int)$item->total;
            }
        }
        
        // Soma as atividades do eixo Interação Socioemocional, EXCLUINDO a EIS01
        foreach ($socioemocional_agrupado as $item) {
            // Pula qualquer EIS01 por código ou vínculo (total geral)
            if (
                (isset($item->cod_ati_int_soc) && $item->cod_ati_int_soc === 'EIS01') ||
                (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') ||
                (isset($item->fk_id_pro_int_socio) && $item->fk_id_pro_int_socio == 1)
            ) {
                continue;
            }
            if (isset($item->total)) {
                $total_eixos += (int)$item->total;
            }
        }
        
        // Definir os totais individuais para cada eixo
        $total_comunicacao_linguagem = 0;
        $total_comportamento = 0;
        $total_socioemocional = 0;
        
        // Calcular totais individuais
        foreach ($comunicacao_linguagem_agrupado as $item) {
            if (isset($item->total)) {
                $total_comunicacao_linguagem += (int)$item->total;
            }
        }
        
        foreach ($comportamento_agrupado as $item) {
            if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') {
                continue;
            }
            if (isset($item->total)) {
                $total_comportamento += (int)$item->total;
            }
        }
        
        // Contar atividades de Interação Socioemocional (excluindo EIS01)
        foreach ($socioemocional_agrupado as $item) {
            // Pula qualquer EIS01 por código ou vínculo
            if (
                (isset($item->cod_ati_int_soc) && $item->cod_ati_int_soc === 'EIS01') ||
                (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') ||
                (isset($item->fk_id_pro_int_socio) && $item->fk_id_pro_int_socio == 1)
            ) {
                continue;
            }
            if (isset($item->total)) {
                $total_socioemocional += (int)$item->total;
            }
        }
        // Passar o debug para a view
        $debug_info = json_encode($debug_totais);
        
        // Log para depuração
        \Log::info('Debug Info no Controller:', ['debug_info' => $debug_info]);

        // Retorna para a view com todas as variáveis necessárias
        return view('rotina_monitoramento.monitoramento_aluno', [
            'alunoDetalhado' => $aluno,
            'comunicacao_linguagem_agrupado' => $comunicacao_linguagem_agrupado,
            'comportamento_agrupado' => $comportamento_agrupado,
            'socioemocional_agrupado' => $socioemocional_agrupado,
            'comunicacao_atividades_ordenadas' => $comunicacao_atividades_ordenadas,
            'comportamento_atividades_ordenadas' => $comportamento_atividades_ordenadas,
            'socioemocional_atividades_ordenadas' => $socioemocional_atividades_ordenadas,
            'total_eixos' => $total_eixos,
            'total_atividades' => $total_atividades, // Adicionado o total de atividades
            'total_comunicacao' => $total_comunicacao_linguagem,
            'total_comportamento' => $total_comportamento,
            'total_socioemocional' => $total_socioemocional,
            'comunicacao_resultados' => $comunicacao_resultados ?? [],
            'comportamento_resultados' => $comportamento_resultados ?? [],
            'socioemocional_resultados' => $socioemocional_resultados ?? [],
            'data_inicial_com_lin' => $data_inicial_com_lin ?? null,
            'detalhe' => $detalhe ?? null,

// Ordena por total desc
usort($comportamento_frequencias, function($a, $b) { return $b['total'] <=> $a['total']; });

// Gera lista conforme frequência
$comportamento_atividades_ordenadas = [];
foreach ($comportamento_frequencias as $item) {
    // Garantia extra: nunca incluir ECP03 na lista ordenada
    if (strpos($item['codigo'], 'ECP03') === 0) {
        continue;
    }

    $repeticoes = $item['total'];
    for ($i = 0; $i < $repeticoes; $i++) {
        $obj = new \stdClass();
        $obj->cod_ati_comportamento = $item['codigo'];
        $obj->desc_ati_comportamento = $item['descricao'];
        $comportamento_atividades_ordenadas[] = $obj;
        // Se for ECP03, só adiciona uma vez
        if (strpos($item['codigo'], 'ECP03') === 0) {
            break;
        }
    }
}

// Socioemocional - IMPORTANTE: Excluir COMPLETAMENTE a atividade id=1 e código EIS01
$socioemocional_frequencias = [];
foreach ($socioemocional_agrupado as $item) {
    // Filtro para excluir a atividade EIS01 (id=1) de todas as contagens
    // Verifica se é a atividade com id=1 OU código EIS01
    if (
        (isset($item->id_ati_int_socio) && $item->id_ati_int_socio == 1) ||
        (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01')
    ) {
        // Pula completamente esta atividade
        continue;
    }

    $cod = $item->cod_ati_int_socio;
    $desc = $item->desc_ati_int_socio;
    $total = $item->total;

    // Verifica novamente pelo código para garantir que não seja EIS01
    if (strpos($cod, 'EIS01') === 0) {
        continue;
    }

    if (!isset($socioemocional_frequencias[$cod])) {
        $socioemocional_frequencias[$cod] = [
            'codigo' => $cod,
            'descricao' => $desc,
            'total' => 0
        ];
    }
    $socioemocional_frequencias[$cod]['total'] += $total;
}

// Ordena por total desc
usort($socioemocional_frequencias, function($a, $b) { return $b['total'] <=> $a['total']; });

// Gera lista conforme frequência
$socioemocional_atividades_ordenadas = [];
foreach ($socioemocional_frequencias as $item) {
    // Garantia extra: nunca incluir EIS01 na lista ordenada
    if (strpos($item['codigo'], 'EIS01') === 0) {
        continue;
    }

    $repeticoes = $item['total'];
    for ($i = 0; $i < $repeticoes; $i++) {
        $obj = new \stdClass();
        $obj->cod_ati_int_socio = $item['codigo'];
        $obj->desc_ati_int_socio = $item['descricao'];
        $socioemocional_atividades_ordenadas[] = $obj;
    }
}
// --- FIM NOVO ---

// Manter o cálculo original para os totais dos resumos
$total_eixos = 0;

// Soma as atividades do eixo Comunicação/Linguagem
foreach ($comunicacao_linguagem_agrupado as $item) {
    // Pula a atividade EIS01 se por acaso estiver aqui
    if (isset($item->cod_ati_com_lin) && $item->cod_ati_com_lin === 'EIS01') {
        continue;
    }

    if (isset($item->total)) {
        $total_eixos += (int)$item->total;
    }
}

// Soma as atividades do eixo Comportamento, EXCLUINDO a ECP03
foreach ($comportamento_agrupado as $item) {
    // Pula a atividade ECP03
    if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') {
        continue;
    }

    if (isset($item->total)) {
        $total_eixos += (int)$item->total;
    }
}

// Soma as atividades do eixo Interação Socioemocional, EXCLUINDO a EIS01
foreach ($socioemocional_agrupado as $item) {
    // Pula a atividade EIS01
    if (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') {
        continue;
    }

    if (isset($item->total)) {
        $total_eixos += (int)$item->total;
    }
}

// Definir os totais individuais para cada eixo
$total_comunicacao_linguagem = 0;
$total_comportamento = 0;
$total_socioemocional = 0;

// Calcular totais individuais
foreach ($comunicacao_linguagem_agrupado as $item) {
    if (isset($item->total)) {
        $total_comunicacao_linguagem += (int)$item->total;
    }
}

foreach ($comportamento_agrupado as $item) {
    if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') {
        continue;
    }
    if (isset($item->total)) {
        $total_comportamento += (int)$item->total;
    }
}

// Contar atividades de Interação Socioemocional (excluindo EIS01)
foreach ($socioemocional_agrupado as $item) {
    // Pular EIS01

// Passar o debug para a view
$debug_info = json_encode($debug_totais);

// Log para depuração
\Log::info('Debug Info no Controller:', ['debug_info' => $debug_info]);

// Retorna para a view com todas as variáveis necessárias
return view('rotina_monitoramento.monitoramento_aluno', [
    'alunoDetalhado' => $aluno,
    'comunicacao_linguagem_agrupado' => $comunicacao_linguagem_agrupado,
    'comportamento_agrupado' => $comportamento_agrupado,
    'socioemocional_agrupado' => $socioemocional_agrupado,
    'comunicacao_atividades_ordenadas' => $comunicacao_atividades_ordenadas,
    'comportamento_atividades_ordenadas' => $comportamento_atividades_ordenadas,
    'socioemocional_atividades_ordenadas' => $socioemocional_atividades_ordenadas,
    'total_eixos' => $total_eixos,
    'total_atividades' => $total_atividades, // Adicionado o total de atividades
    'total_comunicacao' => $total_comunicacao_linguagem,
    'total_comportamento' => $total_comportamento,
    'total_socioemocional' => $total_socioemocional,
    'comunicacao_resultados' => $comunicacao_resultados ?? [],
    'comportamento_resultados' => $comportamento_resultados ?? [],
    'socioemocional_resultados' => $socioemocional_resultados ?? [],
    'data_inicial_com_lin' => $data_inicial_com_lin ?? null,
    'detalhe' => $detalhe ?? null,
    'debug_info' => $debug_info // Adicionado para debug
]);

}

public function processaEixoComLin(Request $request)
{
    $alunoId = $request->route('id');
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
                'date_cadastro' => now(),
                'tipo_fase_com_lin' => $eixo->fase_inv_com_lin
            ];
        }
    }
    // Otimização: insert em lote com transação
    $resultadosInseridos = [];
    DB::transaction(function () use (&$habilidades, &$resultadosInseridos) {
        if (count($habilidades) > 0) {
            \App\Models\ResultEixoComLin::insert($habilidades);
            // Para exibir o JSON igual antes, buscamos os registros inseridos (opcional: pode-se retornar só os dados enviados)
            $resultadosInseridos = $habilidades;
        }
    });
    return response()->json(['message' => 'Resultados processados com sucesso', 'dados' => $resultadosInseridos]);
}

public function debugEixoComportamento(Request $request)
{
    $alunoId = $request->route('id');
    $eixo = EixoComportamento::where('fk_alu_id_ecomp', $alunoId)->first();
    // ... (restante do código)
    if (!$eixo) {
        return response()->json(['error' => 'Inventário não encontrado para o aluno'], 404);
    }
    $indices = [];
    for ($i = 1; $i <= 17; $i++) {
        $campo = 'ecp' . str_pad($i, 2, '0', STR_PAD_LEFT);
        if ($eixo->$campo == 1) {
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
    // Otimização: insert em lote com transação
    $resultadosInseridos = [];
    DB::transaction(function () use (&$habilidades, &$resultadosInseridos) {
        if (count($habilidades) > 0) {
            \App\Models\ResultEixoComportamento::insert($habilidades);
            // Para exibir o JSON igual antes, buscamos os registros inseridos (opcional: pode-se retornar só os dados enviados)
            $resultadosInseridos = $habilidades;
        }
    });
    return response()->json(['message' => 'Resultados processados com sucesso', 'dados' => $resultadosInseridos]);
}

public function debugEixoIntSocio(Request $request)
{
    $alunoId = $request->route('id');
    $eixo = EixoInteracaoSocEmocional::where('fk_alu_id_eintsoc', $alunoId)->first();
    if (!$eixo) {
        return response()->json(['error' => 'Inventário não encontrado para o aluno'], 404);
    }
    $indices = [];
    for ($i = 1; $i <= 18; $i++) {
        $campo = 'eis' . str_pad($i, 2, '0', STR_PAD_LEFT);
        if ($eixo->$campo == 1) {
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
    // Otimização: insert em lote com transação
    $resultadosInseridos = [];
    DB::transaction(function () use (&$habilidades, &$resultadosInseridos) {
        if (count($habilidades) > 0) {
            \App\Models\ResultEixoIntSocio::insert($habilidades);
            // Para exibir o JSON igual antes, buscamos os registros inseridos (opcional: pode-se retornar só os dados enviados)
            $resultadosInseridos = $habilidades;
        }
    });
    return response()->json(['message' => 'Resultados processados com sucesso', 'dados' => $resultadosInseridos]);
}

public function inserirTodosEixos(Request $request)
{
    $alunoId = $request->route('id');
    $resultados = [];
    // Comunicação/Linguagem
    $eixoComunicacao = \App\Models\EixoComunicacaoLinguagem::where('fk_alu_id_ecomling', $alunoId)->first();
    $resultados['comunicacao_linguagem'] = [];
    if ($eixoComunicacao) {
        $indicesMarcados = [];
        for ($i = 1; $i <= 32; $i++) {
            $campo = 'ecm' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (intval($eixoComunicacao->$campo) === 0) {
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
    $eixoComportamento = \App\Models\EixoComportamento::where('fk_alu_id_ecomp', $alunoId)->first();
    $resultados['comportamento'] = [];
    if ($eixoComportamento) {
        $indicesMarcados = [];
        for ($i = 1; $i <= 17; $i++) {
            $campo = 'ecp' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (intval($eixoComportamento->$campo) === 0) {
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

    public function debugEixoIntSocio(Request $request)
    {
        $alunoId = $request->route('id');
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

    public function inserirTodosEixos(Request $request)
    {
        $alunoId = $request->route('id');
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
    }
    return $resultados;
            }
        }
        // Otimização: insert em lote com transação
        $resultadosInseridos = [];
        DB::transaction(function () use (&$habilidades, &$resultadosInseridos) {
            if (count($habilidades) > 0) {
                \App\Models\ResultEixoComLin::insert($habilidades);
                // Para exibir o JSON igual antes, buscamos os registros inseridos (opcional: pode-se retornar só os dados enviados)
                $resultadosInseridos = $habilidades;
            }
        });
        return response()->json(['message' => 'Resultados processados com sucesso', 'dados' => $resultadosInseridos]);
    }
}
