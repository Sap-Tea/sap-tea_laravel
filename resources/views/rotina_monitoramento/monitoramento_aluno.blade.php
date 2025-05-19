<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="{{ asset('css/style_form.css') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rotina e Monitoramento - Atividades</title>
  <style>
    /* RESET BÁSICO */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }
    .container {
      background: #fff;
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

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
      margin-bottom: 20px;
      font-size: 14px;
      line-height: 1.5;
    }

    .button-group {
    display: flex;
    gap: 10px; /* Espaçamento entre os botões */
    justify-content: center; /* Centraliza os botões */
    margin-top: 20px;
}

.btn {
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #a71d2a;
}

.pdf-button {
    background-color: #28a745;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

.pdf-button:hover {
    background-color: #1e7e34;
}

    /* TABELA DE ATIVIDADES */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table thead {
      background: #e9e9e9;
    }
    table th,
    table td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
      font-size: 14px;
    }
    table th {
      font-weight: bold;
      color: #333;
    }
    .table-title {
      font-weight: bold;
      margin-bottom: 5px;
      color: #333;
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
  </style>
</head>
<body>
    @php
  // Debug: Mostra todas as variáveis disponíveis na view (remover em produção)
  // dd(get_defined_vars());
@endphp

@if(!isset($comunicacao_resultados))
  <div style="color:red;font-weight:bold;">Variável <code>$comunicacao_resultados</code> não está definida nesta view!</div>
@endif

@if(!isset($alunoDetalhado) || empty($alunoDetalhado))
        <div style="background: #ffdddd; color: #a00; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <strong>Erro:</strong> Não foi possível carregar os dados do aluno. Por favor, acesse o formulário pela rota correta ou verifique se o aluno existe.
        </div>
    @else
        @php
            $detalhe = is_array($alunoDetalhado) ? (object)($alunoDetalhado[0] ?? []) : $alunoDetalhado;
        @endphp
  <div class="container">
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
      <span class="period">
        <strong>Período de Aplicação (Final):</strong>
        <input type="text" name="periodo_final" value="{{ $data_inicial_com_lin ? \Carbon\Carbon::parse($data_inicial_com_lin)->addDays(60)->format('d/m/Y') : '' }}" readonly />
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
      Após finalizar o processo, você deverá registrar no Suporte TEG Digital o cenário atual do aluno.</p>
      <p><em>Observação: Em caso de dúvidas, consulte o suporte técnico ou administrativo para orientação.</em></p>
    </div>

    <!-- TABELA DE ATIVIDADES -->
    {{-- EIXO COMUNICAÇÃO/LINGUAGEM (DINÂMICO) --}}
    <div style="background: #FFF182; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#b28600;">Eixo Comunicação/Linguagem</div>
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Descrição</th>
            <th>Data (Inicial)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Data (Final)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Observações</th>
          </tr>
        </thead>
        <tbody>
          @foreach(collect($comunicacao_resultados)->sortBy(fn($r) => optional($comunicacao_propostas[$r->fk_hab_pro_com_lin] ?? null)->cod_pro_com_lin) as $i => $resultado)
    @php
        $proposta = $comunicacao_propostas[$resultado->fk_hab_pro_com_lin] ?? null;
    @endphp
    @if($proposta)
        <tr>
            <td>{{ $proposta->cod_pro_com_lin }}</td>
            <td>{{ $proposta->desc_pro_com_lin }}</td>
              <td><input type="date" name="linguagem[{{$i}}][data_inicial]" value=""></td>
              <td><input type="checkbox" name="linguagem[{{$i}}][sim_inicial]" value="1"></td>
              <td><input type="checkbox" name="linguagem[{{$i}}][nao_inicial]" value="1"></td>
              <td><input type="date" name="linguagem[{{$i}}][data_final]" value=""></td>
              <td><input type="checkbox" name="linguagem[{{$i}}][sim_final]" value="1"></td>
              <td><input type="checkbox" name="linguagem[{{$i}}][nao_final]" value="1"></td>
              <td><input type="text" name="linguagem[{{$i}}][observacoes]" value=""></td>
            </tr>
    @endif
@endforeach
        </tbody>
      </table>
    </div>

    {{-- EIXO COMPORTAMENTO (DINÂMICO) --}}
    <div style="background: #A1D9F6; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#176ca7;">Eixo Comportamento</div>
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Descrição</th>
            <th>Data (Inicial)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Data (Final)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Observações</th>
          </tr>
        </thead>
        <tbody>
          @foreach(collect($comportamento_resultados)->sortBy(fn($r) => optional($comportamento_propostas[$r->fk_hab_pro_comportamento] ?? null)->cod_pro_comportamento) as $i => $resultado)
    @php
        $proposta = $comportamento_propostas[$resultado->fk_hab_pro_comportamento] ?? null;
    @endphp
    @if($proposta)
        <tr>
            <td>{{ $proposta->cod_pro_comportamento }}</td>
            <td>{{ $proposta->desc_pro_comportamento }}</td>
              <td><input type="date" name="comportamento[{{$i}}][data_inicial]" value=""></td>
              <td><input type="checkbox" name="comportamento[{{$i}}][sim_inicial]" value="1"></td>
              <td><input type="checkbox" name="comportamento[{{$i}}][nao_inicial]" value="1"></td>
              <td><input type="date" name="comportamento[{{$i}}][data_final]" value=""></td>
              <td><input type="checkbox" name="comportamento[{{$i}}][sim_final]" value="1"></td>
              <td><input type="checkbox" name="comportamento[{{$i}}][nao_final]" value="1"></td>
              <td><input type="text" name="comportamento[{{$i}}][observacoes]" value=""></td>
            </tr>
    @endif
@endforeach
        </tbody>
      </table>
    </div>

    {{-- EIXO INTERAÇÃO SOCIOEMOCIONAL (DINÂMICO) --}}
    <div style="background: #D7EAD9; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#267a3e;">Eixo Interação Socioemocional</div>
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Descrição</th>
            <th>Data (Inicial)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Data (Final)</th>
            <th>Sim</th>
            <th>Não</th>
            <th>Observações</th>
          </tr>
        </thead>
        <tbody>
          @foreach(collect($socioemocional_resultados)->sortBy(fn($r) => optional($socioemocional_propostas[$r->fk_hab_pro_int_socio] ?? null)->cod_pro_int_soc) as $i => $resultado)
    @php
        $proposta = $socioemocional_propostas[$resultado->fk_hab_pro_int_socio] ?? null;
    @endphp
    @if($proposta)
        <tr>
            <td>{{ $proposta->cod_pro_int_soc }}</td>
            <td>{{ $proposta->desc_pro_int_soc }}</td>
              <td><input type="date" name="emocional[{{$i}}][data_inicial]" value=""></td>
              <td><input type="checkbox" name="emocional[{{$i}}][sim_inicial]" value="1"></td>
              <td><input type="checkbox" name="emocional[{{$i}}][nao_inicial]" value="1"></td>
              <td><input type="date" name="emocional[{{$i}}][data_final]" value=""></td>
              <td><input type="checkbox" name="emocional[{{$i}}][sim_final]" value="1"></td>
              <td><input type="checkbox" name="emocional[{{$i}}][nao_final]" value="1"></td>
              <td><input type="text" name="emocional[{{$i}}][observacoes]" value=""></td>
            </tr>
    @endif
@endforeach
        </tbody>
      </table>
    </div>


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
        
        <a href="{{ route('index') }}" class="btn btn-primary">Salvar</a>
    <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        <button type="button" class="pdf-button">Gerar PDF</button>
    </div>
  </div>
@endif

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


<script>
      document.querySelector(".pdf-button").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;

    // Seleciona a parte da página que será capturada
    const element = document.body;

    // Usa html2canvas para converter a página em imagem
    html2canvas(element, { scale: 1.0 }).then(canvas => { // Reduzindo a escala para diminuir o tamanho
        const imgData = canvas.toDataURL("image/jpeg", 0.8); // Compressão JPEG (0.6 de qualidade)

        const pdf = new jsPDF("p", "mm", "a4"); // Cria um documento PDF

        // Ajusta a imagem no PDF
        const imgWidth = 210; // Largura A4 em mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // Mantém proporção

        pdf.addImage(imgData, "JPEG", 0, 0, imgWidth, imgHeight);
        pdf.save("Rotina_Monitoramento.pdf"); // Baixa o PDF
    });
});
</script>
</body>
</html>