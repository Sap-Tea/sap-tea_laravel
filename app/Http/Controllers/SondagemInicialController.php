<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SondagemInicialController extends Controller
{
    public function sondagemPorFase($fase, $textoBotao)
    {
        if (!session('id')) {
            return redirect()->route('login')->withErrors(['msg' => 'Sessão expirada ou acesso não autorizado.']);
        }

        $professor = session('professor');
        if (!$professor) {
            return redirect()->route('login')->withErrors(['msg' => 'Sessão expirada ou acesso não autorizado.']);
        }

        $anoAtual = date('Y');

        $alunos = \App\Models\Aluno::porProfessor($professor->func_id)
            ->leftJoin('controle_fases_sondagem as cfs', function ($join) use ($anoAtual) {
                $join->on('aluno.alu_id', '=', 'cfs.id_aluno')
                    ->where('cfs.ano', '=', $anoAtual);
            })
            ->select('aluno.*', 'cfs.fase_inicial', 'cfs.fase_cont1', 'cfs.fase_cont2', 'cfs.fase_final')
            ->get();

        return view('alunos.imprime_aluno_eixo', [
            'alunos' => $alunos,
            'titulo' => "Sondagem Pedagógica - Fase {$fase}",
            'textoBotao' => $textoBotao,
            'professor_nome' => $professor->func_nome,
            'rotaCadastro' => 'sondagem.inventario.cadastrar', // Rota para o botão de cadastro
            'faseSondagem' => $fase
        ]);
    }

    public function inicial()
    {
        return $this->sondagemPorFase('Inicial', 'Cadastrar Sondagem Inicial');
    }

    public function continuada1()
    {
        return $this->sondagemPorFase('Continuada 1', 'Cadastrar Sondagem Continuada 1');
    }

    public function continuada2()
    {
        return $this->sondagemPorFase('Continuada 2', 'Cadastrar Sondagem Continuada 2');
    }

    public function final()
    {
        return $this->sondagemPorFase('Final', 'Cadastrar Sondagem Final');
    }
}
