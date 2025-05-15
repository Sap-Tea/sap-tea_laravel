@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success" style="margin-top: 20px;">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" style="margin-top: 20px;">
        {{ session('error') }}
    </div>
@endif

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

</head>

<body>

        <form id="formInventario" method="POST" action="{{ route('inserir_inventario', ['id' => $aluno->alu_id]) }}">
    <input type="hidden" name="rota_anterior" id="rota_anterior" value="">
        <input type="hidden" name="aluno_id" value="{{ $aluno->alu_id }}">
@csrf
    <div class="menu">
        <img src="{{ asset('img/LOGOTEA.png') }}" alt="Logo" class="logo">
        <img src="{{ asset('img/logo_sap.png') }}" alt="Logo SAP" class="logo-right">

        <h1>SONDAGEM PEDAGÓGICA 1 - INICIAL</h1>
        <p>Secretaria de Educação do Município</p>
        <div class="fields">
            <div class="fields">
                <p>Data de inicio inventario:
                    <?php
                    $data_atual = date("d-m-Y");
                    echo '<input name = "data_inicio_inventario" type="text" value="' . $data_atual . '" readonly
                    style = "width: 80px"> ';
                    ?>
                </p>

            
            <p>Orgão: <input type="text" style="width: 300px;" value = "{{$alunoDetalhado->org_razaosocial}}" readonly></p>

            <p>Escola: <input type="text" style="width: 300px;" value = "{{$alunoDetalhado->esc_razao_social}}" readonly ></p>
            <p>Nome do Aluno: <input type="text" style="width: 250px;"value = "{{$aluno->alu_nome}}" readonly></p>
            
            <p>Data de Nascimento: <input type="date" value ="{{$aluno->alu_dtnasc}}" readonly>
                 Idade: <input value = "{{ \Carbon\Carbon::parse($aluno->alu_dtnasc)->age }} - anos" readonly type="text" min="0" style="width: 50px;"></p>
            <p>RA: <input type="text" style="width: 150px;" value = "{{$aluno->alu_ra}}" readonly>
                Turma:
                <input value = "{{$alunoDetalhado->fk_cod_valor_turma}}" type="text" style="width: 120px;" readonly>
                Período: <input type="text" style="width: 200px;" value = "{{$alunoDetalhado->desc_modalidade}}" readonly></p>
        </div>
        <div class="support">
            <p><strong>Responsável pelo preenchimento:</strong></p>
            <p><input type="radio" name="responsavel" class="radio-toggle" value = "1"> Professor de sala Regular</p>
            <p><input type="radio" name="responsavel" class="radio-toggle" value = "0"> Professor do Atendimento Educacional Especializado (AEE)</p>
            <p><strong>Assinale o nível de suporte necessário para o estudante:</strong></p>
            <p><input type="radio" name="suporte" class="radio-toggle" value = "1"> Nível 1 de Suporte - Exige pouco apoio</p>
            <p><input type="radio" name="suporte" class="radio-toggle" value = "2"> Nível 2 de Suporte - Exige apoio substancial</p>
            <p><input type="radio" name="suporte" class="radio-toggle" value = "3"> Nível 3 de Suporte - Exige apoio muito substancial</p>
            <p><strong>Assinale a forma de comunicação utilizada pelo estudante:</strong></p>
            <p><input type="radio" name="comunicacao" class="radio-toggle" value = "1"> Comunicação verbal</p>
            <p><input type="radio" name="comunicacao" class="radio-toggle" value = "2"> Comunicação não verbal com uso de métodos alternativos de comunicação</p>
            <p><input type="radio" name="comunicacao" class="radio-toggle" value = "3"> Comunicação não Verbal</p>
        </div>
    </div>
    <div id="capture">
        <h2>Cadastro de inventários</h2>
            <table>
                <thead>
                    <tr>
                        <th>INVENTÁRIO DE HABILIDADES - EIXO COMUNICAÇÃO/LINGUAGEM</th>
                        <th>Sim</th>
                        <th>Não</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Perguntas_eixo_comunicacao as $i_comunicacao => $comunicacao)
                    <tr style="background-color: #A1D9F6;">
                        <td>{{$comunicacao}}</td>
                        <td><input type="radio" name="ecm{{ sprintf('%02d', $i_comunicacao + 1) }}" value="1" required></td>
                        <td><input type="radio" name="ecm{{ sprintf('%02d', $i_comunicacao + 1) }}" value="0" required></td>
                    </tr>
                @endforeach
        </tbody>
        </table>
            <table>
                <thead>
                    <tr>
                        <th>INVENTÁRIO DE HABILIDADES - EIXO COMPORTAMENTO</th>
                        <th>Sim</th>
                        <th>Não</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perguntas_eixo_comportamento as $i_comportamento => $comportamento)
                    <tr style="background-color: #FFEB3B;">
                        <td>{{$comportamento}}</td>
                        <td><input type="radio" name="ecp{{ sprintf('%02d', $i_comportamento + 1) }}" value="1" required></td>
                        <td><input type="radio" name="ecp{{ sprintf('%02d', $i_comportamento + 1) }}" value="0" required></td>
                    </tr>
                @endforeach
        
        </tbody>
        </table>
            <table>
                <thead>
                    <tr>
                        <th>INVENTÁRIO DE HABILIDADES - EIXO INTERAÇÃO SOCIOEMOCIONAL</th>
                        <th>Sim</th>
                        <th>Não</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eixo_int_socio_emocional as $i_int_emocional => $intemocional)
                    <tr style="background-color: #d7EAD9 !important;">
                        <td>{{$intemocional}}</td>
                        <td><input type="radio" name="eis{{ sprintf('%02d', $i_int_emocional + 1) }}" value="1" required></td>
                        <td><input type="radio" name="eis{{ sprintf('%02d', $i_int_emocional + 1) }}" value="0" required></td>
                    </tr>
                @endforeach
        </tbody>
        </table>
    </div>
    <br>
    <div class="button-group">
    <button type="button" class="btn btn-primary" id="btnSalvar">Salvar</button>
    <!-- Modal de confirmação -->
    <div id="modalConfirmacao" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; padding:30px; border-radius:8px; max-width:350px; margin:auto; text-align:center;">
            <p id="mensagemConfirmacao"></p>
            <button type="button" id="confirmarEnvio" class="btn btn-success" style="margin-right:10px;">Confirmar</button>
            <button type="button" id="cancelarEnvio" class="btn btn-danger">Cancelar</button>
        </div>
    </div>

        <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        
    </div>
    </form>

    <!-- Overlay de Aguarde -->
    <div id="aguardeOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div style="background:#fff; padding:30px; border-radius:8px; max-width:350px; margin:auto; text-align:center; box-shadow:0 2px 12px #0004;">
            <div style="margin-bottom:18px; font-size:1.2em;">Aguarde, estamos gerando as atividades...</div>
            <div class="progress-bar-striped progress-bar-animated" style="height:24px; background:linear-gradient(90deg,#007bff 40%,#66b3ff 100%); border-radius:12px; width:100%; animation: progressBar 2s linear infinite;"></div>
            <style>
                @keyframes progressBar {
                    0% {background-position: 0% 0;}
                    100% {background-position: 100% 0;}
                }
            </style>
        </div>
    </div>

    <!-- Importação das bibliotecas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
