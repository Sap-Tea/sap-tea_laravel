<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Estudante</title>
    
    <!-- Importando CSS no Laravel -->
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
    
    <style>
        .container {
            position: relative;
        }

        /* Estilos para a tabela de profissionais */
        .profissionais-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }

        .profissional-row {
            display: flex;
            gap: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .profissional-row:nth-child(even) {
            background-color: #ffffff;
        }

        .profissional-row label {
            color: #333;
            font-weight: bold;
        }

        .profissional-row input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }

        .profissional-field {
            flex: 1;
            min-width: 200px;
        }

        .profissional-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .profissional-field input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        /* Estilos para a paginação em abas */
        .step-tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 5px;
            position: relative;
            z-index: 2; /* Acima de tudo */
        }
        
        .step-tab {
            padding: 10px 15px;
            background-color: #e0e0e0;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            min-width: 100px;
            margin-right: 5px;
        }
        
        .step-tab.active {
            background-color: #d35400;
            color: white;
        }
        
        /* Estilos para os conteúdos das etapas */
        .step-content {
            display: none;
            position: relative;
            z-index: 1; /* Na frente das imagens */
        }
        
        .step-content.active {
            display: block;
        }
        
        /* Botões de navegação */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            position: relative;
            z-index: 2; /* Acima de tudo */
        }
        
        .prev-btn, .next-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .prev-btn {
            background-color: #e0e0e0;
            color: #333;
        }
        
        .next-btn {
            background-color: #d35400;
            color: white;
        }
        
        .prev-btn:hover, .next-btn:hover {
            opacity: 0.8;
        }
        
        /* Barra de progresso */
        .progress-container {
            width: 100%;
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            margin: 20px 0;
            position: relative;
            z-index: 2; /* Acima de tudo */
        }
        
        .progress-bar {
            height: 8px;
            background: #d35400;
            border-radius: 4px;
            width: 0%;
            transition: width 0.3s;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="{{ route('atualiza.perfil.estudante', ['id' => isset($aluno) ? $aluno->alu_id : '']) }}" id="perfilForm" autocomplete="off">
    @method('POST')
    
            @csrf
            <input type="hidden" name="aluno_id" value="{{ isset($aluno) ? $aluno->alu_id : '' }}">

<!-- Exemplo de preenchimento automático para campos do aluno -->
<div class="form-group">
    <label for="alu_nome">Nome do Aluno</label>
    <input type="text" name="alu_nome" id="alu_nome" class="form-control" value="{{ isset($aluno) ? $aluno->alu_nome : '' }}" required>
</div>
<div class="form-group">
    <label for="alu_dtnasc">Data de Nascimento</label>
    <input type="date" name="alu_dtnasc" id="alu_dtnasc" class="form-control" value="{{ isset($aluno) ? $aluno->alu_dtnasc : '' }}">
</div>
<!-- Repita para outros campos do perfil, usando os dados disponíveis em $dados, $results, etc. -->
            
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
                <h2>I - Perfil do Estudante</h2>
                
                <div class="form-group">
                    <label>Nome do Aluno:</label>
                    <input type="text" name="nome_aluno" value="{{ $aluno->alu_nome }}" readonly>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <label>Ano/Série:</label>
                        <input type="text" value="{{ $aluno->desc_modalidade . ' - ' . $aluno->serie_desc }}" readonly>
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
    <option value="1" {{ (isset($results[0]->diag_laudo) && $results[0]->diag_laudo == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->diag_laudo) && $results[0]->diag_laudo == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <label>CID:</label>
                        <input type="text" name="cid" value="{{ isset($results[0]->cid) ? $results[0]->cid : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Médico:</label>
                        <input type="text" name="nome_medico" value="{{ isset($results[0]->nome_medico) ? $results[0]->nome_medico : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Data do Laudo:</label>
                        <input type="date" name="data_laudo" value="{{ isset($results[0]->data_laudo) ? $results[0]->data_laudo : '' }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Nível suporte</label>
                    <select name="nivel_suporte">
    <option value="1" {{ (isset($results[0]->nivel_suporte) && $results[0]->nivel_suporte == 1) ? 'selected' : '' }}>Nível 1 - Exige pouco apoio </option>
    <option value="2" {{ (isset($results[0]->nivel_suporte) && $results[0]->nivel_suporte == 2) ? 'selected' : '' }}>Nível 2 - Exige apoio substancial</option>
    <option value="3" {{ (isset($results[0]->nivel_suporte) && $results[0]->nivel_suporte == 3) ? 'selected' : '' }}>Nível 3 - Exige apoio muito substancial</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Faz uso de medicamento?</label>
                    <select name="uso_medicamento">
    <option value="1" {{ (isset($results[0]->uso_medicamento) && $results[0]->uso_medicamento == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->uso_medicamento) && $results[0]->uso_medicamento == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Quais?</label>
                    <input type="text" name="quais_medicamento" value="{{ isset($results[0]->quais_medicamento) ? $results[0]->quais_medicamento : '' }}">
                </div>
            </div>
            
            <!-- Etapa 2: Mais Dados Pessoais -->
            <div class="step-content" data-step="2">
                <h2>I - Perfil do Estudante (Continuação)</h2>
                
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
                        <input type="checkbox" name="locomocao" {{ (isset($results[0]->locomocao) && $results[0]->locomocao == 1) ? 'checked' : '' }}><label for="locomocao">Locomoção</label>
                        <input type="checkbox" name="higiene" {{ (isset($results[0]->higiene) && $results[0]->higiene == 1) ? 'checked' : '' }}><label for="higiene">Higiene</label>
                        <input type="checkbox" name="alimentacao" {{ (isset($results[0]->alimentacao) && $results[0]->alimentacao == 1) ? 'checked' : '' }}><label for="alimentacao">Alimentação</label>
                        <input type="checkbox" name="comunicacao" {{ (isset($results[0]->comunicacao) && $results[0]->comunicacao == 1) ? 'checked' : '' }}><label for="comunicacao">Comunicação</label>
                        <input type="checkbox" name="outros" {{ (isset($results[0]->outros) && $results[0]->outros == 1) ? 'checked' : '' }}><label for="outros">Outros momentos</label>
                    </div>
                    <input type="text" name="out_momentos" placeholder="Quais?">
                </div>
                
                <div class="form-group">
                    <label>O estudante conta com Atendimento Educacional Especializado?</label>
                    <select name="at_especializado">
    <option value="1" {{ (isset($results[0]->at_especializado) && $results[0]->at_especializado == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->at_especializado) && $results[0]->at_especializado == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Nome do profissional do AEE:</label>
                    <input type="text" name="nome_prof_AEE" value="{{ isset($results[0]->nome_prof_AEE) ? $results[0]->nome_prof_AEE : '' }}">
                </div>
                
                <h2>II - Personalidade</h2>
                
                <div class="form-group">
                    <label>Principais características:</label>
                    <textarea rows="3" name="caracteristicas">{{ isset($results[0]->caracteristicas) ? $results[0]->caracteristicas : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                    <textarea rows="3" name="areas_interesse">{{ isset($results[0]->areas_interesse) ? $results[0]->areas_interesse : '' }}</textarea>
                </div>
            </div>
            
            <!-- Etapa 3: Personalidade e Comunicação -->
            <div class="step-content" data-step="3">
                <h2>II - Personalidade (Continuação)</h2>
                
                <div class="form-group">
                    <label>Gosta de fazer no tempo livre:</label>
                    <textarea rows="3" name="atividades_livre">{{ isset($results[0]->livre_gosta_fazer) ? $results[0]->livre_gosta_fazer : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Deixa o estudante muito feliz:</label>
                    <textarea rows="3" name="feliz">{{ isset($results[0]->feliz_est) ? $results[0]->feliz_est : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Deixa o estudante muito triste ou desconfortável:</label>
                    <textarea rows="3" name="triste">{{ isset($results[0]->trist_est) ? $results[0]->trist_est : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Objeto de apego? Qual?</label>
                    <textarea rows="3" name="objeto_apego">{{ isset($results[0]->obj_apego) ? $results[0]->obj_apego : '' }}</textarea>
                </div>
                
                <h2 class="comunicacao-section">III - Comunicação</h2>
                
                <div class="form-group">
                    <label>Precisa de comunicação alternativa para expressar-se?</label>
                    <select name="precisa_comunicacao">
    <option value="1" {{ (isset($results[0]->precisa_comunicacao) && $results[0]->precisa_comunicacao == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->precisa_comunicacao) && $results[0]->precisa_comunicacao == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Entende instruções dadas de forma verbal?</label>
                    <select name="entende_instrucao">
    <option value="1" {{ (isset($results[0]->entende_instrucao) && $results[0]->entende_instrucao == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->entende_instrucao) && $results[0]->entende_instrucao == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Caso não, como você recomenda dar instruções?</label>
                    <textarea rows="3" name="recomenda_instrucao">{{ isset($results[0]->recomenda_instrucao) ? $results[0]->recomenda_instrucao : '' }}</textarea>
                </div>
            </div>
            
            <!-- Etapa 4: Preferências -->
            <div class="step-content" data-step="4">
                <h2>IV - Preferências, sensibilidade e dificuldades</h2>
                
                <div class="form-group">
                    <label>Apresenta sensibilidade:</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="s_auditiva" {{ (isset($results[0]->auditivo_04) && $results[0]->auditivo_04 == 1) ? 'checked' : '' }}><label for="s_auditiva">Auditiva</label>
                        <input type="checkbox" name="s_visual" {{ (isset($results[0]->visual_04) && $results[0]->visual_04 == 1) ? 'checked' : '' }}><label for="s_visual">Visual</label>
                        <input type="checkbox" name="s_tatil" {{ (isset($results[0]->tatil_04) && $results[0]->tatil_04 == 1) ? 'checked' : '' }}><label for="s_tatil">Tátil</label>
                        <input type="checkbox" name="s_outros" {{ (isset($results[0]->outros_04) && $results[0]->outros_04 == 1) ? 'checked' : '' }}><label for="s_outros">Outros estímulos</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Caso sim, como manejar em sala de aula</label>
                    <textarea rows="3" name="manejo_sensibilidade">{{ isset($results[0]->maneja_04) ? $results[0]->maneja_04 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Apresenta seletividade alimentar?</label>
                    <select name="seletividade_alimentar">
    <option value="1" {{ (isset($results[0]->asa_04) && $results[0]->asa_04 == 1) ? 'selected' : '' }}>Sim</option>
    <option value="0" {{ (isset($results[0]->asa_04) && $results[0]->asa_04 == 0) ? 'selected' : '' }}>Não</option>
</select>
                </div>
                
                <div class="form-group">
                    <label>Alimentos preferidos:</label>
                    <textarea rows="3" name="alimentos_preferidos">{{ isset($results[0]->alimentos_pref_04) ? $results[0]->alimentos_pref_04 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Alimentos que evita:</label>
                    <textarea rows="3" name="alimentos_evita">{{ isset($results[0]->alimentos_evita_04) ? $results[0]->alimentos_evita_04 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Com quem tem mais afinidade na escola (professores, colegas)? Identifique</label>
                    <textarea rows="3" name="afinidade_escola">{{ isset($results[0]->afinidade_escola_04) ? $results[0]->afinidade_escola_04 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Como reage no contato com novas pessoas ou situações</label>
                    <textarea rows="3" name="reacao_contato">{{ isset($results[0]->reacao_contato_04) ? $results[0]->reacao_contato_04 : '' }}</textarea>
                </div>
            </div>
            
            <!-- Etapa 5: Preferências (continuação) e Família -->
            <div class="step-content" data-step="5">
                <h2>IV - Preferências (Continuação)</h2>
                
                <div class="form-group">
                    <label>O que ajuda a sua interação na escola e o que dificulta a sua interação na escola?</label>
                    <textarea rows="3" name="interacao_escola">{{ isset($results[0]->interacao_escola_05) ? $results[0]->interacao_escola_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                    <textarea rows="3" name="interesse_atividade">{{ isset($results[0]->interesse_atividade_05) ? $results[0]->interesse_atividade_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Como o(a) estudante aprende melhor?</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="r_visual" {{ (isset($results[0]->recurso_visual_05) && $results[0]->recurso_visual_05 == 1) ? 'checked' : '' }}><label for="r_visual">Recurso visual</label>
                        <input type="checkbox" name="r_auditivo" {{ (isset($results[0]->recurso_auditivo_05) && $results[0]->recurso_auditivo_05 == 1) ? 'checked' : '' }}><label for="r_auditivo">Recurso auditivo</label>
                        <input type="checkbox" name="m_concreto" {{ (isset($results[0]->material_concreto_05) && $results[0]->material_concreto_05 == 1) ? 'checked' : '' }}><label for="m_concreto">Material concreto</label>
                        <input type="checkbox" name="o_outro" {{ (isset($results[0]->outro_identificar_05) && $results[0]->outro_identificar_05 == 1) ? 'checked' : '' }}><label for="o_outro">Outro - identificar</label>
                    </div>
                    
                    <div class="form-group">
                        <label></label>
                        <textarea rows="3" name="outro_identificar">{{ isset($results[0]->outro_identificar_text_05) ? $results[0]->outro_identificar_text_05 : '' }}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Gosta de atividades em grupo ou prefere trabalhar sozinho?</label>
                    <textarea rows="3" name="atividades_grupo">{{ isset($results[0]->atividades_grupo_05) ? $results[0]->atividades_grupo_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Quais estratégias são utilizadas e se mostram eficazes?</label>
                    <textarea rows="3" name="estrategias_eficazes">{{ isset($results[0]->estrategias_eficazes_05) ? $results[0]->estrategias_eficazes_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>O que desperta seu interesse para realizar uma tarefa/atividade</label>
                    <textarea rows="3" name="interesse_tarefa">{{ isset($results[0]->interesse_tarefa_05) ? $results[0]->interesse_tarefa_05 : '' }}</textarea>
                </div>
                
                <h2 class="comunicacao-section">V - Informações da família</h2>
                
                <div class="form-group">
                    <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
                    <textarea rows="3" name="expectativas_familia">{{ isset($results[0]->expectativas_familia_05) ? $results[0]->expectativas_familia_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Existe alguma estratégia utilizada no contexto familiar que pode ser reaplicada na escola?</label>
                    <textarea rows="3" name="estrategias_familia">{{ isset($results[0]->estrategias_familia_05) ? $results[0]->estrategias_familia_05 : '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Como a família lida com situações de crise ou estresse do estudante?</label>
                    <textarea rows="3" name="crise_estresse">{{ isset($results[0]->crise_estresse_05) ? $results[0]->crise_estresse_05 : '' }}</textarea>
                </div>
            </div>

            <!-- Etapa 6: Cadastro de Profissionais -->
            <div class="step-content" data-step="6">
                <h2>Cadastro de Profissionais</h2>
                <div class="profissionais-container">
                    <div class="profissional-row">
                        <div class="profissional-field">
                            <label>Nome do Profissional</label>
                            <input type="text" placeholder="Nome do Profissional">
                        </div>
                        <div class="profissional-field">
                            <label>Especialidade/Área</label>
                            <input type="text" placeholder="Especialidade/Área">
                        </div>
                        <div class="profissional-field">
                            <label>Observações</label>
                            <input type="text" placeholder="Observações">
                        </div>
                    </div>
                    <div class="profissional-row">
                        <div class="profissional-field">
                            <label>Nome do Profissional</label>
                            <input type="text" placeholder="Nome do Profissional">
                        </div>
                        <div class="profissional-field">
                            <label>Especialidade/Área</label>
                            <input type="text" placeholder="Especialidade/Área">
                        </div>
                        <div class="profissional-field">
                            <label>Observações</label>
                            <input type="text" placeholder="Observações">
                        </div>
                    </div>
                    <div class="profissional-row">
                        <div class="profissional-field">
                            <label>Nome do Profissional</label>
                            <input type="text" placeholder="Nome do Profissional">
                        </div>
                        <div class="profissional-field">
                            <label>Especialidade/Área</label>
                            <input type="text" placeholder="Especialidade/Área">
                        </div>
                        <div class="profissional-field">
                            <label>Observações</label>
                            <input type="text" placeholder="Observações">
                        </div>
                    </div>
                    <div class="profissional-row">
                        <div class="profissional-field">
                            <label>Nome do Profissional</label>
                            <input type="text" placeholder="Nome do Profissional">
                        </div>
                        <div class="profissional-field">
                            <label>Especialidade/Área</label>
                            <input type="text" placeholder="Especialidade/Área">
                        </div>
                        <div class="profissional-field">
                            <label>Observações</label>
                            <input type="text" placeholder="Observações">
                        </div>
                    </div>
                    <div class="profissional-row">
                        <div class="profissional-field">
                            <label>Nome do Profissional</label>
                            <input type="text" placeholder="Nome do Profissional">
                        </div>
                        <div class="profissional-field">
                            <label>Especialidade/Área</label>
                            <input type="text" placeholder="Especialidade/Área">
                        </div>
                        <div class="profissional-field">
                            <label>Observações</label>
                            <input type="text" placeholder="Observações">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Navegação entre etapas -->
<div class="step-navigation">
    <div class="navigation-group">
        <button type="button" class="prev-btn" id="prevBtn" style="display: none;">
            <i class="fas fa-arrow-left"></i> Anterior
        </button>
        <button type="button" class="next-btn" id="nextBtn">
            Próximo <i class="fas fa-arrow-right"></i>
        </button>
        <button id="finishBtn" class="btn btn-primary finish-btn" style="display: none;">Finalizar</button>
    </div>
</div>

    <style>
        .btn { padding: 10px 22px; border-radius: 6px; border: none; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        .btn-primary { background: #204080; color: #fff; }
        .btn-primary:hover { background: #163060; }
        .btn-secondary { background: #eee; color: #204080; }
        .btn-secondary:hover { background: #ccc; }
        .btn-success { background: #28a745; color: #fff; }
        .btn-success:hover { background: #218838; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-danger:hover { background: #b52a37; }
        .step-navigation {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            background-color: #f8f9fa;
            gap: 20px;
        }
        .navigation-group, .action-group {
            display: flex;
            gap: 10px;
        }
        .prev-btn, .next-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #6c757d;
            color: white;
        }
        .prev-btn:hover, .next-btn:hover {
            background-color: #5a6268;
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .prev-btn i, .next-btn i {
            margin: 0 5px;
        }
        .finish-btn, .btn-danger {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .finish-btn {
            background-color: #4CAF50;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .finish-btn:disabled {
            background-color: #ff9800 !important;
            color: #fff !important;
            cursor: not-allowed;
        }
        .finish-btn:hover {
            background-color: #45a049;
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .finish-btn i {
            margin: 0 5px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .btn-danger i {
            margin: 0 5px;
        }
    </style>
    
    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script>
    // Script para paginação
    // Função para inicializar o formulário
    function initializeForm() {
        // Garante que todos os botões de navegação são type="button"
        document.querySelectorAll('.prev-btn, .next-btn, .finish-btn, .cancel-btn').forEach(btn => {
            btn.setAttribute('type', 'button');
        });
        const steps = document.querySelectorAll('.step-content');
        const tabs = document.querySelectorAll('.step-tab');
        const finishBtn = document.getElementById('finishBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentStep = 1;
        const totalSteps = steps.length;
        
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
            currentStep = stepNumber;
            steps.forEach(step => step.classList.remove('active'));
            tabs.forEach(tab => tab.classList.remove('active'));
            
            document.querySelector(`.step-content[data-step="${stepNumber}"]`).classList.add('active');
            document.querySelector(`.step-tab[data-step="${stepNumber}"]`).classList.add('active');
            
            // Atualiza a visibilidade dos botões
            if (stepNumber === 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'block';
                finishBtn.style.display = 'none';
            } else if (stepNumber === totalSteps) {
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'none';
                finishBtn.style.display = 'block';
            } else {
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'block';
                finishBtn.style.display = 'none';
            }
            
            // Atualiza a barra de progresso
            updateProgressBar();
            
            // Salvar o estado atual no armazenamento de sessão
            sessionStorage.setItem('currentStep', stepNumber);
        }
        
        // Eventos para os botões de navegação
        if (prevBtn) {
            prevBtn.onclick = function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            };
        }
        if (nextBtn) {
            nextBtn.onclick = function() {
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                }
            };
        }
        // Evento para o botão Finalizar
        if (finishBtn) {
            finishBtn.disabled = false;
            finishBtn.onclick = function(e) {
                e.preventDefault();
                // Busca nome do aluno e data atual formatada
                const nomeAluno = document.querySelector('input[name="nome_aluno"]')?.value || '';
                const dataAtual = new Date();
                const dataFormatada = dataAtual.toLocaleDateString('pt-BR');
                const mensagem = `Deseja realmente salvar o perfil do aluno: "${nomeAluno}" na data: ${dataFormatada}?`;
                if (!confirm(mensagem)) {
                    return;
                }
                // Desabilita o botão de finalizar para evitar múltiplos envios
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-check"></i> Cadastro de perfil já efetuado!';
                this.style.setProperty('background-color', '#ff9800', 'important');
                this.style.setProperty('color', '#fff', 'important');
                this.style.setProperty('border-color', '#ff9800', 'important');
                this.style.setProperty('cursor', 'not-allowed', 'important');
                // Envia o formulário
                document.getElementById('perfilForm').submit();
            };
        }
        // Impede submit por Enter ou submit automático em todo o form (só permite via botão finalizar)
        const form = document.getElementById('perfilForm');
        if (form) {
            form.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    return false;
                }
            });
        }
        // Evento para o botão Cancelar
        const cancelBtn = document.querySelector('.cancel-btn');
        if (cancelBtn) {
            cancelBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                // Desabilita todos os botões para evitar múltiplos cliques
                const allButtons = document.querySelectorAll('button');
                allButtons.forEach(button => {
                    button.disabled = true;
                });
                // Redireciona para a página inicial
                window.location.href = '{{ route('index') }}';
            };
        }
        // Eventos para as abas
        tabs.forEach(tab => {
            tab.onclick = function() {
                showStep(parseInt(this.getAttribute('data-step')));
            };
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