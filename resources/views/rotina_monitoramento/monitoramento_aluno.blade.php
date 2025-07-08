@extends('index')

@section('title', 'Monitoramento do estudante')

@section('styles')
<style>
    .no-break, h1, h2, h3 {
        page-break-inside: avoid;
        break-inside: avoid;
    }
    .monitoring-container {
        padding-bottom: 60px;
    }

    .comunicacao-bg {
        background: #A1D9F6 !important;
    }
    
    /* Estilos para o fluxo de cadastro */
    .spinner-border {
        margin-right: 5px;
    }

    .circle-success {
        width: 80px;
        height: 80px;
        background-color: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
    }

    /* Animações para o feedback visual */
    @keyframes pulseSuccess {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }

    .circle-success {
        animation: pulseSuccess 1.5s infinite;
    }

    /* Estilos para melhorar a aparência do formulário */
    .form-control:focus {
        border-color: #176ca7;
        box-shadow: 0 0 0 0.25rem rgba(23, 108, 167, 0.25);
    }

    .comunicacao-bg, .comportamento-bg, .socioemocional-bg {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Tooltips para melhor UX */
    .checkbox-tooltip {
        position: relative;
        cursor: pointer;
    }

    .checkbox-tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
    }
    .comunicacao-bg .result-table,
    .comunicacao-bg th,
    .comunicacao-bg td,
    .comunicacao-bg thead,
    .comunicacao-bg tbody,
    .comunicacao-bg tfoot {
        background: #A1D9F6 !important;
    }
    .comportamento-bg {
        background: #FFFF66 !important;
    }
    .comportamento-bg .result-table,
    .comportamento-bg th,
    .comportamento-bg td,
    .comportamento-bg thead,
    .comportamento-bg tbody,
    .comportamento-bg tfoot {
        background: #FFFF66 !important;
    }
    .socioemocional-bg {
        background: #E6F4EA !important;
    }
    .socioemocional-bg .result-table,
    .socioemocional-bg th,
    .socioemocional-bg td,
    .socioemocional-bg thead,
    .socioemocional-bg tbody,
    .socioemocional-bg tfoot {
        background: #E6F4EA !important;
    }
    
    /* Estilos para campos readonly */
    .campo-readonly {
        background-color: #f8f8f8 !important;
        color: #666 !important;
        border: 1px solid #ddd !important;
        cursor: not-allowed !important;
    }
    
    /* Estilos para checkboxes desabilitados */
    .checkbox-readonly {
        opacity: 0.7 !important;
        cursor: not-allowed !important;
    }
    
    /* Estilização visual para linhas com dados carregados */
    tr[data-possui-dados="true"] {
        background-color: #f0f7ff !important;
    }
    .table-bordered td, .table-bordered th {
      background: white !important;
    }
    .monitoring-container {
      background: #fff;
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    /* Removi .monitoring-page para evitar conflito de padding/margem */

    /* CABEÇALHO */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 3px solid #ff6600;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .header img {
      height: 60px;
      object-fit: contain;
    }
    .header .title {
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      color: #cc3300;
    }

    /* SEÇÃO DE INFORMAÇÕES */
    .info-section {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-bottom: 20px;
    }
    .info-section label {
      display: flex;
      flex-direction: column;
      font-weight: bold;
      font-size: 14px;
    }
    .info-section input {
      margin-top: 5px;
      padding: 6px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    /* INSTRUÇÕES DE PERÍODO */
    .period-section {
      margin-bottom: 20px;
      font-size: 14px;
      line-height: 1.5;
    }
    .period-section .period {
      display: inline-block;
      margin-right: 30px;
    }
    .period-section .period input {
      margin-left: 5px;
      width: 80px;
      padding: 4px;
    }

    /* TEXTO EXPLICATIVO / ORIENTAÇÕES */
    .instructions {
      background: #f0f0f0;
      padding: 10px;
      border-radius: 5px;
    }

    /* OBSERVAÇÕES FINAIS */
    .observations {
      font-size: 14px;
      line-height: 1.5;
      margin-bottom: 20px;
    }
    .observations textarea {
      width: 100%;
      height: 80px;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      resize: vertical;
      font-size: 14px;
    }

    /* ASSINATURAS */
    .signatures {
      display: flex;
      justify-content: space-around;
      margin-top: 30px;
    }
    .sign-box {
      text-align: center;
      font-size: 14px;
    }
    .sign-box .line {
      margin: 40px 0 5px;
      width: 250px;
      border-bottom: 1px solid #000;
      margin-left: auto;
      margin-right: auto;
    }

    /* Tabela de resultados dos eixos */
    .result-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
    }
    .result-table th, .result-table td {
      border: 1px solid #bbb;
      padding: 6px 6px;
      text-align: left;
      font-size: 15px;
      vertical-align: middle;
    }
    .result-table th {
      background: #f7f7f7;
      font-weight: bold;
      text-align: center;
    }
    .result-table td input[type="date"] {
      width: 120px;
      min-width: 100px;
      font-size: 14px;
    }
    .result-table td input[type="text"] {
      width: 100%;
      min-width: 100px;
      font-size: 14px;
    }
    .result-table td input[type="checkbox"] {
      display: block;
      margin: 0 auto;
      transform: scale(1.2);
    }
    .result-table th:nth-child(1), .result-table td:nth-child(1) {
      width: 70px;
      text-align: center;
    }
    .result-table th:nth-child(2), .result-table td:nth-child(2) {
      width: 220px;
    }
    .result-table th:nth-child(3), .result-table td:nth-child(3),
    .result-table th:nth-child(6), .result-table td:nth-child(6) {
      width: 120px;
      text-align: center;
    }
    .result-table th:nth-child(4), .result-table td:nth-child(4),
    .result-table th:nth-child(5), .result-table td:nth-child(5),
    .result-table th:nth-child(7), .result-table td:nth-child(7),
    .result-table th:nth-child(8), .result-table td:nth-child(8) {
      width: 45px;
      text-align: center;
    }
</style>

@section('content')

<form id="monitoramentoForm" method="POST" action="{{ route('monitoramento.salvar') }}">
    @csrf

    <input type="hidden" name="aluno_id" value="{{ $alunoId ?? '' }}">

