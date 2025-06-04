@extends('index')

@section('title', 'Monitoramento do Aluno')

@section('styles')
<style>
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
@endsection

@section('content')
@php
    // Debug: Verificar se as variáveis estão definidas
    \Log::info('Totais no controller:', [
        'total_atividades' => $total_atividades ?? 'não definido',
        'total_comunicacao' => $total_comunicacao_linguagem ?? 'não definido',
        'total_comportamento' => $total_comportamento ?? 'não definido',
        'total_socioemocional' => $total_socioemocional ?? 'não definido'
    ]);
    
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
    $total_dividido = round($total_atividades / 40, 2);
@endphp

{{-- DEBUG --}}
<pre style="background: #f8f8f8; color: #333; border: 1px solid #ccc; padding: 10px;">
DEBUG:
total_atividades: {{ var_export($total_atividades, true) }}
total_dividido: {{ var_export($total_dividido, true) }}
total_comunicacao_linguagem: {{ var_export($total_comunicacao_linguagem ?? null, true) }}
total_comportamento: {{ var_export($total_comportamento ?? null, true) }}
total_socioemocional: {{ var_export($total_socioemocional ?? null, true) }}
</pre>

{{-- Total de Atividades --}}
<div class="alert alert-info" style="font-size:18px; font-weight:bold; margin-bottom:20px;">
    Total de atividades em todos os eixos: $total_atividades
@if(!isset($alunoDetalhado) || empty($alunoDetalhado))
    <div style="background: #ffdddd; color: #a00; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
        <strong>Erro:</strong> Não foi possível carregar os dados do aluno. Por favor, acesse o formulário pela rota correta ou verifique se o aluno existe.
    </div>
@else
    <div class="monitoring-container">
        @php
            $detalhe = is_array($alunoDetalhado) ? (object)($alunoDetalhado[0] ?? []) : $alunoDetalhado;
        @endphp
        <div class="monitoring-container">
        <!-- CABEÇALHO -->
        <div class="header">
          <img src="{{ asset('img/LOGOTEA.png') }}" alt="Logo Educação" />
          <div class="title">
            ROTINA E MONITORAMENTO DE <br>
            APLICAÇÃO DE ATIVIDADES 1 - INICIAL
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
        Nome do Aluno:
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
        Modalidade:
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
        <strong>Período de Aplicação (Inicial):</strong>
        <input type="text" name="periodo_inicial" value="{{ $data_inicial_com_lin ? \Carbon\Carbon::parse($data_inicial_com_lin)->format('d/m/Y') : '' }}" readonly />
      </span>

    </div>

    @if($data_inicial_com_lin)
      <div style="color: #b30000; font-weight: bold; margin-bottom: 10px; font-size: 16px;">
        Já se passaram {{ \Carbon\Carbon::parse($data_inicial_com_lin)->diffInDays(\Carbon\Carbon::now()) }} dias desde o início do prazo.
      </div>
    @endif

    <!-- INSTRUÇÕES -->
    <div class="instructions">
      <p><strong>Caro educador,</strong></p>
      <p>Por favor, registre as atividades nas datas mencionadas e realize a devida anotação no quadro.  
      Se necessário, utilize este espaço para marcar a aplicação e observações pertinentes.  
      Após finalizar o processo, você deverá registrar no Suporte TEA Digital o cenário atual do aluno.</p>
      <p><em>Observação: Em caso de dúvidas, consulte o suporte técnico ou administrativo para orientação.</em></p>
    </div>

    <!-- TABELA DE ATIVIDADES -->
    {{-- EIXO COMUNICAÇÃO/LINGUAGEM (PADRÃO VISUAL) --}}
