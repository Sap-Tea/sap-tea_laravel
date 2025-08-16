<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SondagemContinuadaController extends Controller
{
    private function getAlunosComFiltro($condicoes, $titulo, $textoBotao)
    {
        $professor = auth('funcionario')->user();
        if (!$professor) {
            return redirect()->route('login')->withErrors(['msg' => 'Acesso não autorizado.']);
        }

        $anoCorrente = Carbon::now()->year;

        $aluno_ids = DB::table('aluno as a')
            ->join('matricula as m', 'a.alu_id', '=', 'm.fk_id_aluno')
            ->join('turma as t', 'm.fk_cod_valor_turma', '=', 't.cod_valor')
            ->join('controle_fases_sondagem as cfs', 'a.alu_id', '=', 'cfs.id_aluno')
            ->where('t.fk_cod_func', $professor->func_id)
            ->where('cfs.ano', $anoCorrente)
            ->where($condicoes)
            ->distinct()
            ->pluck('a.alu_id');

        $alunos = Aluno::whereIn('alu_id', $aluno_ids)->get();

        return view('alunos.imprime_aluno_eixo', [
            'alunos' => $alunos,
            'titulo' => $titulo,
            'textoBotao' => $textoBotao,
            'professor_nome' => $professor->func_nome,
            'rotaCadastro' => 'sondagem.inventario.cadastrar' // Rota corrigida
        ]);
    }

    public function continuada1()
    {
        $condicoes = [
            ['cfs.cont_I', '>=', 3],
            ['cfs.fase_cont1', '=', 'Pendente'],
        ];
        return $this->getAlunosComFiltro($condicoes, 'Sondagem Pedagógica - Fase Continuada 1', 'Cadastrar Sondagem Continuada 1');
    }

    public function continuada2()
    {
        $condicoes = [
            // Verifica se a fase_cont1 NÃO está pendente (já foi concluída)
            ['cfs.fase_cont1', '!=', 'Pendente'],
            // Verifica se o contador da fase anterior (cont_fase_c1) é >= 3
            ['cfs.cont_fase_c1', '>=', 3],
            // Verifica se a fase_cont2 está como 'Pendente'
            ['cfs.fase_cont2', '=', 'Pendente']
        ];
        
        return $this->getAlunosComFiltro($condicoes, 'Sondagem Pedagógica - Fase Continuada 2', 'Cadastrar Sondagem Continuada 2');
    }

    public function sondagemFinal()
    {
        $condicoes = [
            ['cfs.fase_cont2', '!=', 'Pendente'],
            ['cfs.cont_fase_c2', '>=', 3],
            ['cfs.fase_final', '=', 'Pendente'],
        ];
        return $this->getAlunosComFiltro($condicoes, 'Sondagem Pedagógica - Fase Final', 'Cadastrar Sondagem Final');
    }
}
