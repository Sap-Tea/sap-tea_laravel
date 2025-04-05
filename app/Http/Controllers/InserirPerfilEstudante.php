<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PerfilEstudante;
use App\Models\PersonalidadeAluno;
use App\Models\Comunicacao;
use App\Models\Preferencia;
use App\Models\PerfilFamilia;
use App\Models\AlunoFlagPerfilEstudante;
use Illuminate\Support\Facades\DB;

class InserirPerfilEstudante extends Controller
{
    public function inserir_perfil_estudante(Request $request)
    {
        if (!$request->has('diag_laudo') || !in_array($request->input('diag_laudo'), [0, 1])) {
            return response()->json(['message' => 'Valor inválido para diag_laudo. Deve ser 0 ou 1'], 400);
        }
        
        if (!$request->has('uso_medicamento') || !in_array($request->input('uso_medicamento'), [0, 1])) {
            return response()->json(['message' => 'Valor inválido para diag_laudo. Deve ser 0 ou 1'], 400);
        }

    
        if (!$request->has('nivel_suporte') || !in_array($request->input('nivel_suporte'), [1, 2, 3])) {
            return response()->json(['message' => 'Valor inválido para o nivel de suporte. Deve ser 1,2,3'], 400);
        }

        if (!$request->has('nec_pro_apoio') || !in_array($request->input('nec_pro_apoio'), [0, 1])) {
            return response()->json(['message' => 'Valor inválido para o nivel de suporte. Deve ser 1,2,3'], 400);
        }

        //validacao de comunicacao

        if (!$request->has('precisa_comunicacao') || !in_array($request->input('precisa_comunicacao'), [0, 1])) {
            return response()->json(['message' => 'Valor inválido para precisa_comunicacao. Deve ser 0 ou 1'], 400);
        }
        if (!$request->has('entende_instrucao') || !in_array($request->input('entende_instucao'), [0, 1])) {
            return response()->json(['message' => 'Valor inválido para entende_instrucao. Deve ser 0 ou 1'], 400);
        }


          $loc_01 =0;
          $hig_02 =0;
          $ali_03 =0;
          $com_04 = 0;
          $out_05 = 0;


       if(isset($_POST['locomocao']))
            {
                $loc_01 = 1;
            }
         if(isset($_POST['higiene']))
            {
                $hig_02 = 1;
            }
            if(isset($_POST['alimentacao']))
            {
                $ali_03 = 1;
            }
            if(isset($_POST['comunicacao']))
            {
                $com_04 = 1;
            }
            if(isset($_POST['outros']))
            {
                $out_05 = 1;
            }
            
            //Validando campos preferencia
            
            
            if(isset($_POST['s_auditiva'])){
               $auditivo_04 = 1;
            }
            else
            {
                $auditivo_04 = 0;
            }
                       
            if(isset($_POST['s_visual'])){
                $visual_04 = 1;
             }
             else
             {
                 $visual_04 = 0;
             }
                         
             if(isset($_POST['s_tatil'])){
                $tatil_04 = 1;
             }
             else
             {
                 $tatil_04 = 0;
             }
        
             if(isset($_POST['s_outros'])){
                $s_outros = 1;
             }
             else
             {
                 $s_outros = 0;
             }

             if (!$request->has('seletividade_alimentar') || !in_array($request->input('seletividade_alimentar'), [0, 1])) {
                return response()->json(['message' => 'Valor inválido para seletividade alimentar. Deve ser 0 ou 1'], 400);
            }
         
            //validando checkbos preferencia
            
            if(isset($_POST['r_visual'])){
                $aprende_visual_04 = 1;
             }
             else
             {
                 $aprende_visual_04 = 0;
             }
                        
             if(isset($_POST['r_auditivo'])){
                 $recurso_auditivo_04 = 1;
              }
              else
              {
                  $recurso_auditivo_04 = 0;
              }
                          
              if(isset($_POST['m_concreto'])){
                 $material_concreto_04 = 1;
              }
              else
              {
                $material_concreto_04 = 0;
              }
         
              if(isset($_POST['o_outro'])){
                $outro_identificar_04 = 1;
              }
              else
              {
                $outro_identificar_04 = 0;

              }
         
             //carregando o alu_id do aluno para todas as tabelas do perfil do estudante
             $alunoId = $request->input('aluno_id');

        try {
            $perfilEstudante = PerfilEstudante::create([
                'diag_laudo' => $request->input('diag_laudo'),
                'cid' => $request->input('cid'),
                'nome_medico' => $request->input('nome_medico'),
                'data_laudo' => $request->input('data_laudo'),
                'nivel_suporte'=> $request->input('nivel_suporte'),
                 'uso_medicamento'=>$request->input('uso_medicamento'),
                 'quais_medicamento'=>$request->input('quais_medicamento'),
                 'nec_pro_apoio'=>$request->input('nec_pro_apoio'),
                 'loc_01' => $loc_01,
                 'hig_02'=>$hig_02,
                 'ali_03'=>$ali_03,
                 'com_04'=>$com_04,
                 'out_05'=>$out_05,
                 'out_momentos'=>$request->input('outros'),
                 'at_especializado'=>$request->input('at_especializado'),
                 'fk_id_aluno'=>$alunoId
            ]);
            
            $personalidade = PersonalidadeAluno::create([
                'carac_principal'=>$request->input('caracteristicas'),
                'inter_princ_carac'=>$request->input('areas_interesse'),
                'livre_gosta_fazer'=>$request->input('atividades_livre'),
                'feliz_est'=>$request->input('feliz'),
               'trist_est'=>$request->input('triste'),
                'obj_apego'=>$request->input('objeto_apego'),
                'fk_id_aluno'=>$alunoId

            ]);
                $comunicacao = Comunicacao::create([
                    'precisa_comunicacao'=>$request->input('precisa_comunicacao'),
                    'entende_instrucao'=>$request->input('entende_instrucao'),
                    'recomenda_instrucao'=>$request->input('recomenda_instrucao'),
                    'fk_id_aluno'=>$alunoId
                ]);
                    
                $preferencia = Preferencia::create([
                'auditivo_04'=>$auditivo_04,
                'visual_04'=>$visual_04,
                'tatil_04'=>$tatil_04,
                'outros_04'=>$s_outros,
                'maneja_04'=>$request->input('manejo_sensibilidade'),
                'asa_04'=>$request->input('seletividade_alimentar'),
                'alimentos_pref_04'=>$request->input('alimentos_preferidos'),
                'alimento_evita_04'=>$request->input('alimentos_evita'),

                'contato_pc_04'=>$request->input('afinidade_escola'),
                'reage_contato'=>$request->input('reacao_contato'),
                'interacao_escola_04'=>$request->input('interacao_escola'),
                'interesse_atividade_04'=>$request->input('interesse_atividade'),

                 'aprende_visual_04'=>$aprende_visual_04,
                 'recurso_auditivo_04'=>$recurso_auditivo_04,
                'material_concreto_04'=>$material_concreto_04,
                'outro_identificar_04'=>$outro_identificar_04,
                'descricao_outro_identificar_04'=>$request->input('outro_identificar'),
                'prefere_ts_04'=>$request->input('atividades_grupo'),
                'mostram_eficazes_04'=>$request->input('estrategias_eficazes'),
                'realiza_tarefa_04'=>$request->input('interesse_tarefa'),
                'fk_id_aluno'=>$alunoId


                ]);        

                $PerfilFamilia = PerfilFamilia::create([
                     'expectativa_05' =>$request->input('expectativas_familia'),
                     'estrategia_05' => $request->input('estrategias_familia'),
                     'crise_esta_05'=>$request->input('crise_estresse') ,
                     
                      'fk_id_aluno'=>$alunoId 

                ]);
                DB::statement('UPDATE aluno SET flag_perfil = ? WHERE alu_id = ?', ['*', $alunoId]);



            // Retorne uma mensagem de sucesso
            return redirect()->route('imprime_aluno')->with('message', 'Perfil criado com sucesso');

        } catch (\Exception $e) {
            // Retorne uma mensagem de erro
            return response()->json(['message' => 'Erro ao criar perfil: ' . $e->getMessage()], 500);
        }

   




    }







}