<div style="background: #FFF182; border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div class="table-title" style="font-size:20px; color:#b28600; text-align:center; margin-bottom:15px;">Eixo Comunicação/Linguagem</div>
  <table class="result-table" style="background: #fff;">
    <thead>
      <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Código</th>
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
@foreach($comunicacao_linguagem_agrupado as $linha)
    @for($q=0; $q<$linha->total; $q++)
      <tr>
        <td>{{ $linha->cod_ati_com_lin }}</td>
        <td>{{ $linha->desc_ati_com_lin }}</td>
        <td><input type="date" name="linguagem[{{$idx}}][data_inicial]" style="width:100%"></td>
        <td><input type="checkbox" name="linguagem[{{$idx}}][sim_inicial]" value="1"></td>
        <td><input type="checkbox" name="linguagem[{{$idx}}][nao_inicial]" value="1"></td>
        <td><input type="text" name="linguagem[{{$idx}}][observacoes]" style="width:100%"></td>
      </tr>
    @php $idx++; @endphp
    @endfor
@endforeach
    </tbody>
  </table>
</div>

{{-- RESUMO - COMUNICAÇÃO/LINGUAGEM (AGRUPADO) --}}
@php
    if (!isset($comunicacao_linguagem_agrupado)) $comunicacao_linguagem_agrupado = [];
