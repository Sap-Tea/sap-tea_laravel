@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Rotina de Monitoramento Inicial</h2>

    <!-- Tabela de Alunos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>RA</th>
                <th>Nome do Aluno</th>
                <th>Idade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alunos as $aluno)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aluno->alu_ra }}</td>
                    <td>{{ $aluno->alu_nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} anos</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">Acessar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum aluno encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Botão Voltar -->
    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
