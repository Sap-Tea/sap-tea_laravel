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
        <form method="POST" action="{{ route('inserir_perfil') }}" id="perfilForm">
            @csrf
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
                <h2>I - Perfil do Estudante</h2>
                
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
                        <input type="checkbox" name="locomocao"><label for="locomocao">Locomoção</label>
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
                
                <h2>II - Personalidade</h2>
                
                <div class="form-group">
                    <label>Principais características:</label>
                    <textarea rows="3" name="caracteristicas"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                    <textarea rows="3" name="areas_interesse"></textarea>
                </div>
            </div>
            
            <!-- Etapa 3: Personalidade e Comunicação -->
            <div class="step-content" data-step="3">
                <h2>II - Personalidade (Continuação)</h2>
                
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
                    <label>Entende instruções dadas de forma verbal?</label>
                    <select name="entende_instrucao">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Caso não, como você recomenda dar instruções?</label>
                    <textarea rows="3" name="recomenda_instrucao"></textarea>
                </div>
            </div>
            
            <!-- Etapa 4: Preferências -->
            <div class="step-content" data-step="4">
                <h2>IV - Preferências, sensibilidade e dificuldades</h2>
                
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
                    <label>Caso sim, como manejar em sala de aula</label>
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
            </div>
            
            <!-- Etapa 5: Preferências (continuação) e Família -->
            <div class="step-content" data-step="5">
                <h2>IV - Preferências (Continuação)</h2>
                
                <div class="form-group">
                    <label>O que ajuda a sua interação na escola e o que dificulta a sua interação na escola?</label>
                    <textarea rows="3" name="interacao_escola"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                    <textarea rows="3" name="interesse_atividade"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Como o(a) estudante aprende melhor?</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="r_visual"><label for="r_visual">Recurso visual</label>
                        <input type="checkbox" name="r_auditivo"><label for="r_auditivo">Recurso auditivo</label>
                        <input type="checkbox" name="m_concreto"><label for="m_concreto">Material concreto</label>
                        <input type="checkbox" name="o_outro"><label for="o_outro">Outro - identificar</label>
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
                    <label>Como a família lida com situações de crise ou estresse do estudante?</label>
                    <textarea rows="3" name="crise_estresse"></textarea>
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

    <style>
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
            steps.forEach(step => step.classList.remove('active'));
            tabs.forEach(tab => tab.classList.remove('active'));
            
            document.querySelector(`.step-content[data-step="${stepNumber}"]`).classList.add('active');
            document.querySelector(`.step-tab[data-step="${stepNumber}"]`).classList.add('active');
            
            // Atualiza a visibilidade dos botões
            if (stepNumber === 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'block';
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
                    currentStep++;
                    showStep(currentStep);
                }
            });
        }
        
        // Evento para o botão Finalizar
        if (finishBtn) {
            finishBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Mensagem de confirmação
                if (!confirm('Tem certeza que deseja finalizar e salvar os dados?')) {
                    return;
                }
                
                // Desabilita o botão de finalizar para evitar múltiplos envios
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
                
                // Envia o formulário
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
            tab.addEventListener('click', function() {
                currentStep = parseInt(this.getAttribute('data-step'));
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