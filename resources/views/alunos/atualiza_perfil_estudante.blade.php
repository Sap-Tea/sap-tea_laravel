<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Estudante</title>
    
    <!-- Importando CSS no Laravel -->
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
    <style>
    body {
        min-height: 100vh;
        background: #fff;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .logo-top-left {
        position: fixed;
        top: 25mm;
        left: 20mm;
        width: 60mm;
        opacity: 0.25;
        z-index: 1;
        filter: drop-shadow(0 2px 8px #0002) grayscale(1);
        pointer-events: none;
    }
    .logo-bottom-right {
        position: fixed;
        bottom: 20mm;
        right: 20mm;
        width: 60mm;
        opacity: 0.25;
        z-index: 1;
        filter: drop-shadow(0 2px 8px #0002) grayscale(1);
        pointer-events: none;
    }
    .container {
        position: relative;
        background: #fff;
        z-index: 1;
        padding: 36px 28px 36px 28px;
        border-radius: 8px;
        margin: 0 auto 0 auto;
        box-shadow: 0 6px 24px rgba(0,0,0,0.10);
        max-width: 190mm;
        min-height: 277mm;
        width: 100%;
        box-sizing: border-box;
        opacity: 1;
    }
    .vertical-watermark {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }
    .watermark-top, .watermark-bottom {
        width: 60mm;
        opacity: 0.18;
        filter: grayscale(1);
    }
    .watermark-center {
        width: 30mm;
        opacity: 0.08;
        filter: grayscale(1);
    }
    .form-content {
        position: relative;
        z-index: 2;
    }
    .watermark-bg {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        pointer-events: none;
        background: url('{{ asset('img/logo_sap.png') }}') no-repeat center center;
        background-size: 30vw auto;
        opacity: 0.08;
    }
    h2 {
        text-align: center;
        color: #204080;
        font-weight: 600;
        margin-bottom: 32px;
        letter-spacing: 0.02em;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
            background: #fff !important;
        }
        .container {
            box-shadow: none;
            margin: 0;
            padding: 20mm 10mm 20mm 10mm;
            border-radius: 0;
            min-height: 277mm;
            max-width: 190mm;
            width: 100%;
            page-break-after: always;
            background-size: 65% auto;
            background-position: center;
        }
        .logo-top-left, .logo-bottom-right {
            opacity: 0.18 !important;
            filter: grayscale(1) !important;
        }
    }
    @page {
        size: A4;
        margin: 0;
    }
    
    }
    .container {
        position: relative;
        z-index: 100;
        background: #fff;
        padding: 48px 36px 48px 36px;
        border-radius: 14px;
        margin: 80px auto 80px auto;
        box-shadow: 0 6px 24px rgba(0,0,0,0.10);
        max-width: 980px;
        min-height: 900px;
    }
    h2 {
        text-align: center;
        color: #204080;
        font-weight: 600;
        margin-bottom: 32px;
        letter-spacing: 0.02em;
    }
    @media (max-width: 700px) {
        .container {
            padding: 18px 3vw 18px 3vw;
            margin: 20vw 0 10vw 0;
        }
        .logo-top-left, .logo-bottom-right {
            width: 70px;
            top: 12px !important;
            left: 12px !important;
            right: 12px !important;
            bottom: 12px !important;
        }
        .logo-center {
            width: 160px;
        }
    }
    @media print {
        body {
            background: #fff !important;
        }
        .logo-top-left, .logo-bottom-right, .logo-center {
            opacity: 0.18 !important;
            filter: grayscale(1) !important;
        }
        .container {
            box-shadow: none;
            margin: 0;
            padding: 22px 8px 22px 8px;
            border-radius: 0;
        }
    }
</style>
</head>

