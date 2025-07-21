{{-- Partial isolado do eixo Comportamento --}}
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
      {{-- Aqui deve ser inserido o loop das atividades de comportamento, igual ao bloco original --}}
      @php $idx = 0; @endphp
      @foreach($comportamento_agrupado as $linha)
        @php
            $codigo = $linha->cod_ati_comportamento;
            $qtd = $linha->total ?? 0;
        @endphp
        @for($q=0; $q<$qtd; $q++)
          <tr data-eixo="comportamento" data-idx="{{$idx}}" data-cod-atividade="{{ $linha->cod_ati_comportamento }}">
            <td>
              {{ $linha->cod_ati_comportamento }}-{{ $q + 1 }}
              <input type="hidden" name="comportamento[{{$idx}}][cod_atividade]" value="{{ $linha->cod_ati_comportamento }}">
              <input type="hidden" name="comportamento[{{$idx}}][flag]" value="{{ $q + 1 }}">
            </td>
            <td>{{ $linha->desc_ati_comportamento }}</td>
            <td><input type="date" name="comportamento[{{$idx}}][data_inicial]" class="form-control" value=""></td>
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
