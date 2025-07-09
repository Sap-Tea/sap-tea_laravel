@extends('index')

@section('title', 'Indicativo Inicial')

@section('styles')
<style>
.linha-eixo-comunicacao,
.linha-eixo-comunicacao > th,
.linha-eixo-comunicacao > td {
    background-color: #7EC3EA !important;
    color: #003366 !important;
}
.linha-eixo-comportamento,
.linha-eixo-comportamento > th,
.linha-eixo-comportamento > td {
    background-color: #FFD591 !important;
    color: #7a5b00 !important;
}
.linha-eixo-socio,
.linha-eixo-socio > th,
.linha-eixo-socio > td {
    background-color: #A2F5C8 !important;
    color: #006644 !important;
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
                        {{-- Eixo: Comunicação/Linguagem --}}
                        @if (isset($comunicacao_atividades_realizadas) && $comunicacao_atividades_realizadas->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header linha-eixo-comunicacao" style="background-color: #7EC3EA; color: #003366;">
                                            <h5 class="card-title">Eixo: Comunicação/Linguagem</h5>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="mt-2">Atividades Realizadas</h6>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach ($comunicacao_atividades_realizadas as $atividade)
                                                        <tr class="linha-eixo-comunicacao">
                                                        <tr>
                                                            <td>{{ $atividade->descricao_atividade }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            @if (isset($comunicacao_habilidades_encontradas) && $comunicacao_habilidades_encontradas->isNotEmpty())
                                                <h6 class="mt-4">Habilidades Encontradas</h6>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        @foreach ($comunicacao_habilidades_encontradas as $habilidade)
                                                            <tr>
                                                                <td>{{ $habilidade->descricao_habilidade }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                                    @if(isset($comportamento_agrupado) && count($comportamento_agrupado) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header linha-eixo-comportamento" style="background-color: #FFD591; color: #7a5b00;">
                    <h5 class="card-title">Eixo: Comportamento</h5>
                </div>
                <div class="card-body">
                    <h6 class="mt-2">Atividades Realizadas</h6>
                    <table class="table table-bordered">
                        <tbody>
                            @php
                                $atividadesComportamento = collect($comportamento_agrupado)->pluck('atividade')->unique();
                            @endphp
                            @foreach ($atividadesComportamento as $atividade)
                                <tr>
                                    <td>{{ $atividade }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $habilidadesComportamento = collect($comportamento_agrupado)->pluck('habilidade')->unique();
                    @endphp
                    @if($habilidadesComportamento->isNotEmpty())
                        <h6 class="mt-4">Habilidades Encontradas</h6>
                        <table class="table table-bordered">
                            <tbody>
                                @foreach ($habilidadesComportamento as $habilidade)
                                    <tr>
                                        <td>{{ $habilidade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
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
                                    @if(isset($socioemocional_agrupado) && count($socioemocional_agrupado) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header linha-eixo-socio" style="background-color: #A2F5C8; color: #006644;">
                    <h5 class="card-title">Eixo: Interação/Socioemocional</h5>
                </div>
                <div class="card-body">
                    <h6 class="mt-2">Atividades Realizadas</h6>
                    <table class="table table-bordered">
                        <tbody>
                            @php
                                $atividadesSocio = collect($socioemocional_agrupado)->pluck('atividade')->unique();
                            @endphp
                            @foreach ($atividadesSocio as $atividade)
                                <tr>
                                    <td>{{ $atividade }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $habilidadesSocio = collect($socioemocional_agrupado)->pluck('habilidade')->unique();
                    @endphp
                    @if($habilidadesSocio->isNotEmpty())
                        <h6 class="mt-4">Habilidades Encontradas</h6>
                        <table class="table table-bordered">
                            <tbody>
                                @foreach ($habilidadesSocio as $habilidade)
                                    <tr>
                                        <td>{{ $habilidade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
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
