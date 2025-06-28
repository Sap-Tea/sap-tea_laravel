<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aluno;
class ImprimeAlunoController extends Controller
{
    public function imprimeAluno(Request $request)
    {
        $nome = $request->input('nome', '');
        $alunos = Aluno::with(['matriculas.modalidade.tipo', 'matriculas.turma.serie'])
                       ->where('alu_nome', 'like', "%{$nome}%")
                       ->paginate(10);

        return view('Alunos.imprime_aluno', compact('alunos'));
    }
}
