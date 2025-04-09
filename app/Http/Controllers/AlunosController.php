<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunosController extends Controller
{
    public function index()
    {
        return view('alunos.index'); // Retorna a view do Alunos
    }
}