@php
    // Garantir que os totais usados já excluem ECP03/EIS01 (devem vir do controller já filtrados)
    // Se não vierem, usar os resumos por eixo para calcular corretamente
    if (!isset($total_comunicacao_linguagem) && isset($comunicacao_linguagem_agrupado)) {
        $total_comunicacao_linguagem = 0;
        foreach ($comunicacao_linguagem_agrupado as $item) {
            if (isset($item->cod_ati_com_lin) && $item->cod_ati_com_lin === 'EIS01') continue;
            $total_comunicacao_linguagem += (int)($item->total ?? 0);
        }
    }
    if (!isset($total_comportamento) && isset($comportamento_agrupado)) {
        $total_comportamento = 0;
        foreach ($comportamento_agrupado as $item) {
            if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') continue;
            $total_comportamento += (int)($item->total ?? 0);
        }
    }
    if (!isset($total_socioemocional) && isset($socioemocional_agrupado)) {
        $total_socioemocional = 0;
        foreach ($socioemocional_agrupado as $item) {
            if (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') continue;
            $total_socioemocional += (int)($item->total ?? 0);
        }
    }
    // Soma final dos totais por eixo, considerando apenas o que aparece nos resumos (aplicando os mesmos filtros)
    $total_atividades = 0;
    foreach(($comunicacao_linguagem_agrupado ?? []) as $item) {
        if (isset($item->cod_ati_com_lin) && $item->cod_ati_com_lin === 'EIS01') continue;
        if (isset($item->total)) $total_atividades += (int)$item->total;
    }
    foreach(($comportamento_agrupado ?? []) as $item) {
        if (isset($item->cod_ati_comportamento) && $item->cod_ati_comportamento === 'ECP03') continue;
        if (isset($item->total)) $total_atividades += (int)$item->total;
    }
    foreach(($socioemocional_agrupado ?? []) as $item) {
        if (
            (isset($item->cod_ati_int_soc) && $item->cod_ati_int_soc === 'EIS01') ||
            (isset($item->cod_ati_int_socio) && $item->cod_ati_int_socio === 'EIS01') ||
            (isset($item->fk_id_pro_int_socio) && $item->fk_id_pro_int_socio == 1)
        ) continue;
        if (isset($item->total)) $total_atividades += (int)$item->total;
    }
    // Variável com divisão do total por 40
    $total_dividido = round($total_atividades / 40, 1);
    // Percentual: total_atividades / total_dividido * 100, limitado a 40
    $qtd_percentual = ($total_dividido > 0) ? round($total_atividades / $total_dividido * 100, 2) : 0;
    if ($qtd_percentual > 40) {
        $qtd_percentual = 40;
    }
    // Normalização dos totais dos eixos para inteiros cuja soma seja 40
    $totais_eixos = [
        'comunicacao' => $total_comunicacao_linguagem ?? 0,
        'comportamento' => $total_comportamento ?? 0,
        'socioemocional' => $total_socioemocional ?? 0,
    ];
    $total_geral = array_sum($totais_eixos);
    $normalizados = ['comunicacao' => 0, 'comportamento' => 0, 'socioemocional' => 0];
    $decimais = [];
    if ($total_geral > 0) {
        foreach ($totais_eixos as $k => $v) {
            $val = ($v / $total_geral) * 40;
            $normalizados[$k] = floor($val);
            $decimais[$k] = $val - floor($val);
        }
        $soma = array_sum($normalizados);
        $faltam = 40 - $soma;
        if ($faltam > 0) {
            arsort($decimais);
            foreach (array_keys($decimais) as $k) {
                if ($faltam <= 0) break;
                $normalizados[$k]++;
                $faltam--;
            }
        }
    }
// --- NORMALIZAÇÃO POR ATIVIDADE (SOMA EXATA 40) ---
$atividades_unicas = [];

// Comunicação/Linguagem
foreach (($comunicacao_linguagem_agrupado ?? []) as $linha) {
    if (!isset($linha->cod_ati_com_lin)) continue;
    $key = 'com_'.$linha->cod_ati_com_lin;
    $atividades_unicas[$key] = [
        'eixo' => 'comunicacao',
        'codigo' => $linha->cod_ati_com_lin,
        'descricao' => $linha->desc_ati_com_lin,
        'aluno' => $linha->fk_result_alu_id_ecomling,
        'fase' => $linha->tipo_fase_com_lin,
        'total' => $linha->total ?? 0,
    ];
}
// Comportamento (exclui ECP03)
foreach (($comportamento_agrupado ?? []) as $linha) {
    if (!isset($linha->cod_ati_comportamento) || $linha->cod_ati_comportamento === 'ECP03') continue;
    $key = 'comp_'.$linha->cod_ati_comportamento;
    $atividades_unicas[$key] = [
        'eixo' => 'comportamento',
        'codigo' => $linha->cod_ati_comportamento,
        'descricao' => $linha->desc_ati_comportamento,
        'aluno' => $linha->fk_result_alu_id_comportamento,
        'fase' => $linha->tipo_fase_comportamento,
        'total' => $linha->total ?? 0,
    ];
}
// Socioemocional (exclui EIS01 e fk_id_pro_int_socio == 1)
foreach (($socioemocional_agrupado ?? []) as $linha) {
    $cod = $linha->cod_ati_int_soc ?? $linha->cod_ati_int_socio ?? null;
    if (
        (isset($cod) && $cod === 'EIS01') ||
        (isset($linha->fk_id_pro_int_socio) && $linha->fk_id_pro_int_socio == 1)
    ) continue;
    $key = 'soc_'.$cod;
    $atividades_unicas[$key] = [
        'eixo' => 'socioemocional',
        'codigo' => $cod,
        'descricao' => $linha->desc_ati_int_soc ?? $linha->descricao ?? '',
        'aluno' => $linha->fk_result_alu_id_int_socio ?? '',
        'fase' => $linha->tipo_fase_int_socio ?? '',
        'total' => $linha->total ?? 0,
    ];
}
// Soma total de todas atividades
$total_atividades_geral = array_sum(array_column($atividades_unicas, 'total'));

// Calcula normalizados
$norm_atividades = [];
$decimais = [];
$soma_norm = 0;
if ($total_atividades_geral > 0) {
    foreach ($atividades_unicas as $key => $dados) {
        $val = ($dados['total'] / $total_atividades_geral) * 40;
        $norm_atividades[$key] = floor($val);
        $decimais[$key] = $val - floor($val);
        $soma_norm += $norm_atividades[$key];
    }
    // Distribui o restante para fechar 40
    $faltam = 40 - $soma_norm;
    $chaves_validas = array_keys($atividades_unicas); // só as que realmente exibem
    if ($faltam > 0) {
        // Adiciona +1 nos maiores decimais, só nas válidas
        arsort($decimais);
        foreach (array_keys($decimais) as $key) {
            if ($faltam <= 0) break;
            if (in_array($key, $chaves_validas)) {
                $norm_atividades[$key]++;
                $faltam--;
            }
        }
    } elseif ($faltam < 0) {
        // Remove -1 dos menores decimais, só nas válidas
        asort($decimais);
        foreach (array_keys($decimais) as $key) {
            if ($faltam >= 0) break;
            if (in_array($key, $chaves_validas) && $norm_atividades[$key] > 0) {
                $norm_atividades[$key]--;
                $faltam++;
            }
        }
    }
}
// --- FIM NORMALIZAÇÃO POR ATIVIDADE ---
@endphp

@if(!isset($alunoDetalhado) || empty($alunoDetalhado))
    <div style="background: #ffdddd; color: #a00; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <strong>Erro:</strong> Não foi possível carregar os dados do estudante. Por favor, acesse o formulário pela rota correta ou verifique se o estudante existe.
    </div>
@else
    <div class="monitoring-container">
        @php
            $detalhe = is_array($alunoDetalhado) ? (object)($alunoDetalhado[0] ?? []) : $alunoDetalhado;
        @endphp
        <div class="container">
            @include('rotina_monitoramento.partials.scripts_monitoramento')
        <div class="monitoring-container">
        <!-- CABEÇALHO -->
        <div class="header">
          <img src="{{ asset('img/LOGOTEA.png') }}" alt="Logo Educação" />
          <div class="title">
            @if(isset($contexto) && $contexto === 'indicativo_inicial')
              INDICATIVO INICIAL
            @else
              ROTINA E MONITORAMENTO DE <br>
              APLICAÇÃO DE ATIVIDADES 1 - INICIAL
            @endif
          </div>
          <img src="{{ asset('img/logo_sap.png') }}" alt="Logo SAP" />
        </div>

    @if(!empty($professor_nome))
      <div style="background: #ffe9b3; color: #b36b00; font-size: 1.3em; font-weight: bold; text-align: center; padding: 10px 0; border-radius: 7px; margin-bottom: 18px; box-shadow: 0 1px 6px #0001;">
        Professor(a) Responsável: {{ $professor_nome }}
      </div>
    @endif

    <!-- INFORMAÇÕES PRINCIPAIS -->
    <div class="info-section">
      <label>
        Secretaria de Educação do Município:
        <input type="text" value="{{ $detalhe->org_razaosocial ?? '-' }}" readonly />
      </label>
      <label>
        Escola:
        <input type="text" value="{{ $detalhe->esc_razao_social ?? '-' }}" readonly />
      </label>
      <label>
        Nome do estudante:
        <input type="text" value="{{ $detalhe->alu_nome ?? '-' }}" readonly />
      </label>
      <label>
        Data de Nascimento:
        <input type="text" value="{{ $detalhe->alu_dtnasc ? \Carbon\Carbon::parse($detalhe->alu_dtnasc)->format('d/m/Y') : '-' }}" readonly />
      </label>
      <label>
        Idade:
        <input type="text" value="{{ $detalhe->alu_dtnasc ? \Carbon\Carbon::parse($detalhe->alu_dtnasc)->age : '-' }}" readonly />
      </label>
      <label>
        Série:
        <input type="text" value="{{ $detalhe->serie_desc ?? '-' }}" readonly class="campo-readonly">
      </label>
      <label>
        Período:
        <input type="text" value="{{ $detalhe->periodo ?? '-' }}" readonly class="campo-readonly">
      </label>
      <label>
        Segmento:
        <input type="text" value="{{ $detalhe->desc_modalidade ?? '-' }}" readonly />
      </label>
      <label>
        Turma:
        <input type="text" value="{{ $detalhe->fk_cod_valor_turma ?? '-' }}" readonly />
      </label>
      <label>
        RA:
        <input type="text" value="{{ $detalhe->numero_matricula ?? '-' }}" readonly />
      </label>
    </div>

    <!-- PERÍODO DE APLICAÇÃO -->
    <div class="period-section">
      <span class="period">
        <strong>Data da sondagem</strong>
        <input type="text" name="periodo_inicial" value="{{ $data_inicial_com_lin ? \Carbon\Carbon::parse($data_inicial_com_lin)->format('d/m/Y') : '' }}" readonly />
      </span>

    </div>

    @if($data_inicial_com_lin)
      <div style="color: #b30000; font-weight: bold; margin-bottom: 10px; font-size: 16px;">
        Já se passaram {{ \Carbon\Carbon::parse($data_inicial_com_lin)->diffInDays(\Carbon\Carbon::now()) }} dias desde a realização da sondagem

       
      </div>
    @endif

    <!-- INSTRUÇÕES -->
    <div class="instructions">
      <p><strong></strong></p>
      <p>Caro(a) educador(a),</p>
      <p style="color: #0056b3;">
        Inicie diariamente com as atividades MINHA ROTINA e EMOCIONÔMETRO.<br>
        Após a aplicação da(s) atividade(s), informe a data (campo obrigatório) e se houve necessidade de apoio (campo obrigatório).<br>
        Registre aspectos relevantes no campo observação.<br>
        REVISE E CONFIRA AS INFORMAÇÕS REGISTRADAS ANTES DE SALVAR O DOCUMENTO.
      </p>
      <p style="color: #0056b3; font-style: italic;">Observação: Em caso de dúvidas, consulte o suporte técnico ou administrativo para orientação.</p>
    </div>
    
    <!-- Alerta sobre modo de visualização (inicialmente oculto) -->
    <div id="mensagemModoVisualizacao" class="alert alert-info" style="display: none; margin: 15px 0; padding: 12px; border-left: 5px solid #2196F3; background-color: #e3f2fd; color: #0c5460;">
      <i class="fas fa-eye mr-2"></i> <strong>Modo de Visualização:</strong> Os dados estão sendo exibidos em modo somente leitura. Os campos não podem ser editados pois representam registros já salvos no sistema.
    </div>

    <!-- TABELA DE ATIVIDADES -->
    {{-- EIXO COMUNICAÇÃO/LINGUAGEM (PADRÃO VISUAL) --}}
<div class="comunicacao-bg" style="border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom:15px;"
    ><div class="table-title" style="font-size:20px; color:#b28600; text-align:center;">Eixo Comunicação/Linguagem</div>
    @php
        // Determina o ID do estudante de forma segura
        $alunoId = null;
        if (is_array($alunoDetalhado) && isset($alunoDetalhado[0]) && isset($alunoDetalhado[0]->alu_id)) {
            $alunoId = $alunoDetalhado[0]->alu_id;
        } elseif (is_object($alunoDetalhado) && isset($alunoDetalhado->alu_id)) {
            $alunoId = $alunoDetalhado->alu_id;
        }
    @endphp
    <a href="{{ route('grafico.comunicacao', ['alunoId' => $alunoId]) }}" class="btn btn-primary d-none" style="background-color: #b28600; border-color: #b28600;"><i class="fas fa-chart-bar"></i> Ver Gráfico</a>
  </div>

  {{-- REGISTROS JÁ CADASTRADOS --}}
  @if(isset($dadosMonitoramento['comunicacao']) && count($dadosMonitoramento['comunicacao']))
    <div style="margin-bottom:12px;">
      <strong>Registros já cadastrados:</strong>
      <table class="result-table" style="margin-bottom:8px;">
        <thead>
          <tr style="background:#ffd966;">
            <th>Código</th>
            <th>Data</th>
            <th>Realizado?</th>
            <th>Observações</th>
            <th>Registro Timestamp</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dadosMonitoramento['comunicacao'] as $cod => $registros)
            @foreach($registros as $registro)
              <tr>
                <td>{{ $cod }}</td>
                <td>{{ $registro['data_aplicacao'] }}</td>
                <td><input type="checkbox" disabled @if($registro['realizado']) checked @endif></td>
                <td>{{ $registro['observacoes'] }}</td>
                <td>{{ $registro['registro_timestamp'] }}</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <table class="result-table" style="background: #fff;">
    <thead>
      <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Atividade</th>
        <th style="width: 28%;" rowspan="2">Descrição</th>
        <th style="width: 12%;" rowspan="2">Data de aplicação</th>
        <th colspan="2" style="text-align:center;">Realizou a atividade com apoio?</th>
        <th style="width: 20%;" rowspan="2">Observações</th>
      </tr>
      <tr style="background: #ffe066;">
        <th style="width: 5%;">Sim</th>
        <th style="width: 5%;">Não</th>
      </tr>
    </thead>
    <tbody>
      @php $idx = 0; @endphp
