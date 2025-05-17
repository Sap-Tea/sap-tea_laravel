@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Rotina de Monitoramento Inicial</h2>

    <!-- Dados do Aluno Selecionado -->
    @if(isset($aluno))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>RA</th>
                    <th>Nome do Aluno</th>
                    <th>Idade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $aluno->alu_ra ?? '-' }}</td>
                    <td>{{ $aluno->alu_nome ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age ?? '-' }} anos</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">Acessar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">Nenhum aluno selecionado.</div>
    @endif

    <!-- Botão Voltar -->
    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
