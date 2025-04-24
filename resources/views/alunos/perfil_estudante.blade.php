


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Estudante</title>
    
    <!-- Importando CSS no Laravel -->
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
</head>

<body>

<img src="{{ asset('img/logogando.png') }}" alt="Logo Superior Esquerda" class="logo-top-left">
<img src="{{ asset('img/logo_baixo.png') }}" alt="Logo Inferior Direita" class="logo-bottom-right">
<img src="{{ asset('img/logo_sap.png') }}" alt="Logo Transparente Central" class="logo-center">


<div class="container">
        <h2>I - Perfil do Estudante</h2>
        <form method="POST" action="{{ route('inserir_perfil') }}">
            @csrf
            <input type="hidden" name="aluno_id" value="{{$aluno->alu_id }}">
            <div class="form-group">
                <label>Nome do Aluno:</label>
                <input type="text" name="nome_aluno" value="{{ $aluno->alu_nome }}" readonly>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Ano/Série:</label>
                    <input type="text" value="{{$aluno->desc_modalidade.'-'.  $aluno->desc_serie_modalidade}}" readonly>
                </div>

                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input type="text" name="alu_nasc" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->format('d/m/Y') }}" readonly>
                </div>

                <div class="form-group">
                    <label>Idade do aluno:</label>
                    <input type="text" name="alu_nasc" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} - anos" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Nome do Professor:</label>
                <input type="text" name="nome_professor" value="{{ $aluno->func_nome }}" readonly>
            </div>

            <div class="form-group">
                <label>Possui diagnóstico/laudo?</label>
                <select name="diag_laudo">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>CID:</label>
                    <input type="text" name="cid">
                </div>
                <div class="form-group">
                    <label>Médico:</label>
                    <input type="text" name="nome_medico">
                </div>
                <div class="form-group">
                    <label>Data do Laudo:</label>
                    <input type="date" name="data_laudo">
                </div>
            </div>

            <div class="form-group">
                <label>Nível suporte</label>
                <select name="nivel_suporte">
                    <option value="1">Nível 1 - Exige pouco apoio </option>
                    <option value="2">Nível 2 - Exige apoio substancial</option>
                    <option value="3">Nível 3 - Exige apoio muito substancial</option>
                </select>
            </div>

            <div class="form-group">
                <label>Faz uso de medicamento?</label>
                <select name="uso_medicamento">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label>Quais?</label>
                <input type="text" name="quais_medicamento">
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Necessita de profissional de apoio em sala?</label>
                    <select name="nec_pro_apoio">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>O estudante conta com profissional de apoio?</label>
                    <select name="loc_01">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Em quais momentos da rotina esse profissional se faz necessário?</label>
                <div class="checkbox-group">
                    <input type="checkbox" name ="locomocao"><label for="locomocao">Locomoção</label>
                    <input type="checkbox" name="higiene"><label for="higiene">Higiene</label>
                    <input type="checkbox" name="alimentacao"><label for="alimentacao">Alimentação</label>
                    <input type="checkbox" name="comunicacao"><label for="comunicacao">Comunicação</label>
                    <input type="checkbox" name="outros"><label for="outros">Outros momentos</label>
                </div>
                <input type="text" name="out_momentos" placeholder="Quais?">
            </div>

            <div class="form-group">
                <label>O estudante conta com Atendimento Educacional Especializado?</label>
                <select name="at_especializado">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nome do profissional do AEE:</label>
                <input type="text" name="nome_prof_AEE">
            </div>

            <h2> II - Personalidade</h2>

            <div class="form-group">
                <label>Principais características:</label>
                <textarea rows="3" name="caracteristicas"></textarea>
            </div>

            <div class="form-group">
                <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                <textarea rows="3" name="areas_interesse"></textarea>
            </div>

            <div class="form-group">
                <label>Gosta de fazer no tempo livre:</label>
                <textarea rows="3" name="atividades_livre"></textarea>
            </div>

            <div class="form-group">
                <label>Deixa o estudante muito feliz:</label>
                <textarea rows="3" name="feliz"></textarea>
            </div>

            <div class="form-group">
                <label>Deixa o estudante muito triste ou desconfortável:</label>
                <textarea rows="3" name="triste"></textarea>
            </div>

            <div class="form-group">
                <label>Objeto de apego? Qual?</label>
                <textarea rows="3" name="objeto_apego"></textarea>
            </div>

            <h2 class="comunicacao-section">III - Comunicação</h2>

            <div class="form-group">
                <label>Precisa de comunicação alternativa para expressar-se?</label>
                <select name="precisa_comunicacao">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label>Entende instruções dadas de forma verbal ?</label>
                <select name="entende_instrucao">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="form-group">
                <label>Caso não,Como você recomenda dar instruções?</label>
                <textarea rows="3" name="recomenda_instrucao"></textarea>
            </div>

            <h2>IV - Preferencias, sensibilidade e dificuldades</h2>

            <div class="form-group">
                <label>Apresenta sensibilidade:</label>
                <div class="checkbox-group">
                    <input type="checkbox" name="s_auditiva"><label for="s_auditiva">Auditiva</label>
                    <input type="checkbox" name="s_visual"><label for="s_visual">Visual</label>
                    <input type="checkbox" name="s_tatil"><label for="s_tatil">Tátil</label>
                    <input type="checkbox" name="s_outros"><label for="s_outros">Outros estímulos</label>
                </div>

            </div>

            <div class="form-group">
                <label>Caso sim,Como manejar em sala de aula</label>
                <textarea rows="3" name="manejo_sensibilidade"></textarea>
            </div>

            <div class="form-group">
                <label>Apresenta seletividade alimentar?</label>
                <select name="seletividade_alimentar">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>

            </div>

            <div class="form-group">
                <label>Alimentos preferidos:</label>
                <textarea rows="3" name="alimentos_preferidos"></textarea>
            </div>

            <div class="form-group">
                <label>Alimentos que evita:</label>
                <textarea rows="3" name="alimentos_evita"></textarea>
            </div>

            <div class="form-group">
                <label>Com quem tem mais afinidade na escola (professores, colegas)? Identifique</label>
                <textarea rows="3" name="afinidade_escola"></textarea>
            </div>

            <div class="form-group">
                <label>Como reage no contato com novas pessoas ou situações</label>
                <textarea rows="3" name="reacao_contato"></textarea>
            </div>

            <div class="form-group">
                <label>O que ajuda a sua interação na escola e o que dificulta a sua interação na escola?
                </label>
                <textarea rows="3" name="interacao_escola" ></textarea>
            </div>

            <div class="form-group">
                <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                <textarea rows="3" name="interesse_atividade"></textarea>
            </div>

            <div class="form-group">
                <label>Como o(a) estudante aprende melhor?</label>
                <div class="checkbox-group">
                    <input type="checkbox" name = "r_visual"><label for="r_visual">Recurso visual</label>
                    <input type="checkbox" name = "r_auditivo"><label for="r_auditivo">Recurso auditivo</label>
                    <input type="checkbox" name = "m_concreto"><label for="m_concreto">Material concreto</label>
                    <input type="checkbox" name = "o_outro"><label for="o_outro">Outro - identificar</label>
                </div>

                <div class="form-group">
                    <label></label>
                    <textarea rows="3" name="outro_identificar"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label>Gosta de atividades em grupo ou prefere trabalhar sozinho?</label>
                <textarea rows="3" name="atividades_grupo"></textarea>
            </div>

            <div class="form-group">
                <label>Quais estratégias são utilizadas e se mostram eficazes?</label>
                <textarea rows="3" name="estrategias_eficazes"></textarea>
            </div>

            <div class="form-group">
                <label>O que desperta seu interesse para realizar uma tarefa/atividade</label>
                <textarea rows="3" name="interesse_tarefa"></textarea>
            </div>

            <h2 class="comunicacao-section">V - Informações da família</h2>

            <div class="form-group">
                <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
                <textarea rows="3" name="expectativas_familia"></textarea>
            </div>

            <div class="form-group">
                <label>Existe alguma estratégia utilizada no contexto familiar que pode ser reaplicada na escola?</label>
                <textarea rows="3" name="estrategias_familia"></textarea>
            </div>

            <div class="form-group">
                <label>Caso o estudante tenha uma crise ou situação de estresse elevado, o que fazer?</label>
                <textarea rows="3" name="crise_estresse"></textarea>
            </div>

            <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Cor das linhas conforme as novas cores */
        tr:nth-child(1) td {
            background-color: #fff9c4; /* Amarelo claro */
        }
        tr:nth-child(2) td {
            background-color: #e1f5fe; /* Azul claro */
        }
        tr:nth-child(3) td {
            background-color: #c8e6c9; /* Verde claro */
        }
        tr:nth-child(4) td {
            background-color: #ffe0b2; /* Laranja claro */
        }
        tr:nth-child(5) td {
            background-color: #f8bbd0; /* Rosa claro */
        }
        tr:nth-child(6) td {
            background-color: #fff9c4; /* Amarelo claro */
        }

        tr:hover {
            background-color: #d1c4e9; /* Efeito hover (roxo claro) */
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>


    <table>
        <thead>
            <tr>
                <th>Nome do Profissional</th>
                <th>Especialidade/Área</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="nome_profissional" placeholder="Nome do Profissional"></td>
                <td><input type="text" name="especialidade_area" placeholder="Especialidade/Área"></td>
                <td><input type="text" name="observacoes" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" name="nome_profissional" placeholder="Nome do Profissional"></td>
                <td><input type="text" name="especialidade_area" placeholder="Especialidade/Área"></td>
                <td><input type="text" name="observacoes" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" name="nome_profissional" placeholder="Nome do Profissional"></td>
                <td><input type="text" name="especialidade_area" placeholder="Especialidade/Área"></td>
                <td><input type="text" name="observacoes" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" name="nome_profissional" placeholder="Nome do Profissional"></td>
                <td><input type="text" name="especialidade_area" placeholder="Especialidade/Área"></td>
                <td><input type="text" name="observacoes" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" name="nome_profissional" placeholder="Nome do Profissional"></td>
                <td><input type="text" name="especialidade_area" placeholder="Especialidade/Área"></td>
                <td><input type="text" name="observacoes" placeholder="Observações"></td>
            </tr>
        </tbody>
    </table>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
                <button type="button" class="pdf-button">Gerar PDF</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.querySelector(".pdf-button").addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const element = document.body;

        html2canvas(element, { scale: 1.0 }).then(canvas => {
            const imgData = canvas.toDataURL("image/jpeg", 0.8);
            const pdf = new jsPDF("p", "mm", "a4");

            const imgWidth = 210;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            pdf.addImage(imgData, "JPEG", 0, 0, imgWidth, imgHeight);
            pdf.save("{{ preg_replace('/[^A-Za-z0-9]/', '_', $aluno->alu_nome) }}.pdf");
        });
    });
</script>

</body>
</html>



