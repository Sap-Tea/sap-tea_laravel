<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ControllerPerfil;
use App\Http\Controllers\SondagemController;
use App\Http\Controllers\SondagemInicialController;
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
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\VisualizaInventarioEstudanteController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\GeneratePDFController;
use App\Http\Controllers\GenerateTemplatePDFController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da sua aplicação.
| Essas rotas são carregadas pelo RouteServiceProvider dentro do grupo "web".
|
*/

// Rota raiz redireciona para /index
Route::get('/', function () {
    return redirect('/index');
});
Route::get('/index', function () {
    return view('index');
})->name('index');

// Logout
use Illuminate\Http\Request;
Route::post('/logout', function (Request $request) {
    auth()->guard('funcionario')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login')->with('status', 'Sessão encerrada com sucesso!');
})->name('logout');

// Rota para exibir resultado do aluno em JSON
Route::get('/sondagem/resultado-aluno/{alu_id}', [SondagemController::class, 'resultadoAluno']);

// Rota para gerar o template PDF
Route::get('/generate-template-pdf', [GenerateTemplatePDFController::class, 'generateTemplate'])->name('generate.template.pdf');

// Páginas estáticas
Route::get('/sobre-nos', [SobreNosController::class, 'sobreNos'])->name('sobre-nos');
Route::get('/contato', [ContatoController::class, 'contato'])->name('contato');

// Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Recuperação de senha padrão Laravel
Route::get('/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

// Troca de senha no primeiro acesso
Route::get('/password/first-change', [AuthController::class, 'showFirstChangeForm'])->name('password.first.change');
Route::post('/password/first-change', [AuthController::class, 'processFirstChange']);

// Primeiro acesso (email + CPF)
Route::get('/primeiro-acesso', [AuthController::class, 'showPrimeiroAcessoForm'])->name('primeiro.acesso');
Route::post('/primeiro-acesso', [AuthController::class, 'primeiroAcesso']);

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
// Rotas de perfil estudante 
Route::get('/alunos/{id}', [AlunoController::class, 'index'])->name('alunos.index');
Route::get('/perfil-estudante/{id}', [PerfilEstudanteController::class, 'mostrar'])
    ->name('perfil.estudante.mostrar');

// Rotas de visualização e atualização de perfil
Route::get('/visualizar-perfil/{id}', [AtualizaPerfinEstudante::class, 'atualizaPerfil'])
    ->name('visualizar.perfil');
Route::post('/atualizaperfil/{id}', [AtualizacaoPerfilController::class, 'AtualizaPerfil'])
    ->name('atualiza.perfil.estudante');

// Inserir perfil
Route::post('/inserir_perfil', [InserirPerfilEstudante::class, 'inserir_perfil_estudante'])
    ->name('inserir_perfil');




Route::get('/imprime-aluno', [ImprimeAlunoController::class, 'imprimeAluno'])->name('imprime_aluno');
Route::post('/atualizar-perfil', [AtualizacaoPerfilController::class, 'atualizar'])->name('atualizar.perfil');




// Grupo de rotas para sondagens
Route::prefix('sondagem')->group(function () {
    // Rota para processar resultados dos três eixos
    Route::post('/processa-resultados/{alunoId}', [\App\Http\Controllers\ProcessaResultadosController::class, 'processaTodosEixos'])->name('processa_resultados');
    Route::get('/eixos-estudante', [PerfilEstudanteController::class, 'index_inventario'])->name('eixos.alunos');

    Route::get('/cadastra-inventario/{id}', [AlunoController::class, 'mostra_aluno_inventario'])->name('alunos.inventario');
    Route::post('/inserir_inventario/{id}', [InserirEixoEstudanteController::class, 'inserir_eixo_estudante'])->name('inserir_inventario');

    Route::get('/visualizar-inventario/{id}', [AlunoController::class, 'visualiza_aluno_inventario'])->name('visualizar.inventario');
    // Route::get('/inicial', [AlunoController::class, 'index'])->name('alunos.index');
    Route::get('/inicial', [SondagemInicialController::class, 'inicial'])->name('sondagem.inicial');
    Route::get('/continuada1', [SondagemInicialController::class, 'continuada1'])->name('sondagem.continuada1');
    Route::get('/continuada2', [SondagemInicialController::class, 'continuada2'])->name('sondagem.continuada2');
    Route::get('/final', [SondagemInicialController::class, 'final'])->name('sondagem.final');
});

//criando grupo de rota para rotina e monitoramento
// Rotas para rotina e monitoramento
Route::prefix('rotina_monitoramento')->group(function () {
    // Rota para página inicial de rotina e monitoramento
    Route::get('/rot_monit_inicial', [PerfilEstudanteController::class, 'rotina_monitoramento_inicial'])->name('rotina.monitoramento.inicial');
});




//minha alteracao
Route::get('/inicial', [SondagemInicialController::class, 'inicial'])->name('sondagem.inicial');
Route::get('/modalidade-ensino/inicial', [EnsinoController::class, 'inicial'])->name('modalidade.inicial');
Route::get('/perfil-estudante', [PerfilEstudanteController::class, 'index'])->name('perfil.estudante');
// Rota para exportar Excel
Route::post('/export/excel', [ExportExcelController::class, 'export'])->name('export.excel');
// Rota para gerar PDF
Route::post('/gerar/pdf', [GeneratePDFController::class, 'generatePDF'])->name('gerar.pdf');


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


use App\Http\Controllers\SomeController;  // Certifique-se de incluir o controlador

// Rota para "Como Eu Sou"
Route::get('/como-eu-sou', [SomeController::class, 'comoEuSou'])->name('como-eu-sou');

// Rota para "Emociômetro"
Route::get('/emociometro', [SomeController::class, 'emociometro'])->name('emociometro');

// Rota para "Minha Rede de Ajuda"
Route::get('/minha-rede-de-ajuda', [SomeController::class, 'minhaRedeDeAjuda'])->name('minha-rede-de-ajuda');

// Rota para gerar PDF
Route::post('/gerar-pdf', [GeneratePDFController::class, 'generatePDF'])->name('gerar.pdf');
// Rotas comentadas porque DocumentController não existe e está causando erro
// Route::post('/download-word', [DocumentController::class, 'generateWordExcel'])->name('download.word');
// Route::post('/download-excel', [DocumentController::class, 'downloadExcel'])->name('download.excel');
// Route::post('/download-pdf', [DocumentController::class, 'downloadPDF'])->name('download.pdf');


Route::get('/teste-email', function () {
    \Mail::raw('Teste de email do Laravel', function($message) {
        $message->to('marcosbarroso.info@gmail.com')->subject('Teste');
    });
    return 'Email enviado!';
});