// Confirmação segura ao enviar formulário
const form = document.getElementById('formInventario');
const btnSalvar = document.getElementById('btnSalvar');
const modal = document.getElementById('modalConfirmacao');
const confirmar = document.getElementById('confirmarEnvio');
const cancelar = document.getElementById('cancelarEnvio');
const mensagem = document.getElementById('mensagemConfirmacao');

if(form && btnSalvar && modal && confirmar && cancelar && mensagem) {
    btnSalvar.addEventListener('click', function(e) {
        // Validação do formulário antes de mostrar o modal
        let radiosValid = true;
        // Validação manual dos grupos de radio dinâmicos
        // Comunicação/Linguagem
        const comunicacaoCount = document.querySelectorAll('input[name^="ecm"]').length / 2;
        for(let i=1; i<=comunicacaoCount; i++) {
            const radios = document.querySelectorAll(`input[name='ecm${String(i).padStart(2, '0')}']`);
            if (![...radios].some(r => r.checked)) { radiosValid = false; break; }
        }
        // Comportamento
        const comportamentoCount = document.querySelectorAll('input[name^="ecp"]').length / 2;
        for(let i=1; i<=comportamentoCount; i++) {
            const radios = document.querySelectorAll(`input[name='ecp${String(i).padStart(2, '0')}']`);
            if (![...radios].some(r => r.checked)) { radiosValid = false; break; }
        }
        // Socioemocional
        const emocionalCount = document.querySelectorAll('input[name^="eis"]').length / 2;
        for(let i=1; i<=emocionalCount; i++) {
            const radios = document.querySelectorAll(`input[name='eis${String(i).padStart(2, '0')}']`);
            if (![...radios].some(r => r.checked)) { radiosValid = false; break; }
        }
        // Demais campos obrigatórios
        if (form.checkValidity() && radiosValid) {
            // Pega a data atual formatada
            const dataAtual = new Date();
            const dataFormatada = dataAtual.toLocaleDateString('pt-BR');
            mensagem.textContent = `Confirma o envio do inventário? Data: ${dataFormatada}`;
            modal.style.display = 'flex';
        } else {
            // Dispara validação padrão do HTML5
            form.reportValidity();
            if (!radiosValid) {
                alert('Por favor, preencha todas as respostas dos inventários antes de salvar!');
            }
        }
    });
    confirmar.addEventListener('click', function() {
        modal.style.display = 'none';
        // Guardar rota anterior no sessionStorage e no campo hidden
        var rotaAnterior = document.referrer || window.sessionStorage.getItem('rota_anterior') || '';
        window.sessionStorage.setItem('rota_anterior', rotaAnterior);
        document.getElementById('rota_anterior').value = rotaAnterior;
        document.getElementById('aguardeOverlay').style.display = 'flex';
        setTimeout(() => { form.submit(); }, 150);
    });
    cancelar.addEventListener('click', function() {
        modal.style.display = 'none';
    });
}

