<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function instituicao()
    {
        return view('cadastro.instituicao');
    }

    public function orgao()
    {
        return view('cadastro.orgao');
    }

    public function escola()
    {
        return view('cadastro.escola');
    }

    public function aluno()
    {
        return view('cadastro.aluno');
    }

    public function servidores()
    {
        return view('cadastro.servidores');
    }
}
