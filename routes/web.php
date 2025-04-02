<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ControllerPerfil;
use App\Http\Controllers\SondagemController;
use App\Http\Controllers\SondagemInicialController;
use App\Http\Controllers\TesteController;
use App\Http\Controllers\PerfilEstudanteController;
use App\Http\Controllers\EnsinoController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AtualizaPerfinEstudante;
use App\Http\Controllers\ImprimeAlunoController;
use App\Http\Controllers\InserirPerfilEstudante;
use App\Http\Controllers\AtualizacaoController;
use App\Http\Controllers\AtualizacaoPerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da sua aplicação.
| Essas rotas são carregadas pelo RouteServiceProvider dentro do grupo "web".
|
*/

// Rota de teste
Route::get('/teste', [TesteController::class, 'teste']);

// Rota principal
Route::get('/', 'PrincipalController@Principal');

// Sobre nós
Route::get('/Sobre-nos', 'SobreNosController@sobreNos');
// Contato
Route::get('/contato', 'ContatoController@contato');

// Login
Route::get('/login', 'Authcontroller@showLoginForm')->name('login');

// Página inicial (index)
Route::get('/index', function () {
    return view('index');
})->name('index');

//criar um grupo de rota chamada cadastro
//criar uma rota get
//criar uma rota post








// Sondagem inicial
Route::get('/sondagem-inicial', [SondagemController::class, 'index'])->name('sondagem.inicial');

// Formulário (exemplo)
Route::get('/formulario', function () {
    return view('formulario');
})->name('formulario.view');

Route::post('/formulario-submit', function (Request $request) {
    // Processar os dados do formulário aqui
    return back()->with('success', 'Formulário enviado com sucesso!');
})->name('formulario.submit');

/*Grupo de rotas para professores
Route::group(['prefix' => 'professor'], function () {
    Route::get('/imprime-aluno', [ControllerPerfil::class, 'imprimeAluno'])->name('aluno.perfil');
});
*/
// cadastra do Estudante (com ID)
Route::get('/alunos/{id}', [AlunoController::class, 'index'])->name('alunos.index');



 Route::get('/perfil-estudante/{id}', [PerfilEstudanteController::class, 'mostrar'])
->name('perfil.estudante.mostrar');

Route::get('/visualizar-perfil/{id}', [AtualizaPerfinEstudante::class, 'atualizaPerfil'])->name('visualizar.perfil');



Route::post('/atualizaperfil/{id}', [AtualizacaoPerfilController::class, 'AtualizaPerfil'])->name('atualiza.perfil.estudante');
Route::post('/inserir_perfil', [InserirPerfilEstudante::class, 'inserir_perfil_estudante'])->name('inserir_perfil');
Route::get('/imprime-aluno', [ImprimeAlunoController::class, 'imprimeAluno'])->name('imprime_aluno');

//rota para salvar as alteracoes do perfil de estudante
// routes/web.php



Route::post('/atualizar-perfil', [AtualizacaoPerfilController::class, 'atualizar'])->name('atualizar.perfil');




// Grupo de rotas para sondagens
Route::prefix('sondagem')->group(function () {
    // Route::get('/inicial', [AlunoController::class, 'index'])->name('alunos.index');
    Route::get('/inicial', [SondagemInicialController::class, 'inicial'])->name('sondagem.inicial');
    Route::get('/continuada1', [SondagemInicialController::class, 'continuada1'])->name('sondagem.continuada1');
    Route::get('/continuada2', [SondagemInicialController::class, 'continuada2'])->name('sondagem.continuada2');
    Route::get('/final', [SondagemInicialController::class, 'final'])->name('sondagem.final');
});



// Modalidade de Ensino
Route::get('/modalidade-ensino/inicial', [EnsinoController::class, 'inicial'])->name('modalidade.inicial');

Route::get('/perfil-estudante', [PerfilEstudanteController::class, 'index'])->name('perfil.estudante');




//Route::post('/proj_foccus/index.php', 'SeuController@metodoSalvar'); 

/*
Route::get('/acessar-proj-foccus', function () {
    return redirect()->away('http://proj_foccus');
});
*/
