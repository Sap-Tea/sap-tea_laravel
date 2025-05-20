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
    .result-table th:nth-child(9), .result-table td:nth-child(9) {
      min-width: 120px;
      max-width: 220px;
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
    {{-- ATIVIDADES DO EIXO COMUNICAÇÃO/LINGUAGEM --}}
    <div style="background: #FFF182; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#b28600;">Atividades do Eixo Comunicação/Linguagem</div>
      <table class="result-table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        @forelse($comunicacao_atividades as $atividade)
    <tr>
        <td>{{ $atividade->cod_ati_com_lin }}</td>
        <td>{{ $atividade->desc_ati_com_lin }}</td>
    </tr>
@empty
    <tr><td colspan="2">Nenhuma atividade encontrada para este aluno.</td></tr>
@endforelse
    </tbody>
</table>
    </div>

    {{-- EIXO COMUNICAÇÃO/LINGUAGEM (DINÂMICO) --}}
    <div style="background: #FFF182; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#b28600;">Eixo Comunicação/Linguagem (Resultados)</div>
      <table class="result-table">
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
@foreach($comunicacao_resultados as $i => $resultado)
    <tr>
        <td>{{ optional($resultado->proposta)->cod_pro_com_lin ?? '-' }}</td>
        <td>{{ optional($resultado->proposta)->desc_pro_com_lin ?? '-' }}</td>
        <td><input type="date" name="linguagem[{{$i}}][data_inicial]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="linguagem[{{$i}}][sim_inicial]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="linguagem[{{$i}}][nao_inicial]" value="1"></td>
        <td><input type="date" name="linguagem[{{$i}}][data_final]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="linguagem[{{$i}}][sim_final]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="linguagem[{{$i}}][nao_final]" value="1"></td>
        <td><input type="text" name="linguagem[{{$i}}][observacoes]" value=""></td>
    </tr>
@endforeach
</tbody>
      </table>
      
    </div>

    {{-- ATIVIDADES DO EIXO COMPORTAMENTO --}}
    <div style="background: #A1D9F6; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#176ca7;">Atividades do Eixo Comportamento</div>
      <table class="result-table">
        <thead>
          <tr>
            <th>Código</th>
            <th>Descrição</th>
          </tr>
        </thead>
        <tbody>
          @forelse($comportamento_atividades as $atividade)
          <tr>
            <td>{{ $atividade->cod_ati_comportamento }}</td>
            <td>{{ $atividade->desc_ati_comportamento }}</td>
          </tr>
@empty
          <tr><td colspan="2">Nenhuma atividade encontrada para este aluno.</td></tr>
@endforelse
        </tbody>
      </table>
      <!-- Links de paginação do eixo Comportamento -->
      <div style="margin-top: 10px;">
    {{ $comportamento_resultados->withPath(route('rotina.monitoramento.cadastrar', ['id' => $detalhe->alu_id]))->links() }}
</div>
      <!-- Fim da paginação -->
    </div>

    {{-- EIXO COMPORTAMENTO (DINÂMICO) --}}
    <div style="background: #A1D9F6; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#176ca7;">Eixo Comportamento</div>
      <table class="result-table">
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
@foreach($comportamento_resultados as $i => $resultado)
    <tr>
        <td>{{ optional($resultado->proposta)->cod_pro_comportamento ?? '-' }}</td>
        <td>{{ optional($resultado->proposta)->desc_pro_comportamento ?? '-' }}</td>
        <td><input type="date" name="comportamento[{{$i}}][data_inicial]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="comportamento[{{$i}}][sim_inicial]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="comportamento[{{$i}}][nao_inicial]" value="1"></td>
        <td><input type="date" name="comportamento[{{$i}}][data_final]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="comportamento[{{$i}}][sim_final]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="comportamento[{{$i}}][nao_final]" value="1"></td>
        <td><input type="text" name="comportamento[{{$i}}][observacoes]" value=""></td>
    </tr>
@endforeach
</tbody>
      </table>
      
    </div>

    {{-- ATIVIDADES DO EIXO INTERAÇÃO SOCIOEMOCIONAL --}}
    <div style="background: #D7EAD9; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#267a3e;">Atividades do Eixo Interação Socioemocional</div>
      <table class="result-table">
        <thead>
          <tr>
            <th>Código</th>
            <th>Descrição</th>
          </tr>
        </thead>
        <tbody>
          @forelse($socioemocional_atividades as $atividade)
    <tr>
        <td>{{ $atividade->cod_ati_int_soc }}</td>
        <td>{{ $atividade->desc_ati_int_soc }}</td>
    </tr>
@empty
    <tr><td colspan="2">Nenhuma atividade encontrada para este aluno.</td></tr>
@endforelse
        </tbody>
      </table>
    </div>

    {{-- EIXO INTERAÇÃO SOCIOEMOCIONAL (DINÂMICO) --}}
    <div style="background: #D7EAD9; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
      <div class="table-title" style="font-size:18px; color:#267a3e;">Eixo Interação Socioemocional</div>
      <table class="result-table">
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
@foreach($socioemocional_resultados as $i => $resultado)
    <tr>
        <td>{{ optional($resultado->proposta)->cod_pro_int_soc ?? '-' }}</td>
        <td>{{ optional($resultado->proposta)->desc_pro_int_soc ?? '-' }}</td>
        <td><input type="date" name="socioemocional[{{$i}}][data_inicial]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="socioemocional[{{$i}}][sim_inicial]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="socioemocional[{{$i}}][nao_inicial]" value="1"></td>
        <td><input type="date" name="socioemocional[{{$i}}][data_final]" value=""></td>
        <td style="text-align:center"><input type="checkbox" name="socioemocional[{{$i}}][sim_final]" value="1"></td>
        <td style="text-align:center"><input type="checkbox" name="socioemocional[{{$i}}][nao_final]" value="1"></td>
        <td><input type="text" name="socioemocional[{{$i}}][observacoes]" value=""></td>
    </tr>
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
        <button type="button" class="pdf-button btn btn-primary">Gerar PDF</button>

    <!-- Importação das bibliotecas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.pdf-button').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;
            // Seleciona o conteúdo principal do formulário para o PDF
            const element = document.querySelector('.container, .menu, main, body');
            html2canvas(element, {
                scale: 0.9,
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210;
                const pageHeight = 297;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let y = 0;
                while (y < imgHeight) {
                    pdf.addImage(imgData, 'PNG', 0, y * -1, imgWidth, imgHeight);
                    y += pageHeight;
                    if (y < imgHeight) pdf.addPage();
                }
                // Pegando o nome do aluno do input ou campo correspondente
                let nomeAluno = '';
                // Busca input que contenha o nome do aluno (readonly) na info-section
                const nomeInput = document.querySelector('.info-section label:nth-child(3) input');
                if (nomeInput && nomeInput.value && nomeInput.value.trim() !== '' && nomeInput.value !== '-') {
                    nomeAluno = nomeInput.value;
                }
                if (!nomeAluno) nomeAluno = 'aluno';
                nomeAluno = nomeAluno
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z0-9 ]/g, '')
                    .replace(/\s+/g, '_')
                    .replace(/^_+|_+$/g, '')
                    .toLowerCase();
                const hoje = new Date();
                const dia = String(hoje.getDate()).padStart(2, '0');
                const mes = String(hoje.getMonth() + 1).padStart(2, '0');
                const ano = hoje.getFullYear();
                const dataAtual = `${dia}-${mes}-${ano}`;
                nomeAluno = nomeAluno
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z0-9 ]/g, '')
                    .replace(/\s+/g, '_')
                    .replace(/^_+|_+$/g, '')
                    .toLowerCase();
const nomeArquivo = `Rotina_monitoramento_${nomeAluno}_${dataAtual}.pdf`;
                pdf.save(nomeArquivo);
            }).catch(error => console.error('Erro ao gerar PDF:', error));
        });
    });
    </script>

        
        <a href="{{ route('index') }}" class="btn btn-primary">Salvar</a>
    <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        
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