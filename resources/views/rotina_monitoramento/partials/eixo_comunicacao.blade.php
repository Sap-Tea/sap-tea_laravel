{{-- Partial isolado do eixo Comunicação/Linguagem --}}
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

  {{-- BLOCO DE LIBERAÇÃO DE FASES, TABELA DE ATIVIDADES, ETC --}}
  {{-- Aqui você pode incluir mais blocos do eixo Comunicação/Linguagem, conforme for modularizando --}}
</div>
