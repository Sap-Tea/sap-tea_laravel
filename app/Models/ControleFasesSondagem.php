<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleFasesSondagem extends Model
{

    protected $table = 'controle_fases_sondagem';

    protected $fillable = [
        'id_aluno',
        'ano',
        'fase_inicial',
        'cont_I',
        'fase_cont1',
        'cont_fase_c1',
        'fase_cont2',
        'cont_fase_c2',
        'fase_final',
        'cont_fase_final',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'id_aluno', 'alu_id');
    }
}