@endphp
<div class="table-responsive mt-4">
  <h4>Resumo - Comunicação/Linguagem (Agrupado)</h4>
  <table class="table table-bordered" style="background: white;">
    <thead>
      <tr style="background: #f8f9fa;">
        <th>Código</th>
        <th>Descrição</th>
        <th>Aluno</th>
        <th>Fase</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($comunicacao_linguagem_agrupado as $linha)
      <tr>
        <td>{{ $linha->cod_ati_com_lin }}</td>
        <td>{{ $linha->desc_ati_com_lin }}</td>
        <td>{{ $linha->fk_result_alu_id_ecomling }}</td>
        <td>{{ $linha->tipo_fase_com_lin }}</td>
        <td>{{ $linha->total }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

    {{-- EIXO COMPORTAMENTO (PADRÃO VISUAL) --}}
<div style="background: #A1D9F6; border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div class="table-title" style="font-size:20px; color:#176ca7; text-align:center; margin-bottom:15px;">Eixo Comportamento</div>
  <table class="result-table" style="background: #fff;">
    <thead>
    <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Código</th>
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
@foreach($comportamento_atividades_ordenadas as $linha)
  {{-- Pula a atividade ECP03 (não deve ser exibida por regra de negócio) --}}
  @if(isset($linha->cod_ati_comportamento) && $linha->cod_ati_comportamento === 'ECP03')
    @continue
  @endif
  <tr>
    <td>{{ $linha->cod_ati_comportamento }}</td>
    <td>{{ $linha->desc_ati_comportamento }}</td>
    <td><input type="date" name="comportamento[{{$idx}}][data_inicial]" style="width:100%"></td>
    <td><input type="checkbox" name="comportamento[{{$idx}}][sim_inicial]" value="1"></td>
    <td><input type="checkbox" name="comportamento[{{$idx}}][nao_inicial]" value="1"></td>
    <td><input type="text" name="comportamento[{{$idx}}][observacoes]" style="width:100%"></td>
  </tr>
  @php $idx++; @endphp
@endforeach
    </tbody>
  </table>
</div>

{{-- RESUMO - COMPORTAMENTO (AGRUPADO) --}}
@php
    if (!isset($comportamento_agrupado)) $comportamento_agrupado = [];
@endphp
<div class="table-responsive mt-4">
  <h4>Resumo - Comportamento (Agrupado)</h4>
  <table class="table table-bordered" style="background: white;">
    <thead>
      <tr style="background: #f8f9fa;">
        <th>Código</th>
        <th>Descrição</th>
        <th>Aluno</th>
        <th>Fase</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($comportamento_agrupado as $linha)
      {{-- Pula a atividade ECP03 (não deve ser exibida por regra de negócio) --}}
      @if(isset($linha->cod_ati_comportamento) && $linha->cod_ati_comportamento === 'ECP03')
        @continue
      @endif
      <tr>
        <td>{{ $linha->cod_ati_comportamento }}</td>
        <td>{{ $linha->desc_ati_comportamento }}</td>
        <td>{{ $linha->fk_result_alu_id_comportamento }}</td>
        <td>{{ $linha->tipo_fase_comportamento }}</td>
        <td>{{ $linha->total }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

    {{-- EIXO INTERAÇÃO SOCIOEMOCIONAL (PADRÃO VISUAL) --}}
<div style="background: #D7EAD9; border-radius: 8px; padding: 18px; margin-bottom: 24px; box-shadow: 0 2px 8px #0001;">
  <div class="table-title" style="font-size:20px; color:#267a3e; text-align:center; margin-bottom:15px;">Eixo Interação Socioemocional</div>
  <table class="result-table" style="background: #fff;">
    <thead>
      <tr style="background: #ffe066;">
        <th style="width: 8%;" rowspan="2">Código</th>
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
        @foreach($socioemocional_atividades_ordenadas as $linha)
          @if((isset($linha->cod_ati_int_soc) && ($linha->cod_ati_int_soc === 'EIS01' || $linha->cod_ati_int_soc == 'EIS01')) || (isset($linha->cod_ati_int_socio) && ($linha->cod_ati_int_socio === 'EIS01' || $linha->cod_ati_int_socio == 'EIS01')))
            @continue
          @endif
          <tr>
            <td>{{ $linha->cod_ati_int_soc ?? 'N/A' }}</td>
            <td>{{ $linha->desc_ati_int_soc ?? $linha->descricao ?? 'Descrição não disponível' }}</td>
            <td><input type="date" name="socioemocional[{{$idx}}][data_inicial]" style="width:100%"></td>
            <td><input type="checkbox" name="socioemocional[{{$idx}}][sim_inicial]" value="1"></td>
            <td><input type="checkbox" name="socioemocional[{{$idx}}][nao_inicial]" value="1"></td>
            <td><input type="text" name="socioemocional[{{$idx}}][observacoes]" style="width:100%"></td>
          </tr>
          @php $idx++; @endphp
        @endforeach
      @else
        <tr>
          <td colspan="6" style="text-align: center;">Nenhuma atividade socioemocional encontrada.</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>

{{-- RESUMO - INTERAÇÃO SOCIOEMOCIONAL (AGRUPADO) --}}
@if(isset($socioemocional_agrupado) && count($socioemocional_agrupado) > 0)
<div class="table-responsive mt-4">
  <h4>Resumo - Interação Socioemocional (Agrupado)</h4>
  <table class="table table-bordered" style="background: white;">
    <thead>
      <tr style="background: #f8f9fa;">
        <th>Código</th>
        <th>Descrição</th>
        <th>Aluno</th>
        <th>Fase</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($socioemocional_agrupado as $linha)
        @if(
          (isset($linha->cod_ati_int_soc) && $linha->cod_ati_int_soc === 'EIS01') ||
          (isset($linha->cod_ati_int_socio) && $linha->cod_ati_int_socio === 'EIS01') ||
          (isset($linha->fk_id_pro_int_socio) && $linha->fk_id_pro_int_socio == 1)
        )
          @continue
        @endif
        <tr>
          <td>{{ $linha->cod_ati_int_soc ?? 'N/A' }}</td>
          <td>{{ $linha->desc_ati_int_soc ?? $linha->descricao ?? 'Descrição não disponível' }}</td>
          <td>{{ $linha->fk_result_alu_id_int_socio ?? 'N/A' }}</td>
          <td>{{ $linha->tipo_fase_int_socio ?? 'N/A' }}</td>
          <td>{{ $linha->total ?? '0' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

    <!-- OBSERVAÇÕES FINAIS -->
    <div class="observations">
      <strong>Observações Finais:</strong><br><br>
      <textarea placeholder="Digite aqui quaisquer observações adicionais..."></textarea>
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
    <div class="button-group">
        <button type="button" class="pdf-button btn btn-primary">Gerar PDF</button>

        
        <a href="{{ route('index') }}" class="btn btn-primary">Salvar</a>
    <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        
    </div>
  </div>
</div>
@endif
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    let y = 15;
    // ... código do PDF ...
});
</script>
@endsection