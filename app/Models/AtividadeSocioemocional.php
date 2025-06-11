<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeSocioemocional extends Model
{
    /**
     * Nome da tabela no banco de dados
     *
     * @var string
     */
    protected $table = 'cad_ativ_eixo_int_socio';
    
    /**
     * Campos que podem ser preenchidos em massa
     *
     * @var array
     */
    protected $fillable = [
        'aluno_id',
        'cod_atividade',
        'data_aplicacao',
        'realizado',
        'observacoes',
        'fase_cadastro'
    ];
    
    /**
     * Conversões de tipos
     *
     * @var array
     */
    protected $casts = [
        'data_aplicacao' => 'date',
        'realizado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**
     * Relacionamento com o modelo Aluno
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }
}
