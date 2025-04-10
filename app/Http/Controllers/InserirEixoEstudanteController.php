<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\EixoComunicacaoLinguagem;
use App\Models\EixoInteracaoSocEmocional;
use App\Models\EixoComportamento;
use Illuminate\Support\Facades\DB;

class InserirEixoEstudanteController extends Controller
{
    public function inserir_eixo_estudante(Request $request)
    {
        // Validação dos dados enviados pelo formulário
        $request->validate([
            'ecm01' => 'required|in:1,0',
            'ecm02' => 'required|in:1,0',
            'ecm03' => 'required|in:1,0',
            'ecm04' => 'required|in:1,0',
            'ecm05' => 'required|in:1,0',
            'ecm06' => 'required|in:1,0',
            'ecm07' => 'required|in:1,0',
            'ecm08' => 'required|in:1,0',
            'ecm09' => 'required|in:1,0',
            'ecm10' => 'required|in:1,0',
            'ecm11' => 'required|in:1,0',
            'ecm12' => 'required|in:1,0',
            'ecm13' => 'required|in:1,0',
            'ecm14' => 'required|in:1,0',
            'ecm15' => 'required|in:1,0',
            'ecm16' => 'required|in:1,0',
            'ecm17' => 'required|in:1,0',
            'ecm18' => 'required|in:1,0',
            'ecm19' => 'required|in:1,0',
            'ecm20' => 'required|in:1,0',
            'ecm21' => 'required|in:1,0',
            'ecm22' => 'required|in:1,0',
            'ecm23' => 'required|in:1,0',
            'ecm24' => 'required|in:1,0',
            'ecm25' => 'required|in:1,0',
            'ecm26' => 'required|in:1,0',
            'ecm27' => 'required|in:1,0',
            'ecm28' => 'required|in:1,0',
            'ecm29' => 'required|in:1,0',
            'ecm30' => 'required|in:1,0',
            'ecm31' => 'required|in:1,0',
            'ecm32' => 'required|in:1,0'
           
        ]);

        $alunoId = $request->input('aluno_id');
      //  dd($alunoId);
        try {
            $eixo_com_lin = EixoComunicacaoLinguagem::create([
                'ecm01' => $request->input('ecm01'),
                'ecm02' => $request->input('ecm02'),
                'ecm03' => $request->input('ecm03'),
                'ecm04' => $request->input('ecm04'),
                'ecm05' => $request->input('ecm05'),
                'ecm06' => $request->input('ecm06'),
                'ecm07' => $request->input('ecm07'),
                'ecm08' => $request->input('ecm08'),
                'ecm09' => $request->input('ecm09'),
                'ecm10' => $request->input('ecm10'),
                'ecm11' => $request->input('ecm11'),
                'ecm12' => $request->input('ecm12'),
                'ecm13' => $request->input('ecm13'),
                'ecm14' => $request->input('ecm14'),
                'ecm15' => $request->input('ecm15'),
                'ecm16' => $request->input('ecm16'),
                'ecm17' => $request->input('ecm17'),
                'ecm18' => $request->input('ecm18'),
                'ecm19' => $request->input('ecm19'),
                'ecm20' => $request->input('ecm20'),
                'ecm21' => $request->input('ecm21'),
                'ecm22' => $request->input('ecm22'),
                'ecm23' => $request->input('ecm23'),
                'ecm24' => $request->input('ecm24'),
                'ecm25' => $request->input('ecm25'),
                'ecm26' => $request->input('ecm26'),
                'ecm27' => $request->input('ecm27'),
                'ecm28' => $request->input('ecm28'),
                'ecm29' => $request->input('ecm29'),
                'ecm30' => $request->input('ecm30'),
                'ecm31' => $request->input('ecm31'),
                'ecm32' => $request->input('ecm32'),
                'fk_alu_id_ecomling' => $alunoId // Use a variável correta aqui
            ]);

            // Retorna uma resposta (redireciona ou exibe uma mensagem)
            return redirect()->back()->with('success', 'Dados salvos com sucesso!');
        } catch (\Exception $e) {
            // Trate o erro caso ocorra algum problema durante a inserção
            return redirect()->back()->with('error', 'Erro ao salvar dados: ' . $e->getMessage());
        }
    }
}
