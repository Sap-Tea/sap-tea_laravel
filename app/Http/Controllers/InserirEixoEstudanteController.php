<?php

namespace App\Http\Controllers;

use App\Models\EixoComportamento;
use App\Models\EixoComunicacaoLinguagem;
use App\Models\EixoInteracaoSocEmocional;
use Illuminate\Http\Request;

class InserirEixoEstudanteController extends Controller
{
    public function inserir_eixo_estudante(Request $request)
    {
        // Obtenção do ID do aluno
        $alunoId = $request->input('aluno_id');

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
            'ecp1' => 'required|in:1,0',
            'ecp2' => 'required|in:1,0',
            'ecp3' => 'required|in:1,0',
            'ecp4' => 'required|in:1,0',
            'ecp5' => 'required|in:1,0',
            'ecp6' => 'required|in:1,0',
            'ecp7' => 'required|in:1,0',
            'ecp8' => 'required|in:1,0',
            'ecp9' => 'required|in:1,0',
            'ecp10' => 'required|in:1,0',
            'ecp11' => 'required|in:1,0',
            'ecp12' => 'required|in:1,0',
            'ecp13' => 'required|in:1,0',
            'ecp14' => 'required|in:1,0',
            'ecp15' => 'required|in:1,0',
            'ecp16' => 'required|in:1,0',
            'ecp17' => 'required|in:1,0',


                
                //validando os campos de eixo interacao socio emocional
                'eis1' => 'required|in:1,0',
                'eis2' => 'required|in:1,0',
                'eis3' => 'required|in:1,0',
                'eis4' => 'required|in:1,0',
                'eis5' => 'required|in:1,0',
                'eis6' => 'required|in:1,0',
                'eis7' => 'required|in:1,0',
                'eis8' => 'required|in:1,0',
                'eis9' => 'required|in:1,0',
                'eis10' => 'required|in:1,0',
                'eis11' => 'required|in:1,0',
                'eis12' => 'required|in:1,0',
                'eis13' => 'required|in:1,0',
                'eis14' => 'required|in:1,0',
                'eis15' => 'required|in:1,0',
                'eis16' => 'required|in:1,0',
                'eis17' => 'required|in:1,0',
                'eis18' => 'required|in:1,0'
                

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
                'fk_alu_id_ecomling' => $alunoId
            ]);

            // Inserção no EixoComportamento
            $eixoComportamento = EixoComportamento::create([
                'ecp01' => $request->input('ecp1'),
                'ecp02' => $request->input('ecp2'),
                'ecp03' => $request->input('ecp3'),
                'ecp04' => $request->input('ecp4'),
                'ecp05' => $request->input('ecp5'),
                'ecp06' => $request->input('ecp6'),
                'ecp07' => $request->input('ecp7'),
                'ecp08' => $request->input('ecp8'),
                'ecp09' => $request->input('ecp9'),
                'ecp10' => $request->input('ecp10'),
                'ecp11' => $request->input('ecp11'),
                'ecp12' => $request->input('ecp12'),
                'ecp13' => $request->input('ecp13'),
                'ecp14' => $request->input('ecp14'),
                'ecp15' => $request->input('ecp15'),
                'ecp16' => $request->input('ecp16'),
                'ecp17' => $request->input('ecp17'),
                'fk_alu_id_ecomp' => $alunoId
            ]);
            $eixo_socio_emocional = EixoInteracaoSocEmocional::create([
                'eis01' => $request->input('eis1'),
                'eis02' => $request->input('eis2'),
                'eis03' => $request->input('eis3'),
                'eis04' => $request->input('eis4'),
                'eis05' => $request->input('eis5'),
                'eis06' => $request->input('eis6'),
                'eis07' => $request->input('eis7'),
                'eis08' => $request->input('eis8'),
                'eis09' => $request->input('eis9'),
                'eis10' => $request->input('eis10'),
                'eis11' => $request->input('eis11'),
                'eis12' => $request->input('eis12'),
                'eis13' => $request->input('eis13'),
                'eis14' => $request->input('eis14'),
                'eis15' => $request->input('eis15'),
                'eis16' => $request->input('eis16'),    
                'eis15' => $request->input('eis17'),
                'eis16' => $request->input('eis18'),    
                'fk_alu_id_eintsoc' => $alunoId // Use a variável correta aqui

            ]);








            // Retorno de sucesso
            return redirect()->back()->with('success', 'Dados salvos com sucesso!');
        } catch (\Exception $e) {
            // Tratamento de erro
            return redirect()->back()->with('error', 'Erro ao salvar dados: '.$e->getMessage());
        }
    }
}
