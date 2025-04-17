@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Inventário</title>
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}">
    <style>
        .readonly-radio {
            pointer-events: none;
            opacity: 0.7;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        td, th {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/LOGOTEA.png') }}" alt="Logo" class="logo">
            <h3>CONSULTA DE INVENTÁRIO - {{ $aluno->alu_nome }}</h3>
            <p>Data da Consulta: {{ date('d/m/Y') }}</p>
        </div>

        <div class="student-info">
            <p><strong>Escola:</strong> {{ $aluno->esc_razao_social }}</p>
            <p><strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($aluno->alu_dtnasc)) }}</p>
            <p><strong>Idade:</strong> {{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} anos</p>
            <p><strong>Série/Turma:</strong> {{ $aluno->serie_desc }} - {{ $aluno->fk_cod_valor_turma }}</p>
        </div>

        <div class="inventory-data">
            <!-- Seção Responsável e Suporte -->
            <div class="section">
                <h3>Responsável pelo Preenchimento:</h3>
                <p>
                    @if($preenchimento->professor_responsavel == 1)
                        Professor de sala Regular
                    @else
                        Professor do Atendimento Educacional Especializado (AEE)
                    @endif
                </p>

                <h3>Nível de Suporte:</h3>
                <p>
                    @switch($preenchimento->nivel_suporte)
                        @case(1) Nível 1 - Pouco apoio @break
                        @case(2) Nível 2 - Apoio substancial @break
                        @case(3) Nível 3 - Apoio muito substancial @break
                    @endswitch
                </p>

                <h3>Forma de Comunicação:</h3>
                <p>
                    @switch($preenchimento->nivel_comunicacao)
                        @case(1) Verbal @break
                        @case(2) Não verbal com métodos alternativos @break
                        @case(3) Não verbal @break
                    @endswitch
                </p>
            </div>

            <!-- Eixo Comunicação/Linguagem -->
            <div class="section">
                <h2>EIXO COMUNICAÇÃO/LINGUAGEM</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Perguntas_eixo_comunicacao as $i => $pergunta)
                            @php 
                                $campo = 'ecm' . sprintf('%02d', $i+1);
                                $valor = $eixoComunicacao->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Eixo Comportamento -->
            <div class="section">
                <h2>EIXO COMPORTAMENTO</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perguntas_eixo_comportamento as $i => $pergunta)
                            @php 
                                $campo = 'ecp' . sprintf('%02d', $i+1);
                                $valor = $eixoComportamento->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Eixo Socioemocional -->
            <div class="section">
                <h2>EIXO INTERAÇÃO SOCIOEMOCIONAL</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eixo_int_socio_emocional as $i => $pergunta)
                            @php 
                                $campo = 'eis' . sprintf('%02d', $i+1);
                                $valor = $eixoSocioEmocional->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            <a href="{{ route('index') }}" class="btn btn-back">Voltar</a>
        </div>
    </div>
</body>
</html>
@endsection
