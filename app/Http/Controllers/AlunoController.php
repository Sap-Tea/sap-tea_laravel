<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlunoController extends Controller
{
    public function index($id)
{
    $alunosDetalhados = Aluno::getAlunosDetalhados($id);
    if (!empty($alunosDetalhados)) {
        $aluno = $alunosDetalhados[0];
      //  dd($aluno); // Isso exibirá todos os dados do aluno
    } else {
        abort(404);
    }
    return view('alunos.perfil_estudante', compact('aluno'));
}

    
}


