<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    protected $table = 'modalidade';
    protected $primaryKey = 'id_modalidade';

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'fk_cod_mod', 'id_modalidade');
    }
}