// --- PDF BUTTON SCRIPT ---
document.querySelector(".pdf-button").addEventListener("click", function() {
    const { jsPDF } = window.jspdf;
    const element = document.querySelector('.container');

    html2canvas(element, {
        scale: 0.9,
        useCORS: true
    }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");
        const imgWidth = 210;
        const pageHeight = 297;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        let y = 0;
        while (y < imgHeight) {
            pdf.addImage(imgData, "PNG", 0, y * -1, imgWidth, imgHeight);
            y += pageHeight;
            if (y < imgHeight) pdf.addPage();
        }

        // Pegando o nome do aluno do input (garante que é o mesmo mostrado na tela)
        let nomeAluno = document.querySelector('input[value="{{ $aluno->alu_nome }}"]').value || "{{ $aluno->alu_nome }}";
        // Remove acentos e caracteres especiais, troca espaços por _
        nomeAluno = nomeAluno
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-zA-Z0-9]/g, '_')
            .replace(/_+/g, '_')
            .replace(/^_+|_+$/g, '');

        // Data no formato DD-MM-AAAA
        const hoje = new Date();
        const dia = String(hoje.getDate()).padStart(2, '0');
        const mes = String(hoje.getMonth() + 1).padStart(2, '0');
        const ano = hoje.getFullYear();
        const dataAtual = `${dia}-${mes}-${ano}`;

        // Nome do arquivo
        const nomeArquivo = `Inventario_${nomeAluno}_${dataAtual}.pdf`;

        pdf.save(nomeArquivo);
    }).catch(error => console.error("Erro ao gerar PDF:", error));
});
</script>

<script>
    document.getElementById('form').addEventListener('submit', function(e) {
        let isValid = true;
        let firstInvalid = null;
    
        // Seleciona todos os grupos de radio obrigatórios
        const requiredRadios = [
            // Comunicação/Linguagem
            @for($i = 1; $i <= 32; $i++)
                'ecm{{ sprintf("%02d", $i) }}',
            @endfor
            // Comportamento
            @for($i = 1; $i <= 17; $i++)
                'ecp{{ sprintf("%02d", $i) }}',
            @endfor
            // Socioemocional
            @for($i = 1; $i <= 18; $i++)
                'eis{{ sprintf("%02d", $i) }}',
            @endfor
            // Outros campos obrigatórios
            'responsavel', 'suporte', 'comunicacao'
        ];
    
        requiredRadios.forEach(function(name) {
            const checked = document.querySelector('input[name="' + name + '"]:checked');
            if (!checked) {
                isValid = false;
                if (!firstInvalid) {
                    firstInvalid = document.querySelector('input[name="' + name + '"]');
                }
            }
        });
    
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, responda todos os campos obrigatórios.');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({behavior: "smooth", block: "center"});
            }
        }
    });
    </script>
   
</body>

</html>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formInventario');
        
        form.addEventListener('submit', function(e) {
            console.log('Formulário enviado');
            console.log('URL de ação:', form.action);
            console.log('Método:', form.method);
            
            // Mostrar todos os dados do formulário
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Não interromper o envio do formulário
            return true;
        });
    });
</script>
@endpush
@endsection