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
use App\Http\Controllers\InserirEixoEstudanteController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\EscolaController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\OrgaoController;
use App\Http\Controllers\downloadController;
use App\Http\Controllers\VisualizaInventarioEstudanteController;
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
//rotas de perfil estudante 
Route::get('/alunos/{id}', [AlunoController::class, 'index'])->name('alunos.index');

Route::get('/perfil-estudante/{id}', [PerfilEstudanteController::class, 'mostrar'])
    ->name('perfil.estudante.mostrar');

    // rotas que visualiza e altera perfil do estudante
Route::get('/visualizar-perfil/{id}', [AtualizaPerfinEstudante::class, 'atualizaPerfil'])->name('visualizar.perfil');
Route::post('/atualizaperfil/{id}', [AtualizacaoPerfilController::class, 'AtualizaPerfil'])->name('atualiza.perfil.estudante');

    // rotas que visualiza e imprime inventario de estudandtes
  
   // Route::post('/atualizaperfil/{id}', [AtualizacaoPerfilController::class, 'AtualizaPerfil'])->name('atualiza.perfil.estudante');
    



Route::post('/inserir_perfil', [InserirPerfilEstudante::class, 'inserir_perfil_estudante'])->name('inserir_perfil');




Route::get('/imprime-aluno', [ImprimeAlunoController::class, 'imprimeAluno'])->name('imprime_aluno');
Route::post('/atualizar-perfil', [AtualizacaoPerfilController::class, 'atualizar'])->name('atualizar.perfil');




// Grupo de rotas para sondagens
Route::prefix('sondagem')->group(function () {
    Route::get('/eixos-estudante', [PerfilEstudanteController::class, 'index_inventario'])->name('eixos.alunos');

    Route::get('/cadastra-inventario/{id}', [AlunoController::class, 'mostra_aluno_inventario'])->name('alunos.inventario');
    Route::post('inserir_inventario', [InserirEixoEstudanteController::class, 
'inserir_eixo_estudante'])->name('inserir_inventario');

    Route::get('/visualizar-inventario/{id}', [AlunoController::class, 'visualiza_aluno_inventario'])->name('visualizar.inventario');
    // Route::get('/inicial', [AlunoController::class, 'index'])->name('alunos.index');
    Route::get('/inicial', [SondagemInicialController::class, 'inicial'])->name('sondagem.inicial');
    Route::get('/continuada1', [SondagemInicialController::class, 'continuada1'])->name('sondagem.continuada1');
    Route::get('/continuada2', [SondagemInicialController::class, 'continuada2'])->name('sondagem.continuada2');
    Route::get('/final', [SondagemInicialController::class, 'final'])->name('sondagem.final');
});
//minha alteracao
Route::get('/inicial', [SondagemInicialController::class, 'inicial'])->name('sondagem.inicial');


Route::get('/modalidade-ensino/inicial', [EnsinoController::class, 'inicial'])->name('modalidade.inicial');

Route::get('/perfil-estudante', [PerfilEstudanteController::class, 'index'])->name('perfil.estudante');


// criando uma rota para acessar foccus-xampp
Route::get('/foccus-xampp', function () {
    return redirect()->away('http://localhost/proj_foccus/index.php');
})->name('foccus.xampp');



// Rota para o órgão
Route::get('/orgao', [OrgaoController::class, 'index'])->name('orgao');
// Rota para a Instituição
Route::get('/instituicao', [InstituicaoController::class, 'index'])->name('instituicao');

// Rota para a Escola
Route::get('/escola', [EscolaController::class, 'index'])->name('escola');

// Rota para o Aluno
Route::get('/alunos', [AlunosController::class, 'index'])->name('alunos');

// Rota para o download
Route::get('/download', [downloadController::class, 'index'])->name('download');
