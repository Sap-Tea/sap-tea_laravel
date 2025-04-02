<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilEstudante extends Model
{
    protected $primaryKey = 'id_perfil';

    protected $table = 'perfil_estudante';
    protected $fillable = ['diag_laudo', 'cid','nome_medico','data_laudo',
    'nivel_suporte','uso_medicamento','quais_medicamento','nec_pro_apoio','prof_apoio','loc_01','loc_02',
    'hig_02','ali_03','com_04','out_05','out_momentos','at_especializado','nome_prof_AEE','fk_id_aluno'    ];
    public $timestamps = false; // Desabilita o uso de timestamps



   
}