@php
    // Monta array de códigos já preenchidos para comunicação (por código)
    $codigosPreenchidosCom = [];
    if(isset($dadosMonitoramento['comunicacao'])) {
        foreach($dadosMonitoramento['comunicacao'] as $cod => $registros) {
            foreach($registros as $registro) {
                $codigosPreenchidosCom[$cod][] = $registro['data_aplicacao'];
            }
        }
    }
@endphp
@php
    // Data de hoje no formato Y-m-d (igual ao salvo no banco)
    $hoje = date('Y-m-d');
@endphp
@php
    $contadoresCom = [];
@endphp
@php
    // Se o agrupado tiver campo de data, filtrar por hoje
    $dataHoje = date('Y-m-d');
@endphp
@foreach($comunicacao_linguagem_agrupado as $linha)
    @php
        // Normaliza código para comparação
        $codigo = strtoupper(trim($linha->cod_ati_com_lin));
        $contadoresCom[$codigo] = ($contadoresCom[$codigo] ?? 0) + 1;
        // Normaliza chaves do array de registros
        $registrosHojeNorm = [];
        foreach($comunicacaoRegistrosHoje as $k => $v) {
            $registrosHojeNorm[strtoupper(trim($k))] = $v;
        }
        $totalJaRegistrado = $registrosHojeNorm[$codigo] ?? 0;
        if ($contadoresCom[$codigo] <= $totalJaRegistrado) {
            continue;
        }
    @endphp
    @php
        // Se existir campo data_aplicacao, filtra
        $temData = isset($linha->data_aplicacao) || isset($linha->data) || isset($linha->data_inicial);
        $dataLinha = $linha->data_aplicacao ?? ($linha->data ?? ($linha->data_inicial ?? null));
        if ($temData && $dataLinha && substr($dataLinha,0,10) !== $dataHoje) {
            continue;
        }
    @endphp
    @php
        $codigo = $linha->cod_ati_com_lin;
        $contadoresCom[$codigo] = ($contadoresCom[$codigo] ?? 0) + 1;
        $totalJaRegistrado = $comunicacaoRegistrosHoje[$codigo] ?? 0;
        // Só exibe se o número de repetições do código no formulário for MAIOR que o número de registros já feitos hoje
        if ($contadoresCom[$codigo] <= $totalJaRegistrado) {
            // Já atingiu o limite de registros para hoje, então pula (NÃO mostra)
            continue;
        }
        $key = 'com_' . $codigo;
        $qtd = $norm_atividades[$key] ?? 0;
        $jaPreenchidoHoje = false;
        if (!empty($codigosPreenchidosCom[$codigo])) {
            foreach($codigosPreenchidosCom[$codigo] as $data) {
                if ($data && substr($data,0,10) == $hoje) {
                    $jaPreenchidoHoje = true;
                    break;
                }
            }
        }
    @endphp
    @if($jaPreenchidoHoje)
        @continue
    @endif
    @for($q=0; $q<$qtd; $q++)
        <tr data-eixo="comunicacao" data-idx="{{$idx}}" data-cod-atividade="{{ $linha->cod_ati_com_lin }}">
            <td>
                {{ $linha->cod_ati_com_lin }}-{{ $q + 1 }}
                <input type="hidden" name="comunicacao[{{$idx}}][cod_atividade]" value="{{ $linha->cod_ati_com_lin }}">
                <input type="hidden" name="comunicacao[{{$idx}}][flag]" value="{{ $q + 1 }}">
            </td>
            <td>{{ $linha->desc_ati_com_lin }}</td>
            <td><input type="date" name="comunicacao[{{$idx}}][data_inicial]" class="form-control" value=""></td>
            <td class="text-center">
                <input type="checkbox" name="comunicacao[{{$idx}}][sim_inicial]" value="1" class="sim-checkbox" data-eixo="comunicacao" data-idx="{{$idx}}">
            </td>
            <td class="text-center">
                <input type="checkbox" name="comunicacao[{{$idx}}][nao_inicial]" value="1" class="nao-checkbox" data-eixo="comunicacao" data-idx="{{$idx}}">
            </td>
            <td><textarea name="comunicacao[{{$idx}}][observacoes]" class="form-control"></textarea></td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-salvar-linha" data-eixo="comunicacao" data-idx="{{$idx}}">Salvar atividade</button>
            </td>
        </tr>
        @php $idx++; @endphp
    @endfor
