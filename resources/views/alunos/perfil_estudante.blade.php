@extends('index')

@section('content')
    <style>
    .form-section {
        border: 3px solid #d1d5db; /* Borda mais grossa */
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 100%;
    }
    .section-title {
        background-color: #f8f9fa;
        padding: 10px 15px;
        margin: 0 -20px 20px -20px;
        border-left: 4px solid #007bff;
        font-weight: 600;
        color: #333;
    }
    .form-group {
        margin-bottom: 1.2rem;
    }
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 10px 0;
    }
    .checkbox-group label {
        margin-left: 5px;
        font-weight: normal;
    }
</style>

<div class="container" style="max-width: 1200px; width: 95%; margin: 30px auto; padding: 0 15px;">
        <div class="alert alert-info" style="background-color: #e7f4ff; border-left: 4px solid #007bff; color: #0056b3; padding: 15px; margin-bottom: 25px; border-radius: 4px;">
            <p style="margin: 0; font-size: 1.15em; line-height: 1.7; font-weight: 500;">
                Este documento deve ser atualizado regularmente, considerando os progressos e novas demandas. Os dados
                devem ser tratados de forma confidencial e utilizados exclusivamente para o planejamento de ações que
                promovam a inclusão e o desenvolvimento dos estudantes.
            </p>
        </div>
        
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
            <div class="step-tabs" style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-bottom:18px;">
                <button class="step-tab active" data-step="1" style="min-width:120px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">Dados Pessoais</button>
                <button class="step-tab" data-step="2" style="min-width:180px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">I - Perfil do Estudante</button>
                <button class="step-tab" data-step="3" style="min-width:180px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">II - Personalidade</button>
                <button class="step-tab" data-step="4" style="min-width:180px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">III - Comunicação</button>
                <button class="step-tab" data-step="5" style="min-width:280px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">IV - Preferências e Dificuldades</button>
                <button class="step-tab" data-step="6" style="min-width:220px;height:36px;font-size:1em;padding:0 18px;display:flex;align-items:center;">V - Informações da Família</button>
            </div>

            
            <!-- Etapa 1: Dados Pessoais -->
            <div class="step-content form-section active" data-step="1">
                <div class="section-title">Dados Pessoais do estudante</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Nome do estudante:</label>
                        <input type="text" name="nome_aluno" value="{{ $aluno->alu_nome }}" readonly class="form-control" style="min-width:300px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-3">
                        <label>RA do estudante:</label>
                        <input type="text" name="ra_aluno" value="{{ $aluno->alu_ra }}" readonly class="form-control" style="min-width:200px;max-width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>Data de Nascimento:</label>
                        <input type="text" name="alu_dtnasc_display" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->format('d/m/Y') }}" readonly class="form-control"style="min-width:150px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Idade:</label>
                        <input type="text" name="alu_idade_display" value="{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age." Anos" }}" readonly class="form-control" style="min-width:150px;max-width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Escola:</label>
                        <input type="text" name="escola_nome" value="{{ $aluno->esc_razao_social ?? '' }}" readonly class="form-control" style="min-width:450px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Órgão:</label>
                        <input type="text" name="orgao_nome" value="{{ $aluno->org_razaosocial ?? '' }}" readonly class="form-control" style="min-width:450px;max-width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    
                    <div class="form-group col-md-3">
                        <label>Turma:</label>
                        <input type="text" name="turma" value="{{ $aluno->fk_cod_valor_turma ?? '' }}" readonly class="form-control" style="min-width:200px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Seguimento:</label>
                        <input type="text" name="modalidade" value="{{ $aluno->desc_modalidade ?? '' }}" readonly class="form-control" style="min-width:250px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Série:</label>
                        <input type="text" name="serie" value="{{ $aluno->serie_desc ?? '-' }}" readonly class="form-control" style="min-width:150px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Período:</label>
                        <input type="text" name="periodo" value="{{ $aluno->periodo ?? '-' }}" readonly class="form-control" style="min-width:150px;max-width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-12">
                        <label>Nome do Professor:</label>
                        <input type="text" name="nome_professor" value="{{ $aluno->func_nome ?? '' }}" readonly class="form-control" style="min-width:300px;max-width:100%;">
                    </div>
                </div>
                <div class="section-title" style="background-color: #ff8c00; margin-top: 15px;">DADOS DO RESPONSÁVEL</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-8">
                        <label>Nome do Responsável:</label>
                        <input type="text" name="nome_responsavel" value="{{ $aluno->alu_nome_resp ?? '' }}" readonly class="form-control" style="min-width:300px;max-width:100%;">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tipo de Parentesco:</label>
                        <input type="text" name="tipo_parentesco" value="{{ $aluno->alu_tipo_parentesco ?? '' }}" readonly class="form-control" style="min-width:250px;max-width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Telefone:</label>
                        <input type="text" name="telefone_responsavel" value="{{ $aluno->alu_tel_resp ?? '' }}" readonly class="form-control" style="min-width:200px;max-width:150%;">
                    </div>
                    <div class="form-group col-md-6">
                        <label>E-mail:</label>
                        <input type="text" name="email_responsavel" value="{{ $aluno->alu_email_resp ?? '' }}" readonly class="form-control" style="min-width:300px;max-width:100%;">
                    </div>
                </div>
            </div>
            
            <!-- Etapa 2: Mais Dados Pessoais -->
            <div class="step-content form-section" data-step="2">
                <div class="section-title">Perfil do Estudante</div>
                <!-- Diagnóstico/Laudo -->
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>Possui diagnóstico/laudo?</label>
                        <select name="diag_laudo" class="form-control" >
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Data do Laudo</label>
                        <input type="date" name="data_laudo" class="form-control" style="min-width:200px;width:100%;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-4">
                        <label>CID</label>
                        <input type="text" name="cid" class="form-control" style="min-width:350px;width:100%;">
                    </div>
                    <div class="form-group col-12">
                        <label>Médico</label>
                        <input type="text" name="nome_medico" class="form-control" style="width:100%;min-width:350px;">
                    </div>
                </div>
                <div class="row custom-row-gap align-items-end">
                     <div class="form-group col-md-4">
                        <label>Nível Suporte</label>
                        <select name="nivel_suporte" class="form-control" style="min-width:350px;width:100%;">
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
                        <select name="uso_medicamento" class="form-control" style="width:150px;max-width:100%;">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label>Quais?</label>
                        <input type="text" name="quais_medicamento" class="form-control" style="width:100%;min-width:350px;">
                    </div>
                </div>

                <!-- Apoio e AEE -->
                <div class="section-title" style="margin-top: 25px;">Apoio e AEE</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Necessita de profissional de apoio em sala?</label>
                        <select name="nec_pro_apoio" class="form-control" style="width:150px;max-width:100%;">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>O estudante conta com profissional de apoio?</label>
                        <select name="conta_pro_apoio" class="form-control" style="width:150px;max-width:100%;">
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
                    <input type="text" name="outros_momentos_apoio" placeholder="Quais outros momentos?" class="form-control" style="width:100%;min-width:500px;margin-top: 5px;">
                </div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>O estudante conta com Atendimento Educacional Especializado (AEE)?</label>
                        <select name="at_especializado" class="form-control" style="width:150px;max-width:100%;">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nome do profissional do AEE:</label>
                        <input type="text" name="nome_prof_AEE" class="form-control" style="width:100%;min-width:500px;">
                    </div>
                </div>


            </div>
            
            <!-- Etapa 3: Personalidade -->
            <div class="step-content form-section" data-step="3" style="border: 1px solid #ddd; padding: 20px; border-radius: 10px;">
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
            </div>

            <!-- Etapa 4: III - Comunicação -->
            <div class="step-content form-section" data-step="4">
                <div class="section-title">III - Comunicação</div>
                <div class="row custom-row-gap align-items-end">
                    <div class="form-group col-md-6">
                        <label>Precisa de comunicação alternativa para expressar-se?</label>
                        <select name="precisa_comunicacao" class="form-control" style="width:150px;max-width:100%;">
                            <option value="">Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Entende instruções dadas de forma verbal?</label>
                        <select name="entende_instrucao" class="form-control" style="width:150px;max-width:100%;">
                            <option value="">Selecione</option>
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

            <!-- Etapa 5: Preferências, sensibilidade e dificuldades -->
            <div class="step-content form-section" data-step="5">
                <div class="section-title">IV - Preferências, sensibilidade e dificuldades</div>
                <div class="form-group">
                    <label>Apresenta sensibilidade:</label>
                    <div class="checkbox-group" style="display: flex; gap: 15px; margin-top: 5px;">
                        <label style="font-weight: normal;"><input type="checkbox" name="sensibilidade[]" value="auditiva"> Auditiva</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="sensibilidade[]" value="visual"> Visual</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="sensibilidade[]" value="tatil"> Tátil</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="sensibilidade[]" value="outros"> Outros estímulos</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Caso sim, como manejar em sala de aula:</label>
                    <textarea rows="3" name="manejo_sensibilidade" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Apresenta seletividade alimentar?</label>
                    <select name="seletividade_alimentar" class="form-control" style="width:150px;max-width:100%;">
                        <option value="">Selecione</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alimentos preferidos:</label>
                    <textarea rows="3" name="alimentos_preferidos" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Alimentos que evita:</label>
                    <textarea rows="3" name="alimentos_evita" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Com quem tem mais afinidade na escola (professores, colegas)? Identifique</label>
                    <textarea rows="3" name="afinidade_escola" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Como reage no contato com novas pessoas ou situações?</label>
                    <textarea rows="3" name="reage_contato" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>O que ajuda a sua interação na escola e o que dificulta a sua interação na escola?</label>
                    <textarea rows="3" name="ajuda_dificulta_interacao" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Há interesses específicos ou hiperfoco em algum tema ou atividade?</label>
                    <textarea rows="3" name="interesses_especificos" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Como o(a) estudante aprende melhor?</label>
                    <div class="checkbox-group" style="display: flex; gap: 15px; margin-top: 5px;">
                        <label style="font-weight: normal;"><input type="checkbox" name="como_aprende_melhor[]" value="visual"> Recurso visual</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="como_aprende_melhor[]" value="auditivo"> Recurso auditivo</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="como_aprende_melhor[]" value="concreto"> Material concreto</label>
                        <label style="font-weight: normal;"><input type="checkbox" name="como_aprende_melhor[]" value="outro"> Outro</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Gosta de atividades em grupo ou prefere trabalhar sozinho?</label>
                    <textarea rows="3" name="gosta_grupo_sozinho" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Quais estratégias são utilizadas e se mostram eficazes?</label>
                    <textarea rows="3" name="estrategias_eficazes" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>O que desperta seu interesse para realizar uma tarefa/atividade?</label>
                    <textarea rows="3" name="interesse_tarefa" class="form-control"></textarea>
                </div>
            </div>

            <!-- Etapa 6: V - Informações da Família e Profissionais -->
            <div class="step-content form-section" data-step="6">
                <div class="section-title">V - Informações da família</div>
                <div class="form-group">
                    <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
                    <textarea rows="3" name="expectativas_familia" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Existe alguma estratégia utilizada no contexto familiar que pode ser replicada na escola?</label>
                    <textarea rows="3" name="estrategia_familiar" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Como a família lida com situações de crise ou estresse do estudante?</label>
                    <textarea rows="3" name="familia_crise_estresse" class="form-control"></textarea>
                </div>

                <div class="section-title" style="margin-top: 30px; margin-bottom: 15px;">Cadastro de Profissionais</div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: #e9ecef;">
                                <th style="text-align: center;">Nome do Profissional</th>
                                <th style="text-align: center;">Especialidade/Área</th>
                                <th style="text-align: center;">Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="nome_profissional_01" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional_01" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional_01" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="nome_profissional_02" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional_02" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional_02" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="nome_profissional_03" class="form-control"></td>
                                <td><input type="text" name="especialidade_profissional_03" class="form-control"></td>
                                <td><input type="text" name="observacoes_profissional_03" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="form-buttons mt-3 text-center">
                    <button type="submit" class="btn btn-success">Confirmar Alteração</button>
                    <a href="#" class="btn btn-info">Gerar PDF</a>
                </div>
            </div>

                        </tbody>
                    </table>
            <!-- Navegação entre etapas -->
            <div class="step-navigation" style="margin-top: 30px;">
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
    document.addEventListener('DOMContentLoaded', function() {
        const stepTabs = document.querySelectorAll('.step-tab');
        const stepContents = document.querySelectorAll('.step-content');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const progressBar = document.getElementById('progressBar');
        let currentStep = 1;
        const totalSteps = stepContents.length;

        function updateProgressBar() {
            const progress = totalSteps > 1 ? ((currentStep - 1) / (totalSteps - 1)) * 100 : 0;
            progressBar.style.width = progress + '%';
        }

        function showStep(step) {
            stepContents.forEach(content => {
                content.classList.remove('active');
            });
            document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

            stepTabs.forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`.step-tab[data-step="${step}"]`).classList.add('active');

            prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
            nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';

            currentStep = step;
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
        
        // Sempre inicia na primeira etapa ao carregar a página
        showStep(1);
    }

    // Inicializa o formulário quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeForm);
    } else {
        initializeForm();
    }
    </script>
    

@endsection