@extends('index')

@section('content')
<div class="container mt-4">
    <h2>{{ $titulo ?? 'Alunos matriculados' }}</h2>

    @if(isset($professor_nome))
        <div class="alert alert-secondary mb-3">
            <strong>Professor Responsável:</strong> {{ $professor_nome }}
        </div>
    @endif

    <!-- Formulário de Pesquisa -->
    <form id="pesquisaForm" method="GET" action="{{ route('imprime_aluno') }}">
        <div class="input-group mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Pesquisar por estudante"
                   value="{{ request('nome') }}">
            <button class="btn btn-primary" type="submit">Pesquisar</button>
        </div>
    </form>

    <!-- Tabela de Resultados -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>RA do estudante</th>
                <th>Nome do estudante</th>
                <th>Nome da Escola</th>
                <th>Segmento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alunos as $aluno)
                <tr>
                    <!-- Número da linha -->
                    <td>{{ $loop->iteration }}</td> 
                    <!-- Dados do aluno -->
                    <td>{{ $aluno->alu_ra }}</td>
                    <td>{{ $aluno->alu_nome }}</td>
                    <td>{{ optional($aluno->matriculas->first()->turma->escola)->esc_razao_social ?? '---' }}</td>
                    <td>{{ optional(optional($aluno->matriculas->first()->modalidade)->tipo)->desc_modalidade ?? '---' }}</td>
                  
                    <td>
                                                <a href="{{ route($rotaCadastro, ['id' => $aluno->alu_id]) }}" class="btn btn-primary btn-sm">{{ $textoBotao ?? 'Cadastrar' }}</a>
                    </td>
                </tr>
            @empty
                <!-- Caso não existam estudantes -->
                <tr>
                    <td colspan="8" class="text-center">Não existe aluno para a fase acessada porque a anterior ainda não foi concluída.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    @if ($alunos instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center">
            {{ $alunos->links() }}
        </div>
    @endif


</div>
@endsection
