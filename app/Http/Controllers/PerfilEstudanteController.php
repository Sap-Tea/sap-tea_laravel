<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aluno; // Importa o modelo Aluno
use Carbon\Carbon; // Para manipulação de datas
use App\Models\PerfilEstudante;

 

class PerfilEstudanteController extends Controller
{
    public function index()
{
    // Busca apenas alunos matriculados, ordenados por nome
    $alunos = Aluno::whereHas('matriculas')
                   ->orderBy('alu_nome', 'asc')
                   ->get();

    return view('alunos.imprime_aluno', compact('alunos'));
}

    public function index_inventario()
    {
        // Busca apenas alunos matriculados, ordenados por nome
        $alunos = Aluno::whereHas('matriculas')
                    ->orderBy('alu_nome', 'asc')
                    ->get();

        return view('alunos.imprime_aluno_eixo', compact('alunos'));
    } 

 
        public function mostrar($id)
        {
            // Busca o aluno pelo ID no banco de dados
            $aluno = Aluno::findOrFail($id);
    
            // Calcula a idade com base na data de nascimento
            $idade = Carbon::parse($aluno->alu_dtnasc)->age;
    
            // Retorna a view com os dados do aluno e a idade
            return view('alunos.perfil_estudante', compact('aluno', 'idade'));
        }

        public function mostra_aluno_eixo($id)
        {
            $aluno = Aluno::findOrFail($id);
            $_eixo = Carbon::parse($aluno->alu_dtnasc)->age;
            //$alunos = Aluno::all(); // Busca todos os alunos no banco de dados
    
            return view('alunos.imprime_aluno_eixo', compact('alunos','idade_eixo'));
        }
        
}