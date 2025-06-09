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
    <div class="container">
        <form method="POST" action="{{ route('inserir_perfil') }}" id="perfilForm" onsubmit="return confirmSubmit(event)">
            @csrf
            <input type="hidden" name="is_confirmed" id="is_confirmed" value="0">
            <input type="hidden" name="aluno_id" value="{{$aluno->alu_id }}">
            
            <h2>Perfil do Estudante</h2>
            <!-- Barra de progresso -->
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>
            <!-- Abas de etapas -->
            <div class="step-tabs">
                <button class="step-tab" data-step="1">Dados Pessoais</button>
                <button class="step-tab" data-step="2">Perfil do Estudante</button>
                <button class="step-tab" data-step="3">Personalidade</button>
                <button class="step-tab" data-step="4">Preferências</button>
                <button class="step-tab" data-step="5">Informações da Família</button>
                <button class="step-tab" data-step="6">Profissionais</button>
            </div>

            
            <!-- Etapa 1: Dados Pessoais -->
            <div class="step-content active" data-step="1">
                <div class="section-title">Dados Pessoais do Aluno</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Nome do Aluno:</label>
                        <input type="text" name="nome_aluno" value="{{ $aluno->alu_nome }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>RA do Aluno:</label>
                        <input type="text" name="ra_aluno" value="{{ $aluno->alu_ra }}" readonly class="form-control" style="min-width:80px;max-width:140px;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>Data de Nascimento:</label>
                        <input type="text" name="alu_dtnasc_display" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->format('d/m/Y') }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Idade:</label>
                        <input type="text" name="alu_idade_display" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }}" readonly class="form-control" style="min-width:55px;max-width:80px;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Escola:</label>
                        <input type="text" name="escola_nome" value="{{ $aluno->esc_razao_social ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Órgão:</label>
                        <input type="text" name="orgao_nome" value="{{ $aluno->org_razaosocial ?? '' }}" readonly class="form-control">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-3">
                        <label>Ano / Série:</label>
                        <input type="text" name="ano_serie" value="{{ $alunoDetalhado->serie_desc ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Turma:</label>
                        <input type="text" name="turma" value="{{ $alunoDetalhado->fk_cod_valor_turma ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Modalidade:</label>
                        <input type="text" name="modalidade" value="{{ $alunoDetalhado->desc_modalidade ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Período:</label>
                        <input type="text" name="periodo" value="{{ $aluno->alu_periodo ?? '' }}" readonly class="form-control">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Nome do Professor:</label>
                        <input type="text" name="nome_professor" value="{{ $alunoDetalhado->func_nome ?? '' }}" readonly class="form-control">
                    </div>
                </div>
                <div class="section-title" style="background-color: #ff8c00; margin-top: 15px;">DADOS DO RESPONSÁVEL</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-8">
                        <label>Nome do Responsável:</label>
                        <input type="text" name="nome_responsavel" value="{{ $aluno->alu_nome_resp ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tipo de Parentesco:</label>
                        <input type="text" name="tipo_parentesco" value="{{ $aluno->alu_tipo_parentesco ?? '' }}" readonly class="form-control">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Telefone:</label>
                        <input type="text" name="telefone_responsavel" value="{{ $aluno->alu_tel_resp ?? '' }}" readonly class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>E-mail:</label>
                        <input type="text" name="email_responsavel" value="{{ $aluno->alu_email_resp ?? '' }}" readonly class="form-control">
                    </div>
                </div>
            </div>
            
            <!-- Etapa 2: Mais Dados Pessoais -->
            <div class="step-content" data-step="2">
                <div class="section-title">Perfil do Estudante</div>
                <!-- Diagnóstico/Laudo -->
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>Possui diagnóstico/laudo?</label>
                        <select name="diag_laudo" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Data do Laudo</label>
                        <input type="date" name="data_laudo" class="form-control">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>CID</label>
                        <input type="text" name="cid" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Médico</label>
                        <input type="text" name="nome_medico" class="form-control">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                     <div class="form-group col-md-4">
                        <label>Nível Suporte</label>
                        <select name="nivel_suporte" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Nível 1 - Exige pouco apoio</option>
                            <option value="2">Nível 2 - Exige apoio substancial</option>
                            <option value="3">Nível 3 - Exige apoio muito substancial</option>
                        </select>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>Faz uso de medicamento?</label>
                        <select name="uso_medicamento" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Quais?</label>
                        <input type="text" name="quais_medicamento" class="form-control">
                    </div>
                </div>

                <!-- Apoio e AEE -->
                <div class="section-title">Apoio e AEE</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Necessita de profissional de apoio em sala?</label>
                        <select name="nec_pro_apoio" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>O estudante conta com profissional de apoio?</label>
                        <select name="conta_pro_apoio" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Em quais momentos da rotina esse profissional se faz necessário?</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="momento_locomocao" name="momentos_apoio[]" value="locomocao"><label for="momento_locomocao">Locomoção</label>
                        <input type="checkbox" id="momento_higiene" name="momentos_apoio[]" value="higiene"><label for="momento_higiene">Higiene</label>
                        <input type="checkbox" id="momento_alimentacao" name="momentos_apoio[]" value="alimentacao"><label for="momento_alimentacao">Alimentação</label>
                        <input type="checkbox" id="momento_comunicacao" name="momentos_apoio[]" value="comunicacao"><label for="momento_comunicacao">Comunicação</label>
                        <input type="checkbox" id="momento_outros" name="momentos_apoio[]" value="outros"><label for="momento_outros">Outros momentos</label>
                    </div>
                    <input type="text" name="outros_momentos_apoio" placeholder="Quais outros momentos?" class="form-control" style="margin-top: 5px;">
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>O estudante conta com Atendimento Educacional Especializado (AEE)?</label>
                        <select name="at_especializado" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nome do profissional do AEE:</label>
                        <input type="text" name="nome_prof_AEE" class="form-control">
                    </div>
                </div>


            </div>
            
            <!-- Etapa 3: Personalidade e Comunicação -->
            <div class="step-content" data-step="3">
                <div class="section-title">II - Personalidade</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Principais características:</label>
                        <textarea rows="3" name="principais_caracteristicas" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                        <textarea rows="3" name="areas_interesse" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>O que gosta de fazer no tempo livre?</label>
                        <textarea rows="3" name="atividades_livre" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>O que deixa o estudante muito feliz?</label>
                        <textarea rows="3" name="feliz" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>O que deixa o estudante muito triste ou desconfortável?</label>
                        <textarea rows="3" name="triste" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Objeto de apego? Qual?</label>
                        <textarea rows="3" name="objeto_apego" class="form-control"></textarea>
                    </div>
                </div>
                <div class="section-title">III - Comunicação</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Precisa de comunicação alternativa para expressar-se?</label>
                        <select name="precisa_comunicacao" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Entende instruções dadas de forma verbal?</label>
                        <select name="entende_instrucao" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Caso não, como você recomenda dar instruções?</label>
                        <textarea rows="3" name="recomenda_instrucao" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <!-- Etapa 4: Preferências -->
            <div class="step-content" data-step="4">
                <div class="section-title">IV - Preferências, sensibilidade e dificuldades</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Apresenta sensibilidade:</label>
                        <div class="checkbox-group">
                            <input type="checkbox" name="s_auditiva"><label for="s_auditiva">Auditiva</label>
                            <input type="checkbox" name="s_visual"><label for="s_visual">Visual</label>
                            <input type="checkbox" name="s_tatil"><label for="s_tatil">Tátil</label>
                            <input type="checkbox" name="s_outros"><label for="s_outros">Outros estímulos</label>
                        </div>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Caso sim, como manejar em sala de aula?</label>
                        <textarea rows="3" name="manejo_sensibilidade" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Apresenta seletividade alimentar?</label>
                        <select name="seletividade_alimentar" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Alimentos preferidos:</label>
                        <textarea rows="3" name="alimentos_preferidos" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Alimentos que evita:</label>
                        <textarea rows="3" name="alimentos_evita" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Com quem tem mais afinidade na escola (professores, colegas)? Identifique</label>
                        <textarea rows="3" name="afinidade_escola" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Como reage no contato com novas pessoas ou situações?</label>
                        <textarea rows="3" name="reacao_contato" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Etapa 5: Preferências (continuação) e Família -->
            <div class="step-content" data-step="5">
                <div class="section-title">IV - Preferências (Continuação)</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>O que ajuda a sua interação na escola? O que dificulta a sua interação na escola?</label>
                        <textarea rows="3" name="interacao_escola" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                        <textarea rows="3" name="interesse_atividade" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Como o(a) estudante aprende melhor?</label>
                        <div class="checkbox-group">
                            <input type="checkbox" name="r_visual"><label for="r_visual">Recurso visual</label>
                            <input type="checkbox" name="r_auditivo"><label for="r_auditivo">Recurso auditivo</label>
                            <input type="checkbox" name="m_concreto"><label for="m_concreto">Material concreto</label>
                            <input type="checkbox" name="o_outro"><label for="o_outro">Outro - identificar</label>
                        </div>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label></label>
                        <textarea rows="3" name="outro_identificar" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Gosta de atividades em grupo ou prefere trabalhar sozinho?</label>
                        <textarea rows="3" name="atividades_grupo" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Quais estratégias são utilizadas e se mostram eficazes?</label>
                        <textarea rows="3" name="estrategias_eficazes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>O que desperta seu interesse para realizar uma tarefa/atividade?</label>
                        <textarea rows="3" name="interesse_tarefa" class="form-control"></textarea>
                    </div>
                </div>
                <div class="section-title">V - Informações da família</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
                        <textarea rows="3" name="expectativas_familia" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Existe alguma estratégia utilizada no contexto familiar que pode ser reaplicada na escola?</label>
                        <textarea rows="3" name="estrategias_familia" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Como a família lida com situações de crise ou estresse do estudante?</label>
                        <textarea rows="3" name="crise_estresse" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Etapa 6: Cadastro de Profissionais -->
            <div class="step-content" data-step="6">
                <div class="section-title">Cadastro de Profissionais</div>
                <div style="margin-bottom: 15px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: #0d6efd;">
                                <th colspan="3" style="color: white; text-align: center; padding: 8px; font-weight: bold;">Profissionais que atendem o estudante</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="margin-top: 0;">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th width="33%" style="text-align: center; padding: 8px; font-weight: bold; border: 1px solid #dee2e6;">Nome do Profissional</th>
                                <th width="33%" style="text-align: center; padding: 8px; font-weight: bold; border: 1px solid #dee2e6;">Especialidade/Área</th>
                                <th width="33%" style="text-align: center; padding: 8px; font-weight: bold; border: 1px solid #dee2e6;">Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Linha 1 -->
                            <tr style="background-color: #e6f2ff;">
                                <td><input type="text" name="nome_profissional[]" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional[]" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional[]" class="form-control"></td>
                            </tr>
                            <!-- Linha 2 -->
                            <tr style="background-color: #e6f2ff;">
                                <td><input type="text" name="nome_profissional[]" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional[]" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional[]" class="form-control"></td>
                            </tr>
                            <!-- Linha 3 -->
                            <tr style="background-color: #e6f2ff;">
                                <td><input type="text" name="nome_profissional[]" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional[]" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional[]" class="form-control"></td>
                            </tr>
                            <!-- Linha 4 -->
                            <tr style="background-color: #e6f2ff;">
                                <td><input type="text" name="nome_profissional[]" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional[]" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional[]" class="form-control"></td>
                            </tr>
                            <!-- Linha 5 -->
                            <tr style="background-color: #e6f2ff;">
                                <td><input type="text" name="nome_profissional[]" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional[]" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional[]" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Navegação entre etapas -->
            <div class="step-navigation">
                <div class="navigation-group">
                    <button type="button" class="prev-btn" id="prevBtn" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button type="button" class="next-btn" id="nextBtn" style="display: none;">
                        <i class="fas fa-arrow-right"></i> Próximo
                    </button>
                </div>
                <div class="action-group">
                    <button type="button" class="finish-btn" id="finishBtn" style="display: none;">
                        <i class="fas fa-check"></i> Finalizar
                    </button>
                    <button type="button" class="btn btn-danger cancel-btn">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">

    <script>
    // Função para confirmar o envio do formulário
    function confirmSubmit(event) {
        // Se já foi confirmado, permite o envio
        if (document.getElementById('is_confirmed').value === '1') {
            return true;
        }
        
        // Impede o envio padrão do formulário
        event.preventDefault();
        event.stopPropagation();
        
        // Mostra confirmação
        if (confirm('Tem certeza que deseja finalizar e salvar os dados?')) {
            // Marca como confirmado e envia o formulário
            document.getElementById('is_confirmed').value = '1';
            document.getElementById('perfilForm').submit();
        }
        
        return false;
    }
    
    // Script para paginação
    // Função para inicializar o formulário
    function initializeForm() {
        const steps = document.querySelectorAll('.step-content');
        const tabs = document.querySelectorAll('.step-tab');
        const finishBtn = document.getElementById('finishBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentStep = 1;
        const totalSteps = steps.length;
        let visitedSteps = new Set([1]); // Rastreia as etapas visitadas
        
        // Atualiza a barra de progresso
        function updateProgressBar() {
            const percentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                progressBar.style.width = percentage + '%';
            }
        }
        
        // Mostra a etapa atual
        function showStep(stepNumber) {
            // Impede navegação direta para etapas não visitadas
            if (stepNumber > 1 && !visitedSteps.has(stepNumber - 1) && stepNumber !== currentStep) {
                alert('Por favor, preencha as etapas em ordem.');
                return false;
            }
            
            steps.forEach(step => step.classList.remove('active'));
            tabs.forEach(tab => tab.classList.remove('active'));
            
            document.querySelector(`.step-content[data-step="${stepNumber}"]`).classList.add('active');
            document.querySelector(`.step-tab[data-step="${stepNumber}"]`).classList.add('active');
            
            // Mantém a lógica original de visibilidade dos botões
            if (stepNumber === 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'block';
                if (finishBtn) finishBtn.style.display = 'none';
            } else if (stepNumber === totalSteps) {
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'none';
                if (finishBtn) finishBtn.style.display = 'block';
            } else {
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'block';
                if (finishBtn) finishBtn.style.display = 'none';
            }
            
            // Marca a etapa como visitada
            visitedSteps.add(stepNumber);
            
            // Atualiza a barra de progresso
            updateProgressBar();
            
            // Salvar o estado atual no armazenamento de sessão
            sessionStorage.setItem('currentStep', stepNumber);
            
            return true;
        }
        
        // Função para validar os campos da etapa atual
        function validateCurrentStep() {
            const currentStepElement = document.querySelector(`.step-content[data-step="${currentStep}"]`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            let isValid = true;
            
            // Verifica campos obrigatórios
            for (let i = 0; i < requiredFields.length; i++) {
                const field = requiredFields[i];
                if (!field.value.trim()) {
                    isValid = false;
                    // Rola até o primeiro campo inválido
                    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    break;
                }
            }
            
            if (!isValid) {
                alert('Por favor, preencha todos os campos obrigatórios antes de continuar.');
            }
            
            return isValid;
        }
        
        // Eventos para os botões de navegação
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentStep < totalSteps) {
                    // Valida os campos antes de avançar
                    if (validateCurrentStep()) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });
        }
        
        // Evento para o botão Finalizar
        if (finishBtn) {
            finishBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Verifica se todas as etapas foram visitadas
                if (visitedSteps.size < totalSteps) {
                    alert('Por favor, preencha todas as etapas antes de finalizar o cadastro.');
                    // Vai para a primeira etapa não visitada
                    for (let i = 1; i <= totalSteps; i++) {
                        if (!visitedSteps.has(i)) {
                            currentStep = i;
                            showStep(currentStep);
                            break;
                        }
                    }
                    return;
                }
                
                // Valida os campos da última etapa
                if (!validateCurrentStep()) {
                    return;
                }
                
                // Marca como confirmado e envia o formulário
                document.getElementById('is_confirmed').value = '1';
                document.getElementById('perfilForm').submit();
            });
        }
        
        // Evento para o botão Cancelar
        const cancelBtn = document.querySelector('.cancel-btn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Desabilita todos os botões para evitar múltiplos cliques
                const allButtons = document.querySelectorAll('button');
                allButtons.forEach(button => {
                    button.disabled = true;
                });
                
                // Redireciona para a página inicial
                window.location.href = '{{ route('index') }}';
            });
        }
        
        // Eventos para as abas
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const targetStep = parseInt(this.getAttribute('data-step'));
                
                // Se estiver tentando avançar para uma etapa não visitada, valida a atual primeiro
                if (targetStep > currentStep) {
                    if (!validateCurrentStep()) {
                        return;
                    }
                }
                
                currentStep = targetStep;
                showStep(currentStep);
            });
        });
        
        // Carrega o estado salvo
        const savedStep = sessionStorage.getItem('currentStep');
        showStep(savedStep ? parseInt(savedStep) : 1);
    }

    // Inicializa o formulário quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeForm);
    } else {
        initializeForm();
    }
    </script>
    

</body>
</html>