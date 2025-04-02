<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
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

  <div class="container">
    <!-- CABEÇALHO -->
    <div class="header">
      <img src="logo1.png" alt="Logo Educação" />
      <div class="title">
        ROTINA E MONITORAMENTO DE <br>
        APLICAÇÃO DE ATIVIDADES 1 - INICIAL
      </div>
      <img src="logo2.png" alt="Logo Focus" />
    </div>

    <!-- INFORMAÇÕES PRINCIPAIS -->
    <div class="info-section">
      <label>
        Secretaria de Educação do Município:
        <input type="text" />
      </label>
      <label>
        Escola:
        <input type="text" />
      </label>
      <label>
        Nome do Aluno:
        <input type="text" />
      </label>
      <label>
        Data de Nascimento:
        <input type="text" placeholder="//" />
      </label>
      <label>
        Idade:
        <input type="text" />
      </label>
      <label>
        Ano/Série:
        <input type="text" />
      </label>
      <label>
        Turma:
        <input type="text" />
      </label>
      <label>
        RA:
        <input type="text" />
      </label>
    </div>

    <!-- PERÍODO DE APLICAÇÃO -->
    <div class="period-section">
      <span class="period">
        <strong>Período de Aplicação (Inicial):</strong>
        <input type="date" placeholder="//" />
      </span>
      <span class="period">
        <strong>Período de Aplicação (Final):</strong>
        <input type="" placeholder="//" />
      </span>
    </div>

    <!-- INSTRUÇÕES -->
    <div class="instructions">
      <p><strong>Caro educador,</strong></p>
      <p>Por favor, registre as atividades nas datas mencionadas e realize a devida anotação no quadro.  
      Se necessário, utilize este espaço para marcar a aplicação e observações pertinentes.  
      Após finalizar o processo, você deverá registrar no Suporte TEG Digital o cenário atual do aluno.</p>
      <p><em>Observação: Em caso de dúvidas, consulte o suporte técnico ou administrativo para orientação.</em></p>
    </div>

    <!-- TABELA DE ATIVIDADES -->
    <div class="table-title">Atividades Realizadas</div>
    <table>
      <thead>
        <tr>
          <th>Atividade</th>
          <th>Data (Inicial)</th>
          <th>Sim</th>
          <th>Não</th>
          <th>Data (Final)</th>
          <th>Sim</th>
          <th>Não</th>
          <th>Observações</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>ECM01 - A mágica da gentileza</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
        <tr>
          <td>ECM02 - A mágica do brincar</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
        <tr>
          <td>ECM03 - A mágica de compartilhar</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
        <tr>
          <td>ECM04 - A mágica do cuidar</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
        <tr>
          <td>ECM05 - A mágica do aprender</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
        <tr>
          <td>ECM06 - Expressão lúdica</td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" placeholder="//" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="checkbox" /></td>
          <td><input type="text" /></td>
        </tr>
      </tbody>
    </table>

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