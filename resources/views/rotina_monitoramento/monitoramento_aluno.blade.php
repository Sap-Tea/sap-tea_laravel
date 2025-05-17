@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Monitoramento do Aluno</h2>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $aluno->alu_nome }}</h5>
            <p class="card-text"><strong>RA:</strong> {{ $aluno->alu_ra }}</p>
            <p class="card-text"><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Idade:</strong> {{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} anos</p>
        </div>
    </div>
    <div>
        <!-- Aqui você pode inserir o fluxo de monitoramento desejado para o aluno -->
        <p>Em breve: formulário ou painel de rotina/monitoramento para este aluno.</p>
    </div>
    <a href="{{ route('rotina.monitoramento.inicial') }}" class="btn btn-secondary mt-3">Voltar para a lista de alunos</a>
</div>
@endsection
