@extends('index')

@section('content')
<style>
    label {
        font-size: 0.9rem;
        font-weight: 500;
    }
    .form-control {
        font-size: 0.9rem;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    .form-section {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 30px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
    .readonly-value {
        padding: 8px 12px;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        min-height: 38px;
        display: flex;
        align-items: center;
    }
    .mode-toggle {
        position: fixed;
        top: 70px;
        right: 20px;
        z-index: 1000;
    }
    .btn-mode {
        padding: 8px 15px;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-edit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    .btn-save {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }
    .btn-cancel {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
        margin-right: 10px;
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
    
    <!-- Botões de modo -->
    <div class="mode-toggle">
        @if($modo == 'visualizar')
            <a href="{{ route('editar.perfil', ['id' => $aluno->alu_id]) }}" class="btn btn-mode btn-edit">
                <i class="fas fa-edit"></i> Editar Perfil
            </a>
        @elseif($modo == 'editar')
            <button type="submit" form="perfilForm" class="btn btn-mode btn-save">
                <i class="fas fa-save"></i> Salvar Alterações
            </button>
            <a href="{{ route('imprime_aluno') }}" class="btn btn-mode btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
        @endif
    </div>
    
    @if($modo == 'editar')
        <form method="POST" action="{{ route('atualiza.perfil.estudante', $aluno->alu_id) }}" id="perfilForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="is_confirmed" id="is_confirmed" value="0">
            <input type="hidden" name="fk_id_aluno" id="aluno_id_hidden" value="{{$aluno->alu_id }}">
    @endif
    
    <h2>Perfil do Estudante</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Barra de progresso -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    
    <!-- Abas de etapas -->
    <div class="step-tabs" style="display:flex;flex-wrap:nowrap;gap:3px;justify-content:flex-start;margin-bottom:18px;overflow-x:auto;">
        <button type="button" class="step-tab active" data-step="1" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">Dados Pessoais</button>
        <button type="button" class="step-tab" data-step="2" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">I - Perfil do Estudante</button>
        <button type="button" class="step-tab" data-step="3" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">II - Personalidade</button>
        <button type="button" class="step-tab" data-step="4" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">III - Comunicação</button>
        <button type="button" class="step-tab" data-step="5" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">IV - Preferências</button>
        <button type="button" class="step-tab" data-step="6" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">V - Informações da Família</button>
        <button type="button" class="step-tab" data-step="7" style="height: 42px; font-size: 0.8em; padding: 4px 4px; min-width:90px; white-space: normal; line-height: 1.1; text-align: center;">Cadastro de Profissionais</button>
    </div>
    
    <!-- Etapa 1: Dados Pessoais -->
    <div class="step-content form-section active" data-step="1">
        <div class="section-title">Dados Pessoais</div>
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-6">
                <label>Nome do Estudante:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_nome ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_nome ?? '' }}</div>
                @endif
            </div>
            <div class="form-group col-md-3">
                <label>Data de Nascimento:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_dt_nasc ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_dt_nasc ?? '' }}</div>
                @endif
            </div>
            <div class="form-group col-md-3">
                <label>Idade:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->idade ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->idade ?? '' }}</div>
                @endif
            </div>
        </div>
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-6">
                <label>Responsável:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_resp ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_resp ?? '' }}</div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label>Telefone:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_tel_resp ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_tel_resp ?? '' }}</div>
                @endif
            </div>
        </div>
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-6">
                <label>Endereço:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_end ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_end ?? '' }}</div>
                @endif
            </div>
            <div class="form-group col-md-3">
                <label>Turma:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->turma->tur_nome ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->turma->tur_nome ?? '' }}</div>
                @endif
            </div>
            <div class="form-group col-md-3">
                <label>Matrícula:</label>
                @if($modo == 'editar')
                    <input type="text" value="{{ $aluno->alu_matricula ?? '' }}" readonly class="form-control">
                @else
                    <div class="readonly-value">{{ $aluno->alu_matricula ?? '' }}</div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Etapa 2: Perfil do Estudante -->
    <div class="step-content form-section" data-step="2">
        <div class="section-title">Perfil do Estudante</div>
        <!-- Diagnóstico/Laudo -->
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-4">
                <label>Possui diagnóstico/laudo?</label>
                @if($modo == 'editar')
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diag_laudo" id="diag_laudo_sim" value="1" {{ $perfil->diag_laudo == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="diag_laudo_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diag_laudo" id="diag_laudo_nao" value="0" {{ $perfil->diag_laudo == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="diag_laudo_nao">Não</label>
                        </div>
                    </div>
                @else
                    <div class="readonly-value">{{ $perfil->diag_laudo == 1 ? 'Sim' : 'Não' }}</div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label>Data do laudo:</label>
                @if($modo == 'editar')
                    <input type="date" name="data_laudo" class="form-control" value="{{ $perfil->data_laudo ?? '' }}">
                @else
                    <div class="readonly-value">{{ $perfil->data_laudo ?? 'Não informado' }}</div>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label>CID:</label>
                @if($modo == 'editar')
                    <input type="text" name="cid" class="form-control" value="{{ $perfil->cid ?? '' }}" maxlength="20">
                @else
                    <div class="readonly-value">{{ $perfil->cid ?? 'Não informado' }}</div>
                @endif
            </div>
        </div>
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-6">
                <label>Nome do médico:</label>
                @if($modo == 'editar')
                    <input type="text" name="nome_medico" class="form-control" value="{{ $perfil->nome_medico ?? '' }}" maxlength="255">
                @else
                    <div class="readonly-value">{{ $perfil->nome_medico ?? 'Não informado' }}</div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label>Nível de suporte:</label>
                @if($modo == 'editar')
                    <select name="nivel_suporte" class="form-control">
                        <option value="1" {{ $perfil->nivel_suporte == 1 ? 'selected' : '' }}>Nível 1 - Exige pouco apoio</option>
                        <option value="2" {{ $perfil->nivel_suporte == 2 ? 'selected' : '' }}>Nível 2 - Exige apoio substancial</option>
                        <option value="3" {{ $perfil->nivel_suporte == 3 ? 'selected' : '' }}>Nível 3 - Exige apoio muito substancial</option>
                    </select>
                @else
                    <div class="readonly-value">
                        @if($perfil->nivel_suporte == 1)
                            Nível 1 - Exige pouco apoio
                        @elseif($perfil->nivel_suporte == 2)
                            Nível 2 - Exige apoio substancial
                        @elseif($perfil->nivel_suporte == 3)
                            Nível 3 - Exige apoio muito substancial
                        @else
                            Não informado
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Medicação -->
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-4">
                <label>Faz uso de medicamento?</label>
                @if($modo == 'editar')
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="uso_medicamento" id="uso_medicamento_sim" value="1" {{ $perfil->uso_medicamento == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="uso_medicamento_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="uso_medicamento" id="uso_medicamento_nao" value="0" {{ $perfil->uso_medicamento == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="uso_medicamento_nao">Não</label>
                        </div>
                    </div>
                @else
                    <div class="readonly-value">{{ $perfil->uso_medicamento == 1 ? 'Sim' : 'Não' }}</div>
                @endif
            </div>
            <div class="form-group col-md-8">
                <label>Quais medicamentos?</label>
                @if($modo == 'editar')
                    <input type="text" name="quais_medicamento" class="form-control" value="{{ $perfil->quais_medicamento ?? '' }}" maxlength="255">
                @else
                    <div class="readonly-value">{{ $perfil->quais_medicamento ?? 'Não informado' }}</div>
                @endif
            </div>
        </div>
        
        <!-- Profissional de Apoio -->
        <div class="row custom-row-gap align-items-end">
            <div class="form-group col-md-6">
                <label>Necessita de profissional de apoio?</label>
                @if($modo == 'editar')
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nec_pro_apoio" id="nec_pro_apoio_sim" value="1" {{ $perfil->nec_pro_apoio == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="nec_pro_apoio_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="nec_pro_apoio" id="nec_pro_apoio_nao" value="0" {{ $perfil->nec_pro_apoio == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="nec_pro_apoio_nao">Não</label>
                        </div>
                    </div>
                @else
                    <div class="readonly-value">{{ $perfil->nec_pro_apoio == 1 ? 'Sim' : 'Não' }}</div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label>Possui profissional de apoio?</label>
                @if($modo == 'editar')
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="prof_apoio" id="prof_apoio_sim" value="1" {{ $perfil->prof_apoio == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="prof_apoio_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="prof_apoio" id="prof_apoio_nao" value="0" {{ $perfil->prof_apoio == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="prof_apoio_nao">Não</label>
                        </div>
                    </div>
                @else
                    <div class="readonly-value">{{ $perfil->prof_apoio == 1 ? 'Sim' : 'Não' }}</div>
                @endif
            </div>
        </div>
        
        <!-- Momentos de Apoio -->
        <div class="form-group">
            <label>Em quais momentos da rotina esse profissional se faz necessário?</label>
            @if($modo == 'editar')
                <div class="checkbox-group">
                    <div class="form-check">
                        <input type="checkbox" id="loc_01" name="loc_01" value="1" {{ $perfil->loc_01 == 1 ? 'checked' : '' }}>
                        <label for="loc_01">Locomoção</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="hig_02" name="hig_02" value="1" {{ $perfil->hig_02 == 1 ? 'checked' : '' }}>
                        <label for="hig_02">Higiene</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="ali_03" name="ali_03" value="1" {{ $perfil->ali_03 == 1 ? 'checked' : '' }}>
                        <label for="ali_03">Alimentação</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="com_04" name="com_04" value="1" {{ $perfil->com_04 == 1 ? 'checked' : '' }}>
                        <label for="com_04">Comunicação</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="out_05" name="out_05" value="1" {{ $perfil->out_05 == 1 ? 'checked' : '' }}>
                        <label for="out_05">Outros</label>
                    </div>
                </div>
            @else
                <div class="readonly-value">
                    @php
                        $momentos = [];
                        if($perfil->loc_01 == 1) $momentos[] = 'Locomoção';
                        if($perfil->hig_02 == 1) $momentos[] = 'Higiene';
                        if($perfil->ali_03 == 1) $momentos[] = 'Alimentação';
                        if($perfil->com_04 == 1) $momentos[] = 'Comunicação';
                        if($perfil->out_05 == 1) $momentos[] = 'Outros';
                    @endphp
                    {{ count($momentos) > 0 ? implode(', ', $momentos) : 'Nenhum momento selecionado' }}
                </div>
            @endif
        </div>
        
        <!-- Outros Momentos -->
        <div class="form-group">
            <label>Outros momentos:</label>
            @if($modo == 'editar')
                <textarea name="out_momentos" class="form-control" rows="3" maxlength="65535">{{ $perfil->out_momentos ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $perfil->out_momentos ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <!-- Atendimento Especializado -->
        <div class="form-group">
            <label>Atendimento Educacional Especializado:</label>
            @if($modo == 'editar')
                <input type="text" name="at_especializado" class="form-control" value="{{ $perfil->at_especializado ?? '' }}" maxlength="255">
            @else
                <div class="readonly-value">{{ $perfil->at_especializado ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    <!-- Etapa 3: Personalidade -->
    <div class="step-content form-section" data-step="3">
        <div class="section-title">II - Personalidade</div>
        <div class="form-group">
            <label>Características principais:</label>
            @if($modo == 'editar')
                <textarea name="carac_principal" class="form-control" rows="3" maxlength="65535">{{ $personalidade->carac_principal ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->carac_principal ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Interesses relacionados às características principais:</label>
            @if($modo == 'editar')
                <textarea name="inter_princ_carac" class="form-control" rows="3" maxlength="65535">{{ $personalidade->inter_princ_carac ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->inter_princ_carac ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>O que gosta de fazer quando está livre:</label>
            @if($modo == 'editar')
                <textarea name="livre_gosta_fazer" class="form-control" rows="3" maxlength="65535">{{ $personalidade->livre_gosta_fazer ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->livre_gosta_fazer ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>O que o deixa feliz:</label>
            @if($modo == 'editar')
                <textarea name="feliz_est" class="form-control" rows="3" maxlength="65535">{{ $personalidade->feliz_est ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->feliz_est ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>O que o deixa triste:</label>
            @if($modo == 'editar')
                <textarea name="trist_est" class="form-control" rows="3" maxlength="65535">{{ $personalidade->trist_est ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->trist_est ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Objetos de apego:</label>
            @if($modo == 'editar')
                <textarea name="obj_apego" class="form-control" rows="3" maxlength="65535">{{ $personalidade->obj_apego ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $personalidade->obj_apego ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    <!-- Etapa 4: Comunicação -->
    <div class="step-content form-section" data-step="4">
        <div class="section-title">III - Comunicação</div>
        <div class="form-group">
            <label>Forma de comunicação:</label>
            @if($modo == 'editar')
                <textarea name="forma_comunicacao" class="form-control" rows="3" maxlength="65535">{{ $comunicacao->forma_comunicacao ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $comunicacao->forma_comunicacao ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Compreensão da comunicação:</label>
            @if($modo == 'editar')
                <textarea name="compreensao_comunicacao" class="form-control" rows="3">{{ $comunicacao->compreensao_comunicacao ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $comunicacao->compreensao_comunicacao ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Expressão da comunicação:</label>
            @if($modo == 'editar')
                <textarea name="expressao_comunicacao" class="form-control" rows="3">{{ $comunicacao->expressao_comunicacao ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $comunicacao->expressao_comunicacao ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    <!-- Etapa 5: Preferências -->
    <div class="step-content form-section" data-step="5">
        <div class="section-title">IV - Preferências, sensibilidade e dificuldades</div>
        <div class="form-group">
            <label>Apresenta sensibilidade:</label>
            @if($modo == 'editar')
                <div class="checkbox-group">
                    <div class="form-check">
                        <input type="checkbox" id="sensibilidade_auditiva" name="sensibilidade_auditiva" value="1" {{ $preferencia->sensibilidade_auditiva == 1 ? 'checked' : '' }}>
                        <label for="sensibilidade_auditiva">Auditiva</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="sensibilidade_tatil" name="sensibilidade_tatil" value="1" {{ $preferencia->sensibilidade_tatil == 1 ? 'checked' : '' }}>
                        <label for="sensibilidade_tatil">Tátil</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="sensibilidade_visual" name="sensibilidade_visual" value="1" {{ $preferencia->sensibilidade_visual == 1 ? 'checked' : '' }}>
                        <label for="sensibilidade_visual">Visual</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="sensibilidade_olfativa" name="sensibilidade_olfativa" value="1" {{ $preferencia->sensibilidade_olfativa == 1 ? 'checked' : '' }}>
                        <label for="sensibilidade_olfativa">Olfativa</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="sensibilidade_gustativa" name="sensibilidade_gustativa" value="1" {{ $preferencia->sensibilidade_gustativa == 1 ? 'checked' : '' }}>
                        <label for="sensibilidade_gustativa">Gustativa</label>
                    </div>
                </div>
            @else
                <div class="readonly-value">
                    @php
                        $sensibilidades = [];
                        if($preferencia->sensibilidade_auditiva == 1) $sensibilidades[] = 'Auditiva';
                        if($preferencia->sensibilidade_tatil == 1) $sensibilidades[] = 'Tátil';
                        if($preferencia->sensibilidade_visual == 1) $sensibilidades[] = 'Visual';
                        if($preferencia->sensibilidade_olfativa == 1) $sensibilidades[] = 'Olfativa';
                        if($preferencia->sensibilidade_gustativa == 1) $sensibilidades[] = 'Gustativa';
                    @endphp
                    {{ count($sensibilidades) > 0 ? implode(', ', $sensibilidades) : 'Nenhuma sensibilidade selecionada' }}
                </div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Preferências:</label>
            @if($modo == 'editar')
                <textarea name="preferencias" class="form-control" rows="3">{{ $preferencia->preferencias ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $preferencia->preferencias ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Dificuldades:</label>
            @if($modo == 'editar')
                <textarea name="dificuldades" class="form-control" rows="3">{{ $preferencia->dificuldades ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $preferencia->dificuldades ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    <!-- Etapa 6: Informações da Família -->
    <div class="step-content form-section" data-step="6">
        <div class="section-title">V - Informações da família</div>
        <div class="form-group">
            <label>Há expectativas expressas da família em relação ao desempenho e a inclusão do estudante na sala de aula?</label>
            @if($modo == 'editar')
                <textarea name="expectativas_familia" class="form-control" rows="3">{{ $perfilFamilia->expectativas_familia ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $perfilFamilia->expectativas_familia ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Como a família participa da vida escolar do estudante?</label>
            @if($modo == 'editar')
                <textarea name="participacao_familia" class="form-control" rows="3">{{ $perfilFamilia->participacao_familia ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $perfilFamilia->participacao_familia ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    <!-- Etapa 7: Cadastro de Profissionais -->
    <div class="step-content form-section" data-step="7">
        <div class="section-title">Cadastro de Profissionais</div>
        <div class="form-group">
            <label>Nome do profissional AEE:</label>
            @if($modo == 'editar')
                <input type="text" name="nome_prof_AEE" class="form-control" value="{{ $perfilProfissional->nome_prof_AEE ?? '' }}">
            @else
                <div class="readonly-value">{{ $perfilProfissional->nome_prof_AEE ?? 'Não informado' }}</div>
            @endif
        </div>
        
        <div class="form-group">
            <label>Observações adicionais:</label>
            @if($modo == 'editar')
                <textarea name="observacoes" class="form-control" rows="3">{{ $perfilProfissional->observacoes ?? '' }}</textarea>
            @else
                <div class="readonly-value" style="min-height: 80px;">{{ $perfilProfissional->observacoes ?? 'Não informado' }}</div>
            @endif
        </div>
    </div>
    
    @if($modo == 'editar')
        </form>
    @endif
</div>
@endsection

@section('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil_estudante_components.css') }}">
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa as abas
            const stepTabs = document.querySelectorAll('.step-tab');
            const stepContents = document.querySelectorAll('.step-content');
            const progressBar = document.getElementById('progressBar');
            const totalSteps = stepTabs.length;
            
            // Função para mudar de aba
            function changeTab(step) {
                // Remove active de todas as abas e conteúdos
                stepTabs.forEach(tab => tab.classList.remove('active'));
                stepContents.forEach(content => content.classList.remove('active'));
                
                // Adiciona active na aba e conteúdo selecionados
                document.querySelector(`.step-tab[data-step="${step}"]`).classList.add('active');
                document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');
                
                // Atualiza a barra de progresso
                const progress = (step / totalSteps) * 100;
                progressBar.style.width = progress + '%';
            }
            
            // Adiciona evento de clique em cada aba
            stepTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const step = this.getAttribute('data-step');
                    changeTab(step);
                });
            });
            
            // Inicializa a primeira aba
            changeTab(1);
            
            // Adiciona evento para o formulário
            const perfilForm = document.getElementById('perfilForm');
            if (perfilForm) {
                perfilForm.addEventListener('submit', function(e) {
                    // Garantir que todos os campos estejam presentes mesmo que não preenchidos
                    const camposInt = ['diag_laudo', 'nivel_suporte', 'uso_medicamento', 'nec_pro_apoio', 'prof_apoio',
                                      'loc_01', 'hig_02', 'ali_03', 'com_04', 'out_05'];
                    
                    camposInt.forEach(campo => {
                        if (!perfilForm.querySelector(`[name="${campo}"]`)) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = campo;
                            input.value = '0';
                            perfilForm.appendChild(input);
                        }
                    });
                    
                    // Campos de texto que devem ser enviados mesmo vazios
                    const camposTexto = ['cid', 'nome_medico', 'quais_medicamento', 'out_momentos', 'at_especializado', 'nome_prof_AEE'];
                    
                    camposTexto.forEach(campo => {
                        if (!perfilForm.querySelector(`[name="${campo}"]`)) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = campo;
                            input.value = '';
                            perfilForm.appendChild(input);
                        }
                    });
                    
                    // Adicionar campo update_count se não existir
                    if (!perfilForm.querySelector('[name="update_count"]')) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'update_count';
                        input.value = '1';
                        perfilForm.appendChild(input);
                    }
                });
            }
        });
    </script>
@endsection
