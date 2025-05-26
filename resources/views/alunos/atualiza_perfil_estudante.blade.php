@extends('index')

@section('title', 'Atualizar Perfil do Estudante')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
<style>
<link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
<style>
    .perfil-container {
        background: #fff;
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .logo-center {
        display: block;
        margin: 0 auto 20px;
        max-width: 200px;
    }
    .logo-bg-top {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo-img-top {
        max-width: 150px;
        height: auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }
    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="number"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .row .form-group {
        flex: 1;
        padding: 0 10px;
        min-width: 200px;
    }
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 10px 0;
    }
    .checkbox-group label {
        margin-right: 20px;
        font-weight: normal;
    }
    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .button-group button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    .button-group .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .button-group .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="perfil-container">
    <div class="logo-bg-top">
    <img src="{{ asset('img/logo_sap.png') }}" alt="Logo Transparente Central" class="logo-center">

    </div>
    <h2>I - Perfil do Estudante</h2>

    @if(isset($dados) && count($dados) > 0)
        @php $aluno = $dados[0]; @endphp

        <form method="POST" action="{{ route('atualiza.perfil.estudante', ['id' => $aluno->alu_id]) }}">
            @method('PUT')
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
                    <label>Gosta de fazer no tempo livre:</label>
                    <textarea name="atividades_livre">{{$perfil->livre_gosta_fazer }}</textarea>
                </div>

                <div class="form-group">
                    <label>Deixa o estudante muito feliz:</label>
                    <textarea name="feliz">{{$perfil->feliz_est }}</textarea>
                </div>

                <div class="form-group">
                    <label>Deixa o estudante muito triste ou desconfortável:</label>
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
                    <label>Caso sim,Como manejar em sala de aula</label>
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
                    <label>O que ajuda a sua interação na escola e o que dificulta a sua interação na escola?
                    </label>
                    <textarea rows="3" name="interacao_escola" >{{$perfil->interacao_escola_04 }}</textarea>
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
                    <label>O que desperta seu interesse para realizar uma tarefa/atividade</label>
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

                <h2 class="profissionais-title">Cadastro de Profissionais</h2>
                <table class="table table-bordered profissionais-table">
                    <thead>
                        <tr>
                            <th>Nome do Profissional</th>
                            <th>Especialidade/Área</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" placeholder="Nome do Profissional" class="form-control"></td>
                            <td><input type="text" placeholder="Especialidade/Área" class="form-control"></td>
                            <td><input type="text" placeholder="Observações" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><input type="text" placeholder="Nome do Profissional" class="form-control"></td>
                            <td><input type="text" placeholder="Especialidade/Área" class="form-control"></td>
                            <td><input type="text" placeholder="Observações" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><input type="text" placeholder="Nome do Profissional" class="form-control"></td>
                            <td><input type="text" placeholder="Especialidade/Área" class="form-control"></td>
                            <td><input type="text" placeholder="Observações" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><input type="text" placeholder="Nome do Profissional" class="form-control"></td>
                            <td><input type="text" placeholder="Especialidade/Área" class="form-control"></td>
                            <td><input type="text" placeholder="Observações" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><input type="text" placeholder="Nome do Profissional" class="form-control"></td>
                            <td><input type="text" placeholder="Especialidade/Área" class="form-control"></td>
                            <td><input type="text" placeholder="Observações" class="form-control"></td>
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
    <div class="logo-bg-bottom">
        <img src="{{ asset('img/logo_baixo.png') }}" alt="Logo Inferior" class="logo-img-bottom">
    </div>
    @else
        <!-- Caso nenhum aluno esteja selecionado -->
        <p>Nenhum aluno foi selecionado. Por favor, selecione um aluno para visualizar os dados.</p>
    @endif
</div>

@section('scripts')
<!-- Scripts para geração de PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection

<style>
    .profissionais-title {
        color: #d35400;
        margin-top: 30px;
        margin-bottom: 15px;
        text-align: left;
        font-size: 1.3rem;
        padding-left: 2px;
    }
    .profissionais-table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
        margin-left: 0;
    }
    .profissionais-table th, .profissionais-table td {
        border: 1px solid #ccc;
        padding: 8px 6px;
        text-align: left;
        vertical-align: middle;
    }
    .profissionais-table input[type="text"] {
        width: 100%;
        box-sizing: border-box;
        padding: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }
    @media (max-width: 700px) {
        .profissionais-table, .profissionais-table thead, 
        .profissionais-table tbody, .profissionais-table th, 
        .profissionais-table td, .profissionais-table tr {
            display: block;
        }
        .profissionais-table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .profissionais-table td {
            border: none;
            border-bottom: 1px solid #eee;
        }
    }
    .logo-bg-top, .logo-bg-bottom {
        width: 100%;
        background: linear-gradient(90deg, #f5f5f5 0%, #fff 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 12px 0 8px 0;
        margin-bottom: 10px;
        border-radius: 8px;
    }
    .logo-bg-bottom {
        margin-top: 24px;
        margin-bottom: 0;
    }
    .logo-img-top, .logo-img-bottom {
        max-width: 170px;
        width: 100%;
        height: auto;
        opacity: 0.92;
    }
    @media (max-width: 700px) {
        .logo-img-top, .logo-img-bottom {
            max-width: 120px;
        }
        .logo-bg-top, .logo-bg-bottom {
            padding: 6px 0;
        }
    }
</style>
@endsection

@section('content')
<div class="perfil-container">
    <div class="logo-bg-top">
        <img src="{{ asset('img/logogando.png') }}" alt="Logo Superior" class="logo-img-top">
    </div>
    <h2>I - Perfil do Estudante</h2>

    @if(isset($dados) && count($dados) > 0)
        @php $aluno = $dados[0]; @endphp

        <form method="POST" action="{{ route('atualiza.perfil.estudante', ['id' => $aluno->alu_id]) }}">
            @method('PUT')
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

            @if(isset($results) && count($results) > 0)
                @php $perfil = $results[0]; @endphp

                <!-- Seção de Dados do Perfil -->
                <div class="form-group">
                    <label>Possui diagnóstico/laudo?</label>
                    <select name="diag_laudo">
                        <option value="1" @if($perfil->diag_laudo == 1) selected @endif>Sim</option>
                        <option value="0" @if($perfil->diag_laudo == 0) selected @endif>Não</option>
                    </select>
                </div>

                <!-- Outros campos do formulário -->
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <button type="button" class="btn btn-secondary pdf-button">Gerar PDF</button>
                </div>
            @else
                <p>Nenhum perfil encontrado para este estudante.</p>
            @endif
        </form>
    @else
        <p>Nenhum dado de estudante encontrado.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configura o botão de gerar PDF
        const pdfButton = document.querySelector(".pdf-button");
        if (pdfButton) {
            pdfButton.addEventListener("click", function() {
                const element = document.querySelector('.perfil-container');
                
                html2canvas(element, {
                    scale: 1.0,
                    useCORS: true,
                    logging: false
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                    
                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('perfil_estudante.pdf');
                });
            });
        }
    });
</script>
@endpush
