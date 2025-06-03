<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerfilEstudante;
use App\Models\PersonalidadeAluno;
use App\Models\Comunicacao;
use App\Models\Preferencia;
use App\Models\PerfilFamilia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AtualizacaoPerfilController extends Controller
{
    /**
     * Atualiza o perfil do estudante e redireciona para a página do perfil.
     */
    public function AtualizaPerfil(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // Atualiza perfil_estudante
        $perfil = \App\Models\PerfilEstudante::firstOrNew(['fk_id_aluno' => $id]);
        $perfil->fill($request->only([
            'diag_laudo', 'cid', 'nome_medico', 'data_laudo', 'nivel_suporte',
            'uso_medicamento', 'quais_medicamento', 'nec_pro_apoio', 'prof_apoio',
            'loc_01', 'hig_02', 'ali_03', 'com_04', 'out_05', 'out_momentos',
            'at_especializado', 'nome_prof_AEE', 'fk_id_aluno', 'update_count'
        ]));
        $perfil->fk_id_aluno = $id;
        $perfil->save();

        // Atualiza personalidade
        $personalidade = \App\Models\PersonalidadeAluno::firstOrNew(['fk_id_aluno' => $id]);
        $personalidade->fill($request->only([
            'carac_principal', 'inter_princ_carac', 'livre_gosta_fazer',
            'feliz_est', 'trist_est', 'obj_apego'
        ]));
        $personalidade->fk_id_aluno = $id;
        $personalidade->save();

        // Atualiza preferencia
        $preferencia = \App\Models\Preferencia::firstOrNew(['fk_id_aluno' => $id]);
        $preferencia->fill($request->only([
            'auditivo_04', 'visual_04', 'tatil_04', 'outros_04', 'maneja_04', 'asa_04',
            'alimentos_pref_04', 'alimento_evita_04', 'contato_pc_04', 'reage_contato',
            'interacao_escola_04', 'interesse_atividade_04', 'aprende_visual_04',
            'recurso_auditivo_04', 'material_concreto_04', 'outro_identificar_04',
            'descricao_outro_identificar_04', 'realiza_tarefa_04', 'mostram_eficazes_04',
            'prefere_ts_04'
        ]));
        $preferencia->fk_id_aluno = $id;
        $preferencia->save();

        // Atualiza perfil_familia
        $familia = \App\Models\PerfilFamilia::firstOrNew(['fk_id_aluno' => $id]);
        $familia->fill($request->only([
            'expectativa_05', 'estrategia_05', 'crise_esta_05'
        ]));
        $familia->fk_id_aluno = $id;
        $familia->save();

        DB::commit();

        // Redireciona para a tela anterior (formulário de edição)
        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage())
            ->withInput();
    }
}


    /**
     * Atualiza os dados na tabela PerfilEstudante.
     */
    private function atualizarPerfilEstudante($request, $id)
    {
        $perfil = PerfilEstudante::updateOrCreate(
            ['fk_id_aluno' => $id],
            $request->all()
        );
        
        return $perfil;
    }

    /**
     * Atualiza os dados na tabela PersonalidadeAluno.
     */
    private function atualizarPersonalidade($request, $id)
    {
        $model = PersonalidadeAluno::where('fk_id_aluno', $id)->firstOrFail();

        $model->update([
            'carac_principal' => $request->carac_principal,
            'inter_princ_carac' => $request->inter_princ_carac,
            'livre_gosta_fazer' => $request->livre_gosta_fazer,
            'feliz_est' => $request->feliz_est,
            'trist_est' => $request->trist_est,
            'obj_apego' => $request->obj_apego
        ]);
    }

    /**
     * Atualiza os dados na tabela Comunicacao.
     */
    private function atualizarComunicacao($request, $id)
    {
        $model = Comunicacao::where('fk_id_aluno', $id)->firstOrFail();

        $model->update([
            'precisa_comunicacao' => $request->precisa_comunicacao,
            'entende_instrucao' => $request->entende_instrucao,
            'recomenda_instrucao' => $request->recomenda_instrucao
        ]);
    }

    /**
     * Atualiza os dados na tabela Preferencia.
     */
    private function atualizarPreferencia($request, $id)
    {
        $model = Preferencia::where('fk_id_aluno', $id)->firstOrFail();

        $model->update([
            'auditivo_04' => $request->has('auditivo_04') ? 1 : 0,
            'visual_04' => $request->has('visual_04') ? 1 : 0,
            'tatil_04' => $request->has('tatil_04') ? 1 : 0,
            'outros_04' => $request->has('outros_04') ? 1 : 0,
            'maneja_04' => $request->maneja_04,
            'asa_04' => $request->asa_04,
            'alimentos_pref_04' => $request->alimentos_pref_04,
            'alimento_evita_04' => $request->alimento_evita_04,
            'contato_pc_04' => $request->contato_pc_04,
            'reage_contato' => $request->reage_contato,
            'interacao_escola_04' => $request->interacao_escola_04,
            'interesse_atividade_04' => $request->interesse_atividade_04,
            'aprende_visual_04' => $request->has('aprende_visual_04') ? 1 : 0,
            'recurso_auditivo_04' => $request->has('recurso_auditivo_04') ? 1 : 0,
            'material_concreto_04' => $request->has('material_concreto_04') ? 1 : 0,
            'outro_identificar_04' => $request->has('outro_identificar_04') ? 1 : 0,
            'descricao_outro_identificar_04' => $request->descricao_outro_identificar_04,
            'realiza_tarefa_04' => $request->realiza_tarefa_04,
            'mostram_eficazes_04' => $request->mostram_eficazes_04,
            'prefere_ts_04' => $request->prefere_ts_04
        ]);
    }

    /**
     * Atualiza ou cria os dados na tabela PerfilFamilia.
     */
    private function atualizarPerfilFamilia($request, $id)
    {
        PerfilFamilia::updateOrCreate(
            ['fk_id_aluno' => $id],
            [
                'expectativa_05' => $request->expectativa_05,
                'estrategia_05' => $request->estrategia_05,
                'crise_esta_05' => $request->crise_esta_05
            ]
        );
    }
}