@endforeach
    </tbody>
  </table>
</div>

    {{-- EIXO COMPORTAMENTO (PADRÃO VISUAL) --}}
<div class="comportamento-bg" style="border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div class="table-title" style="font-size:20px; color:#176ca7; text-align:center; margin-bottom:15px;">Eixo Comportamento</div>

  {{-- REGISTROS JÁ CADASTRADOS - COMPORTAMENTO --}}
  @if(isset($dadosMonitoramento['comportamento']) && count($dadosMonitoramento['comportamento']))
    <div style="margin-bottom:12px;">
      <strong>Registros já cadastrados:</strong>
      <table class="result-table" style="margin-bottom:8px;">
        <thead>
          <tr style="background:#ffd966;">
            <th>Código</th>
            <th>Data</th>
            <th>Realizado?</th>
            <th>Observações</th>
            <th>Registro Timestamp</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dadosMonitoramento['comportamento'] as $cod => $registros)
            @foreach($registros as $registro)
              <tr>
                <td>{{ $cod }}</td>
                <td>{{ $registro['data_aplicacao'] }}</td>
                <td><input type="checkbox" disabled @if($registro['realizado']) checked @endif></td>
                <td>{{ $registro['observacoes'] }}</td>
                <td>{{ $registro['registro_timestamp'] }}</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
  <table class="result-table" style="background: #fff;">
    <thead>
    <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Atividade</th>
        <th style="width: 28%;" rowspan="2">Descrição</th>
        <th style="width: 12%;" rowspan="2">Data de aplicação</th>
        <th colspan="2" style="text-align:center;">Realizou a atividade com apoio?</th>
        <th style="width: 20%;" rowspan="2">Observações</th>
      </tr>
      <tr style="background: #ffe066;">
        <th style="width: 5%;">Sim</th>
        <th style="width: 5%;">Não</th>
      </tr>
    </thead>
    <tbody>
      @php $idx = 0; @endphp
      @php
    // Monta array de códigos já preenchidos para comportamento (por código)
    $codigosPreenchidosComp = [];
    if(isset($dadosMonitoramento['comportamento'])) {
        foreach($dadosMonitoramento['comportamento'] as $cod => $registros) {
            foreach($registros as $registro) {
                $codigosPreenchidosComp[$cod][] = $registro['data_aplicacao'];
            }
        }
    }
@endphp
{{-- Removido debug comportamento --}}
@php
    $contadoresComp = [];
@endphp
@foreach($comportamento_agrupado as $linha)
    {{-- Pula a atividade ECP03 (não deve ser exibida por regra de negócio) --}}
    @if(isset($linha->cod_ati_comportamento) && $linha->cod_ati_comportamento === 'ECP03')
        @continue
    @endif
    @php
        $codigo = $linha->cod_ati_comportamento;
        $contadoresComp[$codigo] = ($contadoresComp[$codigo] ?? 0) + 1;
        $totalJaRegistrado = $comportamentoRegistrosHoje[$codigo] ?? 0;
    @endphp
    @if($contadoresComp[$codigo] <= $totalJaRegistrado)
        @continue
    @endif
           @php
               $key = 'comp_' . $linha->cod_ati_comportamento;
               $codigo = $linha->cod_ati_comportamento;
               $qtd = $norm_atividades[$key] ?? 0;
               $jaPreenchidoHoje = false;
               if (!empty($codigosPreenchidosComp[$codigo])) {
                   foreach($codigosPreenchidosComp[$codigo] as $data) {
                       if ($data && substr($data,0,10) == $hoje) {
                           $jaPreenchidoHoje = true;
                           break;
                       }
                   }
               }
           @endphp
           @if($jaPreenchidoHoje)
               @continue
           @endif
           @for($q=0; $q<$qtd; $q++)
               <tr data-eixo="comportamento" data-idx="{{$idx}}" data-cod-atividade="{{ $linha->cod_ati_comportamento }}">
                   <td>
                       {{ $linha->cod_ati_comportamento }}-{{ ($contadoresComp[$linha->cod_ati_comportamento] ?? 0) + $q + 1 }}
                       <input type="hidden" name="comportamento[{{$idx}}][cod_atividade]" value="{{ $linha->cod_ati_comportamento }}">
                       <input type="hidden" name="comportamento[{{$idx}}][flag]" value="{{ ($contadoresComp[$linha->cod_ati_comportamento] ?? 0) + $q + 1 }}">
                   </td>
                   <td>{{ $linha->desc_ati_comportamento }}</td>
                   <td><input type="date" name="comportamento[{{$idx}}][data_inicial]" class="form-control" value="" required></td>
                   <td class="text-center">
                       <input type="checkbox" name="comportamento[{{$idx}}][sim_inicial]" value="1" class="sim-checkbox" data-eixo="comportamento" data-idx="{{$idx}}">
                   </td>
                   <td class="text-center">
                       <input type="checkbox" name="comportamento[{{$idx}}][nao_inicial]" value="1" class="nao-checkbox" data-eixo="comportamento" data-idx="{{$idx}}">
                   </td>
                   <td><textarea name="comportamento[{{$idx}}][observacoes]" class="form-control"></textarea></td>
<td class="text-center">
    <button type="button" class="btn btn-success btn-salvar-linha" data-eixo="comportamento" data-idx="{{$idx}}">Salvar atividade</button>
</td>
               </tr>
               @php $idx++; @endphp
           @endfor
       @endforeach
    </tbody>
  </table>
</div>

    {{-- EIXO INTERAÇÃO SOCIOEMOCIONAL (PADRÃO VISUAL) --}}
<div class="socioemocional-bg" style="border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div class="table-title" style="font-size:20px; color:#267a3e; text-align:center; margin-bottom:15px;">Eixo Interação Socioemocional</div>

  {{-- REGISTROS JÁ CADASTRADOS - SOCIOEMOCIONAL --}}
  @if(isset($dadosMonitoramento['socioemocional']) && count($dadosMonitoramento['socioemocional']))
    <div style="margin-bottom:12px;">
      <strong>Registros já cadastrados:</strong>
      <table class="result-table" style="margin-bottom:8px;">
        <thead>
          <tr style="background:#ffd966;">
            <th>Código</th>
            <th>Data</th>
            <th>Realizado?</th>
            <th>Observações</th>
            <th>Registro Timestamp</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dadosMonitoramento['socioemocional'] as $cod => $registros)
            @foreach($registros as $registro)
              <tr>
                <td>{{ $cod }}</td>
                <td>{{ $registro['data_aplicacao'] }}</td>
                <td><input type="checkbox" disabled @if($registro['realizado']) checked @endif></td>
                <td>{{ $registro['observacoes'] }}</td>
                <td>{{ $registro['registro_timestamp'] }}</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
  <table class="result-table" style="background: #fff;">
    <thead>
      <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Atividade</th>
        <th style="width: 28%;" rowspan="2">Descrição</th>
        <th style="width: 12%;" rowspan="2">Data de aplicação</th>
        <th colspan="2" style="text-align:center;">Realizou a atividade com apoio?</th>
        <th style="width: 20%;" rowspan="2">Observações</th>
      </tr>
      <tr style="background: #ffe066;">
        <th style="width: 5%;">Sim</th>
        <th style="width: 5%;">Não</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($socioemocional_atividades_ordenadas) && count($socioemocional_atividades_ordenadas) > 0)
          @php $idx = 0; @endphp
          @php
    // Monta array de códigos já preenchidos para socioemocional (por código)
    $codigosPreenchidosSoc = [];
    if(isset($dadosMonitoramento['socioemocional'])) {
        foreach($dadosMonitoramento['socioemocional'] as $cod => $registros) {
            foreach($registros as $registro) {
                $codigosPreenchidosSoc[$cod][] = $registro['data_aplicacao'];
            }
        }
    }
@endphp
{{-- Removido debug socioemocional --}}
@php
    $contadoresSoc = [];