<body>
<div class="container">
    <div class="vertical-watermark">
        <img src="{{ asset('img/logogando.png') }}" alt="Logo Topo" class="watermark-top">
        <img src="{{ asset('img/logo_sap.png') }}" alt="Marca d'água Central" class="watermark-center">
        <img src="{{ asset('img/logo_baixo.png') }}" alt="Logo Rodapé" class="watermark-bottom">
    </div>
    <div class="form-content" style="position:relative;z-index:2;">
        <h2>I - Perfil do Estudante</h2>

    <!-- Verifica se há dados do aluno selecionado -->
    @if(isset($dados) && count($dados) > 0)
        <!-- Seleciona o primeiro aluno da lista ($dados[0]) -->
        @php $aluno = $dados[0]; @endphp

        <form method="POST" action="{{ route('atualiza.perfil.estudante', ['id' => $aluno->alu_id]) }}">
            @csrf

            <!-- Dados do aluno selecionado -->
            <input type="hidden" name="aluno_id" value="{{ $aluno->alu_id }}">
            
            <div class="form-group">
                <label>Nome do Aluno:</label>
                <input type="text" name="nome_aluno" value="{{ $aluno->alu_nome }}" readonly>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Ano/Série:</label>
                    <input type="text" value="{{ $aluno->desc_modalidade . '-' . $aluno->desc_serie_modalidade }}" readonly>
                </div>

                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input type="text" name="alu_nasc" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->format('d/m/Y') }}" readonly>
                </div>

                <div class="form-group">
                    <label>Idade do Aluno:</label>
                    <input type="text" name="alu_idade" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} anos" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Nome do Professor:</label>
                <input type="text" name="nome_professor" value="{{ $aluno->func_nome }}" readonly>
            </div>

            <!-- Dados adicionais do perfil -->
            @if(isset($results) && count($results) > 0)
                @php $perfil = $results[0]; @endphp

                <div class="form-group">
                    <label>Possui diagnóstico/laudo?</label>
                    <select name="diag_laudo">
                        <option value="1" @if($perfil->diag_laudo == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->diag_laudo == 0) selected @endif>Não</option>
                    </select>
                </div>

                <!-- Outros campos adicionais -->
                <!-- Exemplo: CID, Médico, Data do Laudo -->
                <div class="row">
                    <div class="form-group">
                        <label>CID:</label>
                        <input type="text" name="cid" value="{{ $perfil->cid }}">
                    </div>
                    <div class="form-group">
                        <label>Médico:</label>
                        <input type="text" name="nome_medico" value="{{ $perfil->nome_medico }}">
                    </div>
                    <div class="form-group">
                        <label>Data do Laudo:</label>
                        <input type="date" name="data_laudo" value="{{ $perfil->data_laudo }}">
                    </div>
                </div>


                <div class="form-group">
                    <label>Nível suporte</label>
                    <select name="nivel_suporte">
                        <option value="1" @if($perfil->nivel_suporte == 1) selected @endif>Nível 1 - Exige pouco apoio </option>
                        <option value="2" @if($perfil->nivel_suporte == 2) selected @endif>Nível 2 - Exige apoio substancial</option>
                        <option value="3" @if($perfil->nivel_suporte == 3) selected @endif>Nível 3 - Exige apoio muito substancial</option>
                    </select>
                </div>

                <div class="form-group">
                <label>Faz uso de medicamento?</label>
                    <select name="uso_medicamento">
                        <option value="1" @if($perfil->uso_medicamento == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->uso_medicamento == 0) selected @endif>Não</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Quais?</label>
                    <input type="text" name="quais_medicamento" value="{{$perfil->quais_medicamento }}">
                </div>

                <div class="row">
                    <div class="form-group">
                        <label>Necessita de profissional de apoio em sala?</label>
                        <select name="nec_pro_apoio">
                        <option value="1" @if($perfil->nec_pro_apoio == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->nec_pro_apoio == 0) selected @endif>Não</option>
                        </select>
                    </div>

                    <div class="row">
                    <div class="form-group">
                        <label>O estudante conta com o profissional de apoio?</label>
                        <select name="prof_apoio">
                                <option value="1" @if($perfil->prof_apoio == 1) selected @endif>Sim</option>
                                <option value="0" @if($perfil->prof_apoio == 0) selected @endif>Não</option>
                        </select>
                    </div>
                </div>
                </div>   

                <div class="form-group">
                 <label>Em quais momentos da rotina esse profissional se faz necessário?</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="locomocao" @if($perfil->loc_01) checked @endif><label for="locomocao">Locomoção</label>
                        <input type="checkbox" name="higiene" @if($perfil->hig_02) checked @endif><label for="higiene">Higiene</label>
                        <input type="checkbox" name="alimentacao" @if($perfil->ali_03) checked @endif><label for="alimentacao">Alimentação</label>
                        <input type="checkbox" name="comunicacao" @if($perfil->com_04) checked @endif><label for="comunicacao">Comunicação</label>
                        <input type="checkbox" name="outros" @if($perfil->out_05) checked @endif><label for="outros">Outros momentos</label>
                </div>
                    <input type="text" name="out_momentos" placeholder="Quais?" value="{{$perfil->out_momentos }}">
                </div>


                <div class="form-group">
                    <label>O estudante conta com Atendimento Educacional Especializado?</label>
                    <select name="at_especializado">
                        <option value="1" @if($perfil->at_especializado == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->at_especializado == 0) selected @endif>Não</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Nome do profissional do AEE:</label>
                    <input type="text" name="nome_prof_AEE" value="{{$perfil->nome_prof_AEE }}">
                </div>

                <h2> II - Personalidade</h2>

                <div class="form-group">
                    <label>Principais características:</label>
                    <textarea rows="3" name="caracteristicas">{{$perfil->carac_principal }}</textarea>
                </div>

                <div class="form-group">
                    <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                    <textarea name="areas_interesse">{{$perfil->inter_princ_carac}}</textarea>

                </div>

                <div class="form-group">
                    <label>Gosta de fazer no tempo livre?</label>
                    <textarea name="atividades_livre">{{$perfil->livre_gosta_fazer }}</textarea>
                </div>

                <div class="form-group">
                    <label>Deixa o estudante muito feliz?</label>
                    <textarea name="feliz">{{$perfil->feliz_est }}</textarea>
                </div>

                <div class="form-group">
                    <label>Deixa o estudante muito triste ou desconfortável?</label>
                    <textarea name="triste">{{$perfil->trist_est }}</textarea>
                </div>

                <div class="form-group">
                    <label>Objeto de apego? Qual?</label>
                    <textarea name="objeto_apego">{{$perfil->obj_apego }}</textarea>
                </div>

                <h2 class="comunicacao-section">III - Comunicação</h2>

                <div class="form-group">
                   <label>Precisa de comunicação alternativa para expressar-se?</label>
                   <select name="precisa_comunicacao">
                     <option value="1" @if($perfil->precisa_comunicacao == 1) selected @endif>Sim</option>
                     <option value="0" @if($perfil->precisa_comunicacao == 0) selected @endif>Não</option>
                 </select>
                </div>


                <div class="form-group">
                 <label>Entende instruções dadas de forma verbal?</label>
                  <select name="entende_instrucao">
                     <option value="1" @if($perfil->entende_instrucao == 1) selected @endif>Sim</option>
                    <option value="0" @if($perfil->entende_instrucao == 0) selected @endif>Não</option>
                  </select>
            </div>

                <div class="form-group">
                    <label>Caso não,Como você recomenda dar instruções?</label>
                    <textarea name="recomenda_instrucao">{{$perfil->recomenda_instrucao }}</textarea>
                </div>

                <h2>IV - Preferencias, sensibilidade e dificuldades</h2>

                <div class="form-group">
                    <label>Apresenta sensibilidade:</label>
                        <div class="checkbox-group">
                            <input type="checkbox" name="s_auditiva" @if($perfil->auditivo_04) checked @endif><label for="s_auditiva">Auditiva</label>
                            <input type="checkbox" name="s_visual" @if($perfil->visual_04) checked @endif><label for="s_visual">Visual</label>
                            <input type="checkbox" name="s_tatil" @if($perfil->tatil_04) checked @endif><label for="s_tatil">Tátil</label>
                            <input type="checkbox" name="s_outros" @if($perfil->outros_04) checked @endif><label for="s_outros">Outros estímulos</label>
                        </div>
                </div>


                <div class="form-group">
                    <label>Caso sim,Como manejar em sala de aula?</label>
                    <textarea name="manejo_sensibilidade">{{$perfil->maneja_04 }}</textarea>
                </div>

                <div class="form-group">
                  <label>Apresenta seletividade alimentar?</label>
                    <select name="seletividade_alimentar">
                        <option value="1" @if($perfil->asa_04 == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->asa_04 == 0) selected @endif>Não</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Alimentos preferidos:</label>
                    <textarea rows="3" name="alimentos_preferidos">{{$perfil->alimentos_pref_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Alimentos que evita:</label>
                    <textarea name="alimentos_evita">{{$perfil->alimento_evita_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Com quem tem mais afinidade na escola (professores, colegas)? Identifique</label>
                    <textarea rows="3" name="afinidade_escola">{{$perfil->contato_pc_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Como reage no contato com novas pessoas ou situações</label>
                    <textarea rows="3" name="reacao_contato">{{$perfil->reage_contato }}</textarea>
                </div>

                <div class="form-group">
                    <label>O que ajuda a sua interação na escola ?
                    </label>
                    <textarea rows="3" name="interacao_escola1" >{{$perfil->interacao_escola_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label> o que dificulta a sua interação na escola?
                    </label>
                    <textarea rows="3" name="interacao_escola2" >{{$perfil->interacao_escola_04 }}</textarea>
                </div>



                <div class="form-group">
                    <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                    <textarea rows="3" name="interesse_atividade">{{$perfil->interesse_atividade_04 }}</textarea>
                </div>

                <div class="form-group">
    <label>Como o(a) estudante aprende melhor?</label>
    <div class="checkbox-group">
        <input type="checkbox" name="r_visual" @if($perfil->aprende_visual_04) checked @endif><label for="r_visual">Recurso visual</label>
        <input type="checkbox" name="r_auditivo" @if($perfil->recurso_auditivo_04) checked @endif><label for="r_auditivo">Recurso auditivo</label>
        <input type="checkbox" name="m_concreto" @if($perfil->material_concreto_04) checked @endif><label for="m_concreto">Material concreto</label>
        <input type="checkbox" name="o_outro" @if($perfil->outro_identificar_04) checked @endif><label for="o_outro">Outro - identificar</label>
    </div>

    <div class="form-group">
        <label></label>
        <textarea rows="3" name="outro_identificar">{{$perfil->descricao_outro_identificar_04 }}</textarea>
    </div>
</div>


                <div class="form-group">
                    <label>Gosta de atividades em grupo ou prefere trabalhar sozinho?</label>
                    <textarea rows="3" name="atividades_grupo">{{$perfil->realiza_tarefa_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Quais estratégias são utilizadas e se mostram eficazes?</label>
                    <textarea rows="3" name="estrategias_eficazes">{{$perfil->mostram_eficazes_04 }}</textarea>
                </div>

                <div class="form-group">
                    <label>O que desperta seu interesse para realizar uma tarefa/atividades?</label>
                    <textarea rows="3" name="interesse_tarefa">{{$perfil->prefere_ts_04 }}</textarea>
                </div>


                
                <h2 class="comunicacao-section">V - Informações da família</h2>

                <div class="form-group">
                    <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
                    <textarea rows="3" name="expectativas_familia">{{$perfil->expectativa_05 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Existe alguma estratégia utilizada no contexto familiar que pode ser reaplicada na escola?</label>
                    <textarea rows="3" name="estrategias_familia">{{$perfil->estrategia_05 }}</textarea>
                </div>

                <div class="form-group">
                    <label>Caso o estudante tenha uma crise ou situação de estresse elevado, o que fazer?</label>
                    <textarea rows="3" name="crise_estresse">{{$perfil->crise_esta_05 }}</textarea>
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
        tr:nth-child(odd) {
            background-color: #e0f7fa;
        }
        tr:nth-child(even) {
            background-color: #fff9c4;
        }
        tr:hover {
            background-color: #d1c4e9;
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

    <h2>Cadastro de Profissionais</h2>
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
                <td><input type="text" placeholder="Nome do Profissional"></td>
                <td><input type="text" placeholder="Especialidade/Área"></td>
                <td><input type="text" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" placeholder="Nome do Profissional"></td>
                <td><input type="text" placeholder="Especialidade/Área"></td>
                <td><input type="text" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" placeholder="Nome do Profissional"></td>
                <td><input type="text" placeholder="Especialidade/Área"></td>
                <td><input type="text" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" placeholder="Nome do Profissional"></td>
                <td><input type="text" placeholder="Especialidade/Área"></td>
                <td><input type="text" placeholder="Observações"></td>
            </tr>
            <tr>
                <td><input type="text" placeholder="Nome do Profissional"></td>
                <td><input type="text" placeholder="Especialidade/Área"></td>
                <td><input type="text" placeholder="Observações"></td>
            </tr>
        </tbody>
    </table>
              
            @endif

            <!-- Botões -->
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Confirma Alteração</button>
                <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
                <button type="button" class="pdf-button">Gerar PDF</button>
            </div>
        </form>
    @else
        <!-- Caso nenhum aluno esteja selecionado -->
        <p>Nenhum aluno foi selecionado. Por favor, selecione um aluno para visualizar os dados.</p>
    @endif
</div>

<!-- Importação das bibliotecas (deixe antes do script) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
// Geração de PDF multipágina A4 com marca d'água e nome personalizado
if(document.querySelector('.pdf-button')){
    document.querySelector('.pdf-button').addEventListener('click', function() {
        const container = document.querySelector('.container');
        html2canvas(container, {
            scale: 2,
            useCORS: true,
            backgroundColor: null,
        }).then(function(canvas) {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF("p", "mm", "a4");
            const imgWidth = 210;
            const pageHeight = 297;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            let y = 0;
            while (y < imgHeight) {
                pdf.addImage(imgData, "PNG", 0, y * -1, imgWidth, imgHeight);
                y += pageHeight;
                if (y < imgHeight) pdf.addPage();
            }
            // Nome do aluno diretamente da variável PHP (ajuste conforme necessário)
            const nomeAluno = "Alice Figueiredo";
            // Remove acentos e caracteres especiais, troca espaços por _
            const nomeFormatado = nomeAluno
                .normalize('NFD').replace(/[̀-ͯ]/g, '')
                .replace(/[^a-zA-Z0-9]/g, '_')
                .replace(/_+/g, '_')
                .replace(/^_+|_+$/g, '');
            // Data no formato DD-MM-AAAA
            const hoje = new Date();
            const dia = String(hoje.getDate()).padStart(2, '0');
            const mes = String(hoje.getMonth() + 1).padStart(2, '0');
            const ano = hoje.getFullYear();
            const dataAtual = `${dia}-${mes}-${ano}`;
            // Nome do arquivo
            const nomeArquivo = `Perfil_${nomeFormatado}_${dataAtual}.pdf`;
            pdf.save(nomeArquivo);
        }).catch(error => console.error("Erro ao gerar PDF:", error));
    });
}
</script>        const pdf = new jsPDF("p", "mm", "a4");
        const imgWidth = 210;
        const pageHeight = 297;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        // Adiciona as imagens como marca d'água
        // Logo superior esquerda
        pdf.addImage("{{ asset('img/logogando.png') }}", "PNG", 10, 10, 50, 50, undefined, 'FAST');
        // Logo inferior direita
        pdf.addImage("{{ asset('img/logo_baixo.png') }}", "PNG", 160, 240, 50, 50, undefined, 'FAST');
        // Logo central
        pdf.addImage("{{ asset('img/logo_sap.png') }}", "PNG", 85, 120, 40, 40, undefined, 'FAST');

        let y = 0;
        while (y < imgHeight) {
            pdf.addImage(imgData, "PNG", 0, y * -1, imgWidth, imgHeight);
            y += pageHeight;
            if (y < imgHeight) pdf.addPage();
        }

        // Pegando o nome do aluno diretamente da variável PHP
        const nomeAluno = "{{ $aluno->alu_nome }}";
        // Remove acentos e caracteres especiais, troca espaços por _
        const nomeFormatado = nomeAluno
            .normalize('NFD').replace(/[̀-ͯ]/g, '')
            .replace(/[^a-zA-Z0-9]/g, '_')
            .replace(/_+/g, '_')
            .replace(/^_+|_+$/g, '');

        // Data no formato DD-MM-AAAA
        const hoje = new Date();
        const dia = String(hoje.getDate()).padStart(2, '0');
        const mes = String(hoje.getMonth() + 1).padStart(2, '0');
        const ano = hoje.getFullYear();
        const dataAtual = `${dia}-${mes}-${ano}`;

        // Nome do arquivo
        const nomeArquivo = `Perfil_${nomeFormatado}_${dataAtual}.pdf`;

        pdf.save(nomeArquivo);
    }).catch(error => console.error("Erro ao gerar PDF:", error));
});
</script>

</body>
</html>






















