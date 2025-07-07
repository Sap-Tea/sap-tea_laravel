@extends('index')

@section('title', 'Indicativo Inicial')

@section('styles')
<style>
.linha-eixo-comunicacao,
.linha-eixo-comunicacao > th,
.linha-eixo-comunicacao > td {
    background-color: #7EC3EA !important;
}
.linha-eixo-comportamento,
.linha-eixo-comportamento > th,
.linha-eixo-comportamento > td {
    background-color: #FFD591 !important;
}
.linha-eixo-socio,
.linha-eixo-socio > th,
.linha-eixo-socio > td {
    background-color: #A2F5C8 !important;
}

    .header-container {
        background-color: #f4f4f4;
        padding: 15px;
        margin-bottom: 20px;
        border-bottom: 3px solid #d9534f;
        border-radius: 5px;
    }
    .header-title {
        text-align: center;
        margin: 10px 0;
        font-weight: bold;
        color: #d9534f;
        font-size: 22px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .logo-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 0 15px;
    }
    .logo-container img {
        max-height: 80px;
        object-fit: contain;
    }
    .student-info {
        margin-top: 20px;
    }
    .student-info p {
        margin-bottom: 10px;
    }
    .student-info input {
        border: 1px solid #ddd;
        padding: 5px 10px;
        border-radius: 4px;
        background-color: #f9f9f9;
    }
    .student-info input:read-only {
        background-color: #f5f5f5;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Indicativo Inicial') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="header-container">
    <div class="logo-container">
        <img src="{{ asset('img/logo_sap.png') }}" alt="Logo SAP">
        <img src="{{ asset('img/logo_tea.png') }}" alt="Logo TEA">
    </div>
    <h1 class="header-title">INDICATIVO INICIAL</h1>
    <div class="student-info">
                        @if(isset($alunoDetalhado) && is_array($alunoDetalhado) && count($alunoDetalhado) > 0)
                            @php $aluno = $alunoDetalhado[0]; @endphp
                            <p>Escola: <input type="text" style="width: 300px;" value="{{$aluno->esc_razao_social ?? '-'}}" readonly></p>
                            <p>Nome do estudante: <input type="text" style="width: 250px;" value="{{$aluno->alu_nome ?? '-'}}" readonly></p>
                            
                            <p>Data de Nascimento: <input type="date" value="{{$aluno->alu_dtnasc ?? ''}}" readonly>
                                Idade: <input value="{{ isset($aluno->alu_dtnasc) ? \Carbon\Carbon::parse($aluno->alu_dtnasc)->age . ' - anos' : '-' }}" readonly type="text" min="0" style="width: 80px;"></p>
                            <p>RA: <input type="text" style="width: 150px;" value="{{$aluno->alu_ra ?? '-'}}" readonly>
                                Turma: <input value="{{$aluno->fk_cod_valor_turma ?? '-'}}" type="text" style="width: 120px;" readonly>
                                Segmento: <input type="text" style="width: 200px;" value="{{$aluno->desc_modalidade ?? '-'}}" readonly></p>
                            <p>Série: <input type="text" style="width: 200px;" value="{{$aluno->serie_desc ?? '-'}}" readonly>
                                Período: <input type="text" style="width: 120px;" value="{{$aluno->periodo ?? '-'}}" readonly></p>
                        @elseif(isset($alunoDetalhado) && !is_array($alunoDetalhado))
                            <p>Escola: <input type="text" style="width: 300px;" value="{{$alunoDetalhado->esc_razao_social ?? '-'}}" readonly></p>
                            <p>Nome do estudante: <input type="text" style="width: 250px;" value="{{$alunoDetalhado->alu_nome ?? '-'}}" readonly></p>
                            
                            <p>Data de Nascimento: <input type="date" value="{{$alunoDetalhado->alu_dtnasc ?? ''}}" readonly>
                                Idade: <input value="{{ isset($alunoDetalhado->alu_dtnasc) ? \Carbon\Carbon::parse($alunoDetalhado->alu_dtnasc)->age . ' - anos' : '-' }}" readonly type="text" min="0" style="width: 80px;"></p>
                            <p>RA: <input type="text" style="width: 150px;" value="{{$alunoDetalhado->alu_ra ?? '-'}}" readonly>
                                Turma: <input value="{{$alunoDetalhado->fk_cod_valor_turma ?? '-'}}" type="text" style="width: 120px;" readonly>
                                Segmento: <input type="text" style="width: 200px;" value="{{$alunoDetalhado->desc_modalidade ?? '-'}}" readonly></p>
                            <p>Série: <input type="text" style="width: 200px;" value="{{$alunoDetalhado->serie_desc ?? '-'}}" readonly>
                                Período: <input type="text" style="width: 120px;" value="{{$alunoDetalhado->periodo ?? '-'}}" readonly></p>
                        @else
                            <div class="alert alert-warning">
                                Não foi possível carregar os dados do aluno. Por favor, verifique se o aluno existe e se você tem permissão para acessá-lo.
                            </div>
                        @endif
                        </div>

                        <!-- Bloco Eixo Comunicação/Linguagem -->
                        <div class="eixo-bloco-comunicacao" style="margin-top: 30px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="linha-eixo-comunicacao">
                                        <th colspan="3" style="text-align:center;">INVENTÁRIO DE HABILIDADES - EIXO COMUNICAÇÃO/LINGUAGEM</th>
                                    </tr>
                                    <tr class="linha-eixo-comunicacao">
                                        <th>Atividade / Habilidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
    $atividadeAgrupada = [];
    foreach ($atividadesComunicacao as $item) {
        $atividadeAgrupada[$item->desc_atividade][] = $item;
    }
@endphp
@foreach ($atividadeAgrupada as $atividadeNome => $habilidades)
    <tr class="linha-eixo-comunicacao">
        <td colspan="2"><strong>{{ $atividadeNome }}</strong></td>
    </tr>
    @php
    $descHabUnicas = collect($habilidades)->unique('desc_hab_com_lin');
@endphp
@foreach ($descHabUnicas as $habilidade)
    <tr style="background-color: #E3F4FD;">
        <td style="padding-left: 32px;">{{ $habilidade->desc_hab_com_lin }}</td>
    </tr>
@endforeach
@endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bloco Eixo Comportamento -->
                        <div class="eixo-bloco-comportamento" style="margin-top: 30px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="linha-eixo-comportamento">
                                        <th colspan="3" style="text-align:center;">INVENTÁRIO DE HABILIDADES - EIXO COMPORTAMENTO</th>
                                    </tr>
                                    <tr class="linha-eixo-comportamento">
                                        <th>Atividade / Habilidade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
    $atividadeAgrupadaComp = [];
    foreach ($atividadesComportamento as $item) {
        $atividadeAgrupadaComp[$item->desc_atividade][] = $item;
    }
@endphp
@foreach ($atividadeAgrupadaComp as $atividadeNome => $habilidades)
    <tr class="linha-eixo-comportamento">
        <td colspan="2"><strong>{{ $atividadeNome }}</strong></td>
    </tr>
    @php
    $descHabUnicas = collect($habilidades)->unique('desc_hab_comportamento');
@endphp
@foreach ($descHabUnicas as $habilidade)
    <tr style="background-color: #FFF5E3;">
        <td style="padding-left: 32px;">{{ $habilidade->desc_hab_comportamento }}</td>
    </tr>
@endforeach
@endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bloco Eixo Interação/Socioemocional -->
                        <div class="eixo-bloco-socio" style="margin-top: 30px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="linha-eixo-socio">
                                        <th colspan="3" style="text-align:center;">INVENTÁRIO DE HABILIDADES - EIXO INTERAÇÃO/SOCIOEMOCIONAL</th>
                                    </tr>
                                    <tr class="linha-eixo-socio">
                                        <th>Atividade / Habilidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
    $atividadeAgrupadaSocio = [];
    foreach ($atividadesSocioemocional as $item) {
        $atividadeAgrupadaSocio[$item->desc_atividade][] = $item;
    }
@endphp
@foreach ($atividadeAgrupadaSocio as $atividadeNome => $habilidades)
    <tr class="linha-eixo-socio">
        <td colspan="2"><strong>{{ $atividadeNome }}</strong></td>
    </tr>
    @php
    $descHabUnicas = collect($habilidades)->unique('desc_hab_int_soc');
@endphp
@foreach ($descHabUnicas as $habilidade)
    <tr style="background-color: #E3FDEB;">
        <td style="padding-left: 32px;">{{ $habilidade->desc_hab_int_soc }}</td>
    </tr>
@endforeach
@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
