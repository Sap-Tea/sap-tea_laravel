<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreenchimentoInventario extends Model
{
    public $timestamps = false;
    protected $table = 'preenchimento_sondagem';
    protected $primaryKey = 'id_preenchimento';
    protected $fillable = ['resp_prof_regular','resp_prof_aee',
                'nivel_1','nivel_2','nivel_3',
                'nivel_com_verbal','nivel_com_metodos','nivel_com_nao_verbal',
                'fase_inv_preenchimento','fk_id_aluno','data_cad_inventario'
    ];
}     
    
