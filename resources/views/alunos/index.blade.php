@extends('layouts.app')

@section('content')
<main>
    <h1>Detalhes do estudante</h1>
    @if(isset($aluno))
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Modalidade</th>
                    <th>Série</th>
                    <th>Professor</th>
                    <th>Função do Professor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $aluno->alu_nome }}</td>
                    <td>{{ $aluno->alu_dtnasc }}</td>
                    <td>{{ $aluno->desc_modalidade }}</td>
                    <td>{{ $aluno->desc_serie_modalidade }}</td>
                    <td>{{ $aluno->func_nome }}</td>
                    <td>{{ $aluno->desc_tipo_funcao }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>estudante não encontrado</p>
    @endif
</main>
@endsection

