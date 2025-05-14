<?php
namespace App\Http\Controllers;

use App\Models\EixoComportamento;
use App\Models\EixoComunicacaoLinguagem;
use App\Models\EixoInteracaoSocEmocional;
use App\Models\PreenchimentoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InserirEixoEstudanteController extends Controller
{
    public function inserir_eixo_estudante(Request $request, $id = null)
    {
        // Log detalhado para depuração
        \Log::info('=== INÍCIO DA REQUISIÇÃO DE INSERÇÃO DE INVENTÁRIO ===');
        \Log::info('Dados recebidos no formulário:', $request->all());
        \Log::info('ID do aluno da rota:', ['id' => $id]);
        \Log::info('URL da requisição:', ['url' => $request->fullUrl()]);
        \Log::info('Método da requisição:', ['method' => $request->method()]);
        \Log::info('Cabeçalhos da requisição:', $request->headers->all());
        
        // Obtenção do ID do aluno a partir do parâmetro da rota ou do formulário
        $alunoId = $id ?? $request->input('aluno_id');
        
        if (!$alunoId) {
            \Log::error('ID do aluno não fornecido');
            return response()->json([
                'success' => false,
                'message' => 'ID do aluno não fornecido.',
                'data' => $request->all(),
                'id_da_rota' => $id
            ], 400);
        }
        $data_inventario = $request->input('data_inicio_inventario');
        $fase_inventario = "In";

        
        // Verificar se a data é válida e formatá-la
        $dataInventario_formatada = null; // Inicializa a variável

        if ($data_inventario) {
            try {
                $dataInventario_formatada = Carbon::createFromFormat('Y-m-d', $data_inventario)->format('Y-m-d');
            } catch (\Exception $e) {
                // Se a data for inválida, defina um valor padrão ou retorne um erro
                $dataInventario_formatada = date('Y-m-d'); // Define a data atual como padrão
                // Ou então:
                // return redirect()->back()->with('error', 'Data de inventário inválida.');
            }
        } else {
            $dataInventario_formatada = date('Y-m-d'); // Define a data atual como padrão se $data_inventario for nulo
        }

        
        // Validação dos dados enviados pelo formulário
        $request->validate([
            // Validação para Eixo Comunicação e Linguagem
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
            'ecm32' => 'required|in:1,0',

            // Validação para Eixo Comportamento
            'ecp01' => 'required|in:1,0',
            'ecp02' => 'required|in:1,0',
            'ecp03' => 'required|in:1,0',
            'ecp04' => 'required|in:1,0',
            'ecp05' => 'required|in:1,0',
            'ecp06' => 'required|in:1,0',
            'ecp07' => 'required|in:1,0',
            'ecp08' => 'required|in:1,0',
            'ecp09' => 'required|in:1,0',
            'ecp10' => 'required|in:1,0',
            'ecp11' => 'required|in:1,0',
            'ecp12' => 'required|in:1,0',
            'ecp13' => 'required|in:1,0',
            'ecp14' => 'required|in:1,0',
            'ecp15' => 'required|in:1,0',
            'ecp16' => 'required|in:1,0',
            'ecp17' => 'required|in:1,0',


                
                //validando os campos de eixo interacao socio emocional
                'eis01' => 'required|in:1,0',
                'eis02' => 'required|in:1,0',
                'eis03' => 'required|in:1,0',
                'eis04' => 'required|in:1,0',
                'eis05' => 'required|in:1,0',
                'eis06' => 'required|in:1,0',
                'eis07' => 'required|in:1,0',
                'eis08' => 'required|in:1,0',
                'eis09' => 'required|in:1,0',
                'eis10' => 'required|in:1,0',
                'eis11' => 'required|in:1,0',
                'eis12' => 'required|in:1,0',
                'eis13' => 'required|in:1,0',
                'eis14' => 'required|in:1,0',
                'eis15' => 'required|in:1,0',
                'eis16' => 'required|in:1,0',
                'eis17' => 'required|in:1,0',
                'eis18' => 'required|in:1,0',

                'responsavel'=> 'required|in:1,0',
                'suporte'=> 'required|in:1,2,3',
                'comunicacao'=> 'required|in:1,2,3'
                
                

        ]);

        try {
            // Inserção no EixoComunicaçãoLinguagem
            $eixoComunicacao = EixoComunicacaoLinguagem::create([
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
                'fk_alu_id_ecomling' => $alunoId,
                'data_insert_com_lin'=> $dataInventario_formatada,
                'fase_inv_com_lin'=> $fase_inventario
            ]);

            // Inserção no EixoComportamento
            $eixoComportamento = EixoComportamento::create([
                'ecp01' => $request->input('ecp01'),
                'ecp02' => $request->input('ecp02'),
                'ecp03' => $request->input('ecp03'),
                'ecp04' => $request->input('ecp04'),
                'ecp05' => $request->input('ecp05'),
                'ecp06' => $request->input('ecp06'),
                'ecp07' => $request->input('ecp07'),
                'ecp08' => $request->input('ecp08'),
                'ecp09' => $request->input('ecp09'),
                'ecp10' => $request->input('ecp10'),
                'ecp11' => $request->input('ecp11'),
                'ecp12' => $request->input('ecp12'),
                'ecp13' => $request->input('ecp13'),
                'ecp14' => $request->input('ecp14'),
                'ecp15' => $request->input('ecp15'),
                'ecp16' => $request->input('ecp16'),
                'ecp17' => $request->input('ecp17'),
                'fk_alu_id_ecomp' => $alunoId,
                'data_insert_comportamento'=> $dataInventario_formatada,
                'fase_inv_comportamento'=> $fase_inventario

            ]);
            $eixo_socio_emocional = EixoInteracaoSocEmocional::create([
                'eis01' => $request->input('eis01'),
                'eis02' => $request->input('eis02'),
                'eis03' => $request->input('eis03'),
                'eis04' => $request->input('eis04'),
                'eis05' => $request->input('eis05'),
                'eis06' => $request->input('eis06'),
                'eis07' => $request->input('eis07'),
                'eis08' => $request->input('eis08'),
                'eis09' => $request->input('eis09'),
                'eis10' => $request->input('eis10'),
                'eis11' => $request->input('eis11'),
                'eis12' => $request->input('eis12'),
                'eis13' => $request->input('eis13'),
                'eis14' => $request->input('eis14'),
                'eis15' => $request->input('eis15'),
                'eis16' => $request->input('eis16'),    
                'eis17' => $request->input('eis17'),
                'eis18' => $request->input('eis18'),    
                'fk_alu_id_eintsoc' => $alunoId ,
                'data_insert_int_socio'=> $dataInventario_formatada,
                'fase_inv_int_socio'=> $fase_inventario


            ]);
                   $preenchimento_inventario = PreenchimentoInventario::create([
                    'professor_responsavel'=>$request->input('responsavel'),
                    'nivel_suporte'=>$request->input('suporte'),
                    'nivel_comunicacao'=>$request->input('comunicacao'),
                    'fase_inv_preenchimento'=>$fase_inventario,
                    'fk_id_aluno' => $alunoId,
                    'data_cad_inventario'=> $dataInventario_formatada
                    
                ]);



            DB::statement('UPDATE aluno SET flag_inventario = ? WHERE alu_id = ?', ['*', $alunoId]);
            // Retorno de sucesso
            return redirect('sondagem/eixos-estudante')->with('success', 'Dados salvos com sucesso!');
        } catch (\Exception $e) {
            // Tratamento de erro
            return redirect()->back()->with('error', 'Erro ao salvar dados: '.$e->getMessage());
        }
    }
}