@endphp
@foreach($socioemocional_agrupado as $linha)
    @if(
        (isset($linha->cod_ati_int_soc) && $linha->cod_ati_int_soc === 'EIS01') ||
        (isset($linha->cod_ati_int_socio) && $linha->cod_ati_int_socio === 'EIS01') ||
        (isset($linha->fk_id_pro_int_socio) && $linha->fk_id_pro_int_socio == 1)
    )
        @continue
    @endif
    @php
        $codigo = $linha->cod_ati_int_soc ?? $linha->cod_ati_int_socio ?? null;
        if (!$codigo) continue;
        $contadoresSoc[$codigo] = ($contadoresSoc[$codigo] ?? 0) + 1;
        $totalJaRegistrado = $socioemocionalRegistrosHoje[$codigo] ?? 0;
    @endphp
    @if($contadoresSoc[$codigo] <= $totalJaRegistrado)
        @continue
    @endif
               @php
                   $cod = $linha->cod_ati_int_soc ?? $linha->cod_ati_int_socio ?? null;
                   $key = 'soc_' . $cod;
                   $qtd = $norm_atividades[$key] ?? 0;
                   $jaPreenchidoHoje = false;
                   if (!empty($codigosPreenchidosSoc[$cod])) {
                       foreach($codigosPreenchidosSoc[$cod] as $data) {
                           if ($data && substr($data,0,10) == $hoje) {
                               $jaPreenchidoHoje = true;
                               break;
                           }
                       }
                   }
               @endphp
               @if($jaPreenchidoHoje)
                   @continue
               @endif
               @for($q=0; $q<$qtd; $q++)
                   <tr data-eixo="socioemocional" data-idx="{{$idx}}" data-cod-atividade="{{ $cod }}">
                       <td>
                           {{ $cod ?? 'N/A' }}-{{ ($contadoresSoc[$cod] ?? 0) + $q + 1 }}
                           <input type="hidden" name="socioemocional[{{$idx}}][cod_atividade]" value="{{ $cod }}">
                           <input type="hidden" name="socioemocional[{{$idx}}][flag]" value="{{ ($contadoresSoc[$cod] ?? 0) + $q + 1 }}">
                       </td>
                       <td>{{ $linha->desc_ati_int_soc ?? $linha->descricao ?? 'Descrição não disponível' }}</td>
                       <td><input type="date" name="socioemocional[{{$idx}}][data_inicial]" class="form-control" value="" required></td>
                       <td class="text-center">
                           <input type="checkbox" name="socioemocional[{{$idx}}][sim_inicial]" value="1" class="sim-checkbox" data-eixo="socioemocional" data-idx="{{$idx}}">
                       </td>
                       <td class="text-center">
                           <input type="checkbox" name="socioemocional[{{$idx}}][nao_inicial]" value="1" class="nao-checkbox" data-eixo="socioemocional" data-idx="{{$idx}}">
                       </td>
                       <td><textarea name="socioemocional[{{$idx}}][observacoes]" class="form-control"></textarea></td>
<td class="text-center">
    <button type="button" class="btn btn-success btn-salvar-linha" data-eixo="socioemocional" data-idx="{{$idx}}">Salvar atividade</button>
</td>
                   </tr>
                   @php $idx++; @endphp
               @endfor
           @endforeach
      @else
          <tr>
              <td colspan="6" class="text-center">Nenhuma atividade socioemocional encontrada.</td>
          </tr>
      @endif
    </tbody>
  </table>
</div>

    <form id="monitoramentoForm" method="POST" action="{{ route('monitoramento.salvar') }}">
        @csrf
        <input type="hidden" name="aluno_id" value="{{ $alunoId ?? '' }}">
        
        <div class="observations">
            <strong>Observações Finais:</strong><br><br>
            <textarea name="observacoes_gerais" placeholder="Digite aqui quaisquer observações adicionais..."></textarea>
        </div>

        <!-- ASSINATURAS -->
        <div class="signatures">
            <div class="sign-box">
                <div class="line"></div>
                Professor(a) Responsável
            </div>
            <div class="sign-box">
                <div class="line"></div>
                Coordenação
            </div>
            <div class="sign-box">
                <div class="line"></div>
                Direção
            </div>
        </div>
        
        <!-- Mensagens de feedback -->
        <div class="row mt-3">
            <div class="col-12">
                <div id="mensagem-sucesso" class="alert alert-success d-none" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>Dados salvos com sucesso!</span>
                </div>
                <div id="mensagem-erro" class="alert alert-danger d-none" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span>Ocorreu um erro ao salvar os dados. Por favor, tente novamente.</span>
                </div>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="row mt-4 mb-5">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </button>
                <button type="button" class="pdf-button btn btn-warning">
    <i class="fas fa-file-pdf me-2"></i>Gerar PDF
</button>
            </div>
        </div>
    </form>
  </div>
</div>
-1" aria-labelledby="carregandoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-5">
        <div class="spinner-grow text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
          <span class="visually-hidden">Carregando...</span>
        </div>
        <h5 class="mt-3 fw-bold">Salvando dados do monitoramento</h5>
        <p class="text-muted">Por favor, aguarde enquanto processamos as informações...</p>
        <div class="progress mt-4" style="height: 6px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de sucesso -->
<div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="sucessoModalLabel"><i class="fas fa-check-circle me-2"></i> Sucesso!</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="d-flex justify-content-center">
          <div class="circle-success mb-4">
            <i class="fas fa-check fa-3x text-white"></i>
          </div>
        </div>
        <h4>Dados salvos com sucesso!</h4>
        <p class="text-muted">Os dados do monitoramento foram gravados corretamente no sistema.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Voltar à página anterior</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">
          <i class="fas fa-check me-2"></i>Continuar</button>
      </div>
    </div>
  </div>
</div>
@endif
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function checkJQuery() {
    if (window.jQuery) {
        initPdfGeneration();
    } else {
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
        script.onload = initPdfGeneration;
        document.head.appendChild(script);
    }
}
function initPdfGeneration() {
    $(document).on('click', '.pdf-button', function(e) {
        e.preventDefault();
        generatePdf(this);
    });
}
function generatePdf(button) {
    const originalText = $(button).text();
    $(button).prop('disabled', true).text('Gerando PDF...');
    if (typeof window.jspdf === 'undefined' || typeof html2canvas === 'undefined') {
        alert('Erro ao carregar as bibliotecas necessárias. Recarregue a página.');
        $(button).prop('disabled', false).text(originalText);
        return;
    }
    try {
        const { jsPDF } = window.jspdf;
        // Captura o container principal
        const element = document.querySelector('.monitoring-container') || document.getElementById('monitoramentoForm');
        const options = {
            scale: 1.5,
            useCORS: true,
            allowTaint: true,
            scrollY: 0,
            windowHeight: document.documentElement.offsetHeight
        };
        html2canvas(element, options).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth() - 20;
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            let heightLeft = pdfHeight;
            let position = 10;
            const pageHeight = pdf.internal.pageSize.getHeight() - 20;
            while (heightLeft > 0) {
                pdf.addImage(imgData, 'PNG', 10, position, pdfWidth, pdfHeight);
                heightLeft -= pageHeight;
                if (heightLeft > 0) {
                    pdf.addPage();
                    position = heightLeft - pdfHeight;
                }
            }
            let nomeAluno = @json($detalhe->alu_nome ?? 'Aluno');
nomeAluno = nomeAluno
    ? nomeAluno.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-zA-Z0-9]/g, '_').replace(/_+/g, '_').replace(/^_+|_+$/g, '')
    : 'Aluno';
            const hoje = new Date();
            const dataAtual = [
                String(hoje.getDate()).padStart(2, '0'),
                String(hoje.getMonth() + 1).padStart(2, '0'),
                hoje.getFullYear()
            ].join('_');
            const nomeArquivo = `${nomeAluno}_rotina_monitoramento_${dataAtual}.pdf`;
            pdf.save(nomeArquivo);
        }).catch(error => {
            alert('Ocorreu um erro ao gerar o PDF.');
        }).finally(() => {
            $(button).prop('disabled', false).text(originalText);
        });
    } catch (error) {
        alert('Erro ao processar a geração do PDF.');
        $(button).prop('disabled', false).text(originalText);
    }
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', checkJQuery);
} else {
    checkJQuery();
}
</script>
@endsection

@section('scripts')
<!-- Dados do monitoramento para preenchimento automático -->
<script>
    // Passar os dados do monitoramento para o JavaScript
    var dadosMonitoramento = @json($dadosMonitoramento ?? []);
    console.log('Dados de monitoramento recebidos:', dadosMonitoramento);
    
    // Função para carregar os dados do monitoramento quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM carregado, carregando dados do monitoramento...');
        
        // Obter o ID do aluno do campo oculto
        const alunoId = document.querySelector('input[name="aluno_id"]')?.value;
        
        if (alunoId) {
            // Carregar os dados do monitoramento via AJAX
            carregarDadosMonitoramento(alunoId)
                .then(() => {
                    console.log('Dados do monitoramento carregados com sucesso!');
                })
                .catch(error => {
                    console.error('Erro ao carregar dados do monitoramento:', error);
                });
        } else {
            console.error('ID do estudante não encontrado');
        }
    });
