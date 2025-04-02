<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Aluno; // Importa o modelo Aluno
use Carbon\Carbon; // Para manipulação de datas

 

class PerfilEstudanteController extends Controller
{
    public function index()
    {
        // Exemplo: Retornar uma lista de estudantes
        $alunos = Aluno::all(); // Busca todos os alunos no banco de dados
    
        return view('alunos.imprime_aluno', compact('alunos'));
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






        
}