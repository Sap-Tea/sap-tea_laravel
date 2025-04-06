@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Relação dos Alunos</h2>

    <!-- Formulário de Pesquisa -->
     
    <form id = "pesquisaForm" method="POST" action="{{ route('inserir_inventario') }}">
        <div class="input-group mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Pesquisar por aluno"
                   value="{{ request('nome') }}">
            <button id="pesquisarBtn" class="btn btn-primary" type="submit">Pesquisar</button>

        </div>
    </form>

<script>
document.getElementById('pesquisarBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário

    // Pega o valor do campo de pesquisa
    var nome = document.querySelector('input[name="nome"]').value;

    // Redireciona para a rota imprime_aluno com o parâmetro nome
    window.location.href = "{{route('imprime_aluno') }}?nome=" + nome;
});



</script>

    
    <!-- Tabela de Resultados -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>RA do Aluno</th>
                <th>Nome do Aluno</th>
                <th>Responsável</th>
                <th>Tel. Responsável</th>
                <th>Email</th>
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
                    <td>{{ $aluno->alu_nome_resp }}</td>
                    <td>{{ $aluno->alu_tel_resp }}</td>
                    <td>{{ $aluno->alu_email_resp }}</td>
                  
                    <!-- Botão cadastra -->
                    <td>
                        @if($aluno->flag_inventario === "*").
                            <button class="btn btn-primary btn-sm" disabled>Cadastra Inventário</button>
                        @else
                        
                        <a href="{{ route('alunos.inventario', ['id' => $aluno->alu_id]) }}" class="btn btn-primary btn-sm">Cadastra Inventário</a>

                        @endif
                    </td>

                    <!-- Botão visualiza/atualiza -->
                    <td>
                        @if($aluno->flag_inventario === null)
                            <button class="btn btn-warning btn-sm text-white" 
                                    style="background-color: #e67e22; border-color: #d35400;"
                                    disabled>Visualiza inventário</button>
                        @else
                            <a href="{{ route('visualizar.perfil', ['id' => $aluno->alu_id]) }}" 
                               class="btn btn-primary btn-sm">Visualizar Inventário</a>
                        @endif
                    </td>
                </tr>
            @empty
                <!-- Caso não existam alunos -->
                <tr>
                    <td colspan="8" class="text-center">Nenhum aluno encontrado.</td>
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

    <!-- Botão Voltar -->
    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Voltar -> Menu</a>
</div>
@endsection