</script>
<script src="{{ asset('js/validacao_monitoramento.js') }}"></script>
<script>
// Função para carregar os dados salvos do monitoramento
async function carregarDadosMonitoramento(alunoId) {
    if (!alunoId) {
        console.error('ID do estudante não fornecido');
        return Promise.reject('ID do estudante não fornecido');
    }

    const loadingIndicator = document.getElementById('loading-indicator');
    const mensagemErro = document.getElementById('mensagem-erro');
    const mensagemSucesso = document.getElementById('mensagem-sucesso');

    try {
        console.log(`Carregando dados do monitoramento para o estudante ${alunoId}...`);
        
        // Mostrar indicador de carregamento
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        if (mensagemErro) mensagemErro.style.display = 'none';
        if (mensagemSucesso) mensagemSucesso.style.display = 'none';
        
        const response = await fetch(`/monitoramento/carregar/${alunoId}?_=${Date.now()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            method: 'GET',
            cache: 'no-store'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta:', response.status, response.statusText);
            console.error('Detalhes do erro:', errorText);
            throw new Error(`Erro ao carregar os dados: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();
        console.log('Resposta da API:', data);

        if (!data.success) {
            throw new Error(data.message || 'Erro ao processar os dados do servidor');
        }

        // Função auxiliar para preencher os campos de um eixo
        const preencherEixo = (eixo, dadosEixo) => {
            if (!dadosEixo || !Array.isArray(dadosEixo) || dadosEixo.length === 0) {
                console.log(`Nenhum dado para o eixo: ${eixo}`);
                return;
            }
            
            console.log(`Preenchendo ${dadosEixo.length} registros do eixo ${eixo}:`, dadosEixo);
            
            // Processar cada registro do array
            dadosEixo.forEach((dados, index) => {
                if (!dados || !dados.cod_atividade) {
                    console.log(`Dados inválidos no índice ${index}`, dados);
                    return;
                }
                
                const codAtividade = dados.cod_atividade;
                try {
                    
                    console.log(`Processando atividade ${codAtividade}:`, dados);
                    
                    // Encontrar todas as linhas com essa atividade (tenta vários seletores)
                    let linhas = document.querySelectorAll(`tr[data-eixo="${eixo}"][data-cod-atividade="${codAtividade}"]`);
                    
                    // Se não encontrou linhas pelo atributo, tenta pela classe
                    if (!linhas.length) {
                        linhas = document.querySelectorAll(`tr[data-cod-atividade="${codAtividade}"]`);
                    }
                    
                    // Se ainda não encontrou, tenta pela classe e depois filtra pelo código de atividade
                    if (!linhas.length) {
                        const todasLinhasEixo = document.querySelectorAll(`.${eixo}-linha`);
                        
                        const linhasFiltradas = Array.from(todasLinhasEixo).filter(linha => {
                            const inputCodigo = linha.querySelector(`input[name$="[cod_atividade]"]`);
                            return inputCodigo?.value === codAtividade;
                        });
                        
                        if (linhasFiltradas.length) {
                            console.log(`Encontradas ${linhasFiltradas.length} linhas para ${codAtividade} pela classe`);
                            linhas = linhasFiltradas;
                        }
                    }
                    
                    // Converter NodeList para Array para facilitar o processamento
                    linhas = Array.from(linhas);
                    
                    if (!linhas.length) {
                        console.warn(`Nenhuma linha encontrada para a atividade ${codAtividade} do eixo ${eixo}`);
                        return;
                    }
                    
                    // CORREÇÃO: Para evitar duplicação, preencher apenas a primeira linha encontrada
                    // Isso garante que cada código de atividade tenha apenas um registro visual na tela
                    const linha = linhas[0];
                    console.log(`Preenchendo apenas a primeira linha encontrada para ${codAtividade} do eixo ${eixo}`);
                    
                    // Marcar linhas que já têm dados para evitar duplicidades
                    linha.setAttribute('data-possui-dados', 'true');
                    
                    // Preenche a data de aplicação
                    const dataInput = linha.querySelector('input[type="date"]');
                    if (dataInput) {
                        const dataValor = dados.data_aplicacao || dados.data_inicial;
                        if (dataValor) {
                            // Converte a data para o formato YYYY-MM-DD se for DD/MM/YYYY
                            let dataFormatada = dataValor;
                            
                            // Verifica se a data está no formato DD/MM/YYYY
                            if (/^\d{2}\/\d{2}\/\d{4}$/.test(dataValor)) {
                                const partes = dataValor.split('/');
                                dataFormatada = `${partes[2]}-${partes[1]}-${partes[0]}`;
                            }
                            
                            dataInput.value = dataFormatada;
                            // Torna o campo não editável
                            dataInput.setAttribute('readonly', true);
                            dataInput.classList.add('campo-readonly');
                            console.log(`Data definida para ${codAtividade} e campo desabilitado:`, dataFormatada);
                        }
                    } else {
                        console.log(`Campo de data não encontrado para ${codAtividade}`);
                    }
                    
                    // Nova implementação para lidar com checkboxes
                    try {
                        // Encontrar os checkboxes Sim/Não
                        const simCheck = linha.querySelector('input[type="checkbox"][name$="[sim_inicial]"]'); 
                        const naoCheck = linha.querySelector('input[type="checkbox"][name$="[nao_inicial]"]');
                        
                        // Só prossegue se ambos os checkboxes forem encontrados
                        if (simCheck && naoCheck) {
                            // Define o estado dos checkboxes baseado nos dados
                            if (dados.sim_inicial !== undefined) {
                                simCheck.checked = (dados.sim_inicial === '1' || dados.sim_inicial === 1 || dados.sim_inicial === true);
                            }
                            
                            if (dados.nao_inicial !== undefined) {
                                naoCheck.checked = (dados.nao_inicial === '1' || dados.nao_inicial === 1 || dados.nao_inicial === true);
                            }
                            
                            // Se os valores específicos não foram definidos, tenta usar o campo 'realizado'
                            if (dados.realizado !== undefined && dados.sim_inicial === undefined && dados.nao_inicial === undefined) {
                                const valorRealizado = dados.realizado;
                                if (valorRealizado === 1 || valorRealizado === '1' || valorRealizado === true) {
                                    simCheck.checked = true;
                                    naoCheck.checked = false;
                                } else if (valorRealizado === 0 || valorRealizado === '0' || valorRealizado === false) {
                                    simCheck.checked = false;
                                    naoCheck.checked = true;
                                }
                            }
                            
                            // Dispara eventos change para ambos os checkboxes
                            simCheck.dispatchEvent(new Event('change'));
                            naoCheck.dispatchEvent(new Event('change'));
                            
                            // Torna os checkboxes readonly
                            simCheck.disabled = true;
                            naoCheck.disabled = true;
                            simCheck.classList.add('checkbox-readonly');
                            naoCheck.classList.add('checkbox-readonly');
                            
                            console.log(`Checkboxes processados e desabilitados para ${codAtividade}`);
                        } else {
                            console.log(`Checkboxes não encontrados para ${codAtividade}`);
                        }
                    } catch (checkboxError) {
                        console.error(`Erro ao processar checkboxes para ${codAtividade}:`, checkboxError);
                    }
                    
                    // Preenche as observações (tenta vários seletores)
                    const obsTextarea = linha.querySelector('textarea[name$="[observacoes]"]');
                    const obsInput = linha.querySelector('input[type="text"][name$="[observacoes]"]');
                    const obsEspecifico = document.getElementById(`observacao-${eixo}-${codAtividade}`);
                    
                    console.log(`Processando observação para ${codAtividade}:`, { valorObservacao: dados.observacoes });
                    
                    // Garantir que incluamos observações mesmo se vazias (diferente de undefined)
                    if (dados.observacoes !== undefined) {
                        let observacaoPreenchida = false;
                        
                        if (obsTextarea) {
                            obsTextarea.value = dados.observacoes;
                            // Tornar não editável
                            obsTextarea.setAttribute('readonly', true);
                            obsTextarea.classList.add('campo-readonly');
                            observacaoPreenchida = true;
                            console.log(`Observação definida (textarea) para ${codAtividade} e campo desabilitado:`, dados.observacoes);
                        }
                        
                        if (obsInput) {
                            obsInput.value = dados.observacoes;
                            // Tornar não editável
                            obsInput.setAttribute('readonly', true);
                            obsInput.classList.add('campo-readonly');
                            observacaoPreenchida = true;
                            console.log(`Observação definida (input) para ${codAtividade} e campo desabilitado:`, dados.observacoes);
                        }
                        
                        if (obsEspecifico) {
                            obsEspecifico.value = dados.observacoes;
                            // Tornar não editável
                            obsEspecifico.setAttribute('readonly', true);
                            obsEspecifico.classList.add('campo-readonly');
                            observacaoPreenchida = true;
                            console.log(`Observação definida (específico) para ${codAtividade} e campo desabilitado:`, dados.observacoes);
                        }
                        
                        if (!observacaoPreenchida) {
                            console.log(`Campo de observações não encontrado para ${codAtividade}`);
                        }
                    } else {
                        // Mesmo sem observações, vamos desabilitar os campos
                        if (obsTextarea) {
                            obsTextarea.setAttribute('readonly', true);
                            obsTextarea.classList.add('campo-readonly');
                        }
                        if (obsInput) {
                            obsInput.setAttribute('readonly', true);
                            obsInput.classList.add('campo-readonly');
                        }
                        if (obsEspecifico) {
                            obsEspecifico.setAttribute('readonly', true);
                            obsEspecifico.classList.add('campo-readonly');
                        }
                    }
                } catch (error) {
                    console.error(`Erro ao processar atividade ${codAtividade} do eixo ${eixo}:`, error);
                }
            });
        };

        // Preenche os dados de cada eixo
        if (data.data) {
            console.log('Processando dados recebidos:', data.data);
            
            // Verifica se cada eixo existe e processa
            if (Array.isArray(data.data.comunicacao)) {
                preencherEixo('comunicacao', data.data.comunicacao);
            } else {
                console.warn('Dados de comunicação não estão no formato esperado (array)');
            }
            
            if (Array.isArray(data.data.comportamento)) {
                preencherEixo('comportamento', data.data.comportamento);
            } else {
                console.warn('Dados de comportamento não estão no formato esperado (array)');
            }
            
            if (Array.isArray(data.data.socioemocional)) {
                preencherEixo('socioemocional', data.data.socioemocional);
            } else {
                console.warn('Dados de socioemocional não estão no formato esperado (array)');
            }
            
            // Exibir mensagem ao usuário que os dados estão em modo somente leitura
            document.getElementById('mensagemModoVisualizacao').style.display = 'block';
        } else {
            console.warn('Nenhum dado encontrado na resposta');
        }

        console.log('Dados carregados com sucesso!');
        
        // Mostrar mensagem de sucesso
        if (mensagemSucesso) {
            mensagemSucesso.textContent = 'Dados carregados com sucesso!';
            mensagemSucesso.style.display = 'block';
            
            // Esconder a mensagem após 5 segundos
            setTimeout(() => {
                if (mensagemSucesso) mensagemSucesso.style.display = 'none';
            }, 5000);
        }
        return true;
    } catch (error) {
        console.error('Erro ao carregar dados:', error);
        
        // Mostra mensagem de erro para o usuário
        const mensagemErro = document.getElementById('mensagem-erro');
        if (mensagemErro) {
            mensagemErro.textContent = 'Erro ao carregar os dados. ' + (error.message || '');
            mensagemErro.style.display = 'block';
            
            // Esconder a mensagem após 10 segundos
            setTimeout(() => {
                mensagemErro.style.display = 'none';
            }, 10000);
        }
        
        // Garante que o indicador de carregamento seja ocultado mesmo em caso de erro
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        
        throw error; // Rejeita a promessa para que o chamador saiba que houve um erro
    } finally {
        // Garante que o indicador de carregamento seja sempre ocultado
        if (loadingIndicator) loadingIndicator.style.display = 'none';
    }
}

// Função para formatar os dados do formulário para envio
function formatarDadosFormulario() {
    const formData = new FormData();
    let aluno_id = '';
    // 1. Tenta pegar do input hidden
    const alunoInput = document.querySelector('input[name="aluno_id"]');
    if (alunoInput && alunoInput.value) {
        aluno_id = alunoInput.value;
    } else {
        // 2. Fallback: tenta extrair o id da URL
        const match = window.location.pathname.match(/\/(?:rotina_monitoramento|rotina)\/(?:cadastrar|aluno)\/(\d+)/);
        if (match && match[1]) {
            aluno_id = match[1];
            // Atualiza o input hidden para manter consistência
            if (alunoInput) alunoInput.value = aluno_id;
        }
    }
    if (!aluno_id) {
        alert('ID do aluno não encontrado! Não é possível salvar.');
        return;
    }
    formData.append('aluno_id', aluno_id);
    
    // Função auxiliar para formatar os dados de um eixo específico
    const formatarDadosEixo = (prefixo) => {
        const dados = [];
        
        // Busca linhas tanto por atributo data-eixo quanto por classe
        let linhas = document.querySelectorAll(`tr[data-eixo="${prefixo}"]`);
        if (!linhas.length) {
            linhas = document.querySelectorAll(`.${prefixo}-linha`);
        }
        
        console.log(`Encontradas ${linhas.length} linhas para o eixo ${prefixo}`);
        
        linhas.forEach(linha => {
            // Busca o código da atividade tanto por atributo quanto por input hidden
            let codAtividade = linha.getAttribute('data-cod-atividade');
            if (!codAtividade) {
                const codInput = linha.querySelector('input[name$="[cod_atividade]"]');
                codAtividade = codInput?.value || null;
            }
            
            if (!codAtividade) {
                console.log('Linha sem código de atividade detectada, ignorando');
                return;
            }
            
            console.log(`Processando atividade ${codAtividade} do eixo ${prefixo}`);
            
            // Busca os elementos de input
            const dataAplicacao = linha.querySelector('input[type="date"]')?.value || '';
            const simInicial = linha.querySelector('input[type="checkbox"][name$="[sim_inicial]"]')?.checked || false;
            const naoInicial = linha.querySelector('input[type="checkbox"][name$="[nao_inicial]"]')?.checked || false;
            
            // Busca observações de todas as possíveis fontes
            let observacoes = '';
            // Primeiro tenta textarea
            const obsTextarea = linha.querySelector('textarea[name$="[observacoes]"]');
            if (obsTextarea && typeof obsTextarea.value !== 'undefined' && obsTextarea.value !== null) {
                observacoes = obsTextarea.value;
                console.log(`Encontrada observação no textarea para ${codAtividade}: "${observacoes}"`);
            }
            // Se não encontrou, tenta input de texto
            if (!observacoes || typeof observacoes === 'undefined' || observacoes === null) {
                const obsInput = linha.querySelector('input[type="text"][name$="[observacoes]"]');
                if (obsInput && typeof obsInput.value !== 'undefined' && obsInput.value !== null) {
                    observacoes = obsInput.value;
                    console.log(`Encontrada observação no input para ${codAtividade}: "${observacoes}"`);
                }
            }
            // Por último, tenta buscar por ID específico
            if (!observacoes || typeof observacoes === 'undefined' || observacoes === null) {
                const obsEspecifico = document.getElementById(`observacao-${prefixo}-${codAtividade}`);
                if (obsEspecifico && typeof obsEspecifico.value !== 'undefined' && obsEspecifico.value !== null) {
                    observacoes = obsEspecifico.value;
                    console.log(`Encontrada observação pelo ID específico para ${codAtividade}: "${observacoes}"`);
                }
            }
            // Fallback explícito para string vazia
            if (typeof observacoes === 'undefined' || observacoes === null) observacoes = '';
            // Log final para depuração
            console.log(`Valor final coletado de observacoes para ${codAtividade}: "${observacoes}"`);
            
            // Determina o valor de 'realizado' baseado nos checkboxes
            let realizado = null;
            if (simInicial && !naoInicial) {
                realizado = 1;
            } else if (!simInicial && naoInicial) {
                realizado = 0;
            }
            
            // Cria o item com os dados básicos
            const item = {
                cod_atividade: codAtividade,
                data_inicial: dataAplicacao || '', // Garantir que nunca seja undefined
                observacoes: observacoes // Sempre inclui observações, mesmo que vazias
            };
            
            // Adiciona o campo 'realizado' apenas se tiver valor definido
            if (realizado !== null) {
                item.realizado = realizado;
            }
            
            console.log(`Dados formatados para ${codAtividade}:`, item);
            
            // NOVA VALIDAÇÃO: só valida linhas "preenchidas"
            const dataPreenchida = dataAplicacao && dataAplicacao.trim() !== '';
            const algumCheckboxMarcado = simInicial || naoInicial;
            const doisCheckboxMarcados = simInicial && naoInicial;

            // Só valida se pelo menos um campo foi preenchido (data OU algum checkbox)
            if (dataPreenchida || algumCheckboxMarcado) {
                if (dataPreenchida && algumCheckboxMarcado && !doisCheckboxMarcados) {
                    dados.push(item);
                    console.log(`Item VÁLIDO adicionado para ${codAtividade}`);
                } else {
                    window._erroValidacaoMonitoramento = true;
                    window._msgErroMonitoramento = 'Preencha a data de aplicação E marque apenas Sim OU Não para cada linha preenchida.';
                    console.warn(`Linha INVÁLIDA para ${codAtividade}: data ou checkbox faltando ou ambos checkboxes marcados.`);
                }
            } else {
                // Ambos vazios, ignora (não bloqueia submit)
                console.log(`Item ignorado para ${codAtividade} - ambos campos vazios`);
            }
        });
        
        return dados;
    };
    
    // Coletar dados de cada eixo
    const dadosComunicacao = formatarDadosEixo('comunicacao');
    const dadosComportamento = formatarDadosEixo('comportamento');
    const dadosSocioemocional = formatarDadosEixo('socioemocional');
    
    // Adiciona os dados ao formData como JSON
    formData.append('comunicacao', JSON.stringify(dadosComunicacao));
    formData.append('comportamento', JSON.stringify(dadosComportamento));
    formData.append('socioemocional', JSON.stringify(dadosSocioemocional));
    
    console.log('Dados formatados para envio:', {
        comunicacao: dadosComunicacao,
        comportamento: dadosComportamento,
        socioemocional: dadosSocioemocional
    });
    
    // Remover itens vazios dos arrays
    const comunicacaoFiltrado = dadosComunicacao.filter(item => item && item.cod_atividade);
    const comportamentoFiltrado = dadosComportamento.filter(item => item && item.cod_atividade);
    const socioemocionalFiltrado = dadosSocioemocional.filter(item => item && item.cod_atividade);
    
    // Atualizar os dados no formData com os arrays filtrados
    formData.set('comunicacao', JSON.stringify(comunicacaoFiltrado));
    formData.set('comportamento', JSON.stringify(comportamentoFiltrado));
    formData.set('socioemocional', JSON.stringify(socioemocionalFiltrado));
    
    return formData;
}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para garantir que checkboxes de apoio (Sim/Não) sejam mutuamente exclusivos
    function aplicarExclusividadeCheckboxes() {
        document.querySelectorAll('.sim-checkbox, .nao-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) return;
                const eixo = this.dataset.eixo;
                const idx = this.dataset.idx;
                const isSim = this.classList.contains('sim-checkbox');
                const outroCheckbox = document.querySelector(
                    `.${isSim ? 'nao-checkbox' : 'sim-checkbox'}[data-eixo="${eixo}"][data-idx="${idx}"]`
                );
                if (outroCheckbox) {
                    outroCheckbox.checked = false;
                }
                // Garante que nunca ambos fiquem marcados
                setTimeout(() => {
                    if (isSim && outroCheckbox && outroCheckbox.checked) outroCheckbox.checked = false;
                    if (!isSim && outroCheckbox && outroCheckbox.checked) outroCheckbox.checked = false;
                }, 10);
            });
        });
    }

    // Validação minimalista antes do envio
    function validarLinhasMonitoramento() {
        let erro = false;
        let msg = '';
        document.querySelectorAll('tr[data-eixo]').forEach(linha => {
            const data = linha.querySelector('input[type="date"]')?.value?.trim();
            const sim = linha.querySelector('input[type="checkbox"][name$="[sim_inicial]"]')?.checked;
            const nao = linha.querySelector('input[type="checkbox"][name$="[nao_inicial]"]')?.checked;

            // Ignora linhas totalmente vazias
            if (!data && !sim && !nao) return;

            // Não pode marcar os dois
            if (sim && nao) {
                erro = true;
                msg = 'Marque apenas SIM ou NÃO (nunca os dois) nas linhas preenchidas.';
            }

            // Se preencheu só um dos campos (data ou checkbox), erro
            if ((data && !(sim || nao)) || (!data && (sim || nao))) {
                erro = true;
                msg = 'Preencha a data E marque SIM ou NÃO nas linhas preenchidas.';
            }
        });
        if (erro) {
            const erroDiv = document.getElementById('erro-validacao-monitoramento');
            if(erroDiv) {
                erroDiv.textContent = msg || 'Há erro(s) nas linhas preenchidas.';
                erroDiv.style.display = 'block';
            } else {
                alert(msg || 'Há erro(s) nas linhas preenchidas.');
            }
        }
        return !erro;
    }

    const form = document.getElementById('monitoramentoForm');
    if(form) {
        form.addEventListener('submit', function(e) {
            const erroDiv = document.getElementById('erro-validacao-monitoramento');
            if(erroDiv) erroDiv.style.display = 'none';
            if(!validarLinhasMonitoramento()) {
                e.preventDefault();
                return false;
            }

            // --- AJAX SUBMIT COM ALERTA DE DUPLICIDADE ---
            e.preventDefault();
            const btnSalvar = form.querySelector('button[type="submit"], .btn-salvar-monitoramento');
            if (btnSalvar) {
                btnSalvar.disabled = true;
                btnSalvar.classList.remove('btn-danger', 'btn-success');
                btnSalvar.classList.add('btn-primary');
                btnSalvar.textContent = 'Salvando...';
            }
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(async response => {
                const btnSalvar = form.querySelector('button[type="submit"], .btn-salvar-monitoramento');
                if (response.status === 409) {
                    // Duplicidade detectada
                    const data = await response.json();
                    const msg = data.message || 'Já existe um registro igual para este aluno, atividade, flag e fase. Nenhum dado foi salvo.';
                    const modalMsg = document.getElementById('modalDuplicidadeMsg');
                    if (modalMsg) modalMsg.textContent = msg;
                    const modal = new bootstrap.Modal(document.getElementById('modalDuplicidadeMonitoramento'));
                    modal.show();
                    // Feedback visual no botão
                    if (btnSalvar) {
                        btnSalvar.classList.remove('btn-primary', 'btn-success');
                        btnSalvar.classList.add('btn-danger');
                        btnSalvar.disabled = false;
                        btnSalvar.textContent = 'Já cadastrado!';
                    }
                    // Permitir novo envio ao editar campos
                    form.querySelectorAll('input, textarea, select').forEach(el => {
                        el.addEventListener('input', function handler() {
                            if (btnSalvar) {
                                btnSalvar.classList.remove('btn-danger', 'btn-success');
                                btnSalvar.classList.add('btn-primary');
                                btnSalvar.disabled = false;
                                btnSalvar.textContent = 'Salvar';
                            }
                            el.removeEventListener('input', handler);
                        });
                    });
                    return;
                }
                if (!response.ok) {
                    alert('Erro ao salvar monitoramento. Tente novamente.');
                    return;
                }
                // Sucesso
                if (btnSalvar) {
                    btnSalvar.classList.remove('btn-primary', 'btn-danger');
                    btnSalvar.classList.add('btn-success');
                    btnSalvar.disabled = true;
                    btnSalvar.textContent = 'Salvo com sucesso!';
                }
                const data = await response.json();
                setTimeout(() => { window.location.reload(); }, 1200);
            })
            .catch(() => {
                alert('Erro inesperado ao salvar monitoramento.');
            });
        });
    }

    const alunoId = document.querySelector('input[name="aluno_id"]')?.value;
    if (alunoId && typeof carregarDadosMonitoramento === 'function') {
        carregarDadosMonitoramento(alunoId).then(() => {
            aplicarExclusividadeCheckboxes();
        });
    }
});
</script>
@include('rotina_monitoramento.partials.teste_include')

<!-- Modal de erro de duplicidade -->
<div class="modal fade" id="modalDuplicidadeMonitoramento" tabindex="-1" aria-labelledby="modalDuplicidadeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning-subtle">
        <h5 class="modal-title text-warning" id="modalDuplicidadeLabel">Cadastro já existe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="modalDuplicidadeMsg">
        Já existe um registro igual para este aluno, atividade, flag e fase. Nenhum dado foi salvo.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS (caso não esteja incluso) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection