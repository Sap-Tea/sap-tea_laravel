<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilEstudante extends Model
{
    protected $primaryKey = 'id_perfil';

    protected $table = 'perfil_estudante';
    protected $fillable = [
        'diag_laudo', 'cid', 'nome_medico', 'data_laudo', 'nivel_suporte', 
        'uso_medicamento', 'quais_medicamento', 'nec_pro_apoio', 'prof_apoio', 
        'loc_01', 'hig_02', 'ali_03', 'com_04', 'out_05', 'out_momentos', 
        'at_especializado', 'nome_prof_AEE', 'fk_id_aluno', 'update_count',
        // Campos de personalidade
        'carac_principal', 'inter_princ_carac', 'livre_gosta_fazer', 'feliz_est', 
        'trist_est', 'obj_apego',
        // Campos de comunicação
        'precisa_comunicacao', 'entende_instrucao', 'recomenda_instrucao',
        // Campos de sensibilidade
        's_auditiva', 's_visual', 's_tatil', 's_outros', 'maneja_04',
        // Campos de alimentação
        'asa_04', 'alimentos_pref_04', 'alimento_evita_04',
        // Campos de interação e contato
        'contato_pc_04', 'reage_contato', 'interacao_escola_04',
        // Campos de aprendizado
        'interesse_atividade_04', 'aprende_visual_04', 'recurso_auditivo_04', 
        'material_concreto_04', 'outro_identificar_04', 'descricao_outro_identificar_04',
        'realiza_tarefa_04', 'mostram_eficazes_04', 'prefere_ts_04',
        // Campos da família
        'expectativa_05', 'estrategia_05', 'crise_esta_05'
    ];
    public $timestamps = false; // Desabilita o uso de timestamps



   
}

