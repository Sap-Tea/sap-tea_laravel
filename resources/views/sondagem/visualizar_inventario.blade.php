@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Inventário</title>
    <link rel="stylesheet" href="{{ asset('css/inventario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
   
</head>
<body>
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
            <p>Ano/Série: <input type="text" style="width: 150px;" value = "{{$alunoDetalhado->serie_desc}}" readonly> 
                Turma:
                <input value = "{{$alunoDetalhado->fk_cod_valor_turma}}" type="text" style="width: 120px;" readonly> 
                Período: <input type="text"style="width: 200px;" style="width: 250px;" value = "{{$alunoDetalhado->desc_modalidade}}" readonly></p>
        </div>
        <div class="inventory-data">
            <!-- Seção Responsável e Suporte -->
            <div class="section">
                <h3>Responsável pelo Preenchimento:</h3>
                <p>
                    @if($preenchimento->professor_responsavel == 1)
                        Professor de sala Regular
                    @else
                        Professor do Atendimento Educacional Especializado (AEE)
                    @endif
                </p>

                <h3>Nível de Suporte:</h3>
                <p>
                    @switch($preenchimento->nivel_suporte)
                        @case(1) Nível 1 - Pouco apoio @break
                        @case(2) Nível 2 - Apoio substancial @break
                        @case(3) Nível 3 - Apoio muito substancial @break
                    @endswitch
                </p>

                <h3>Forma de Comunicação:</h3>
                <p>
                    @switch($preenchimento->nivel_comunicacao)
                        @case(1) Verbal @break
                        @case(2) Não verbal com métodos alternativos @break
                        @case(3) Não verbal @break
                    @endswitch
                </p>
            </div>

            <!-- Eixo Comunicação/Linguagem -->
            <div class="section">
                <h2>EIXO COMUNICAÇÃO/LINGUAGEM</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Perguntas_eixo_comunicacao as $i => $pergunta)
                            @php 
                                $campo = 'ecm' . sprintf('%02d', $i+1);
                                $valor = $eixoComunicacao->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Eixo Comportamento -->
            <div class="section">
                <h2>EIXO COMPORTAMENTO</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perguntas_eixo_comportamento as $i => $pergunta)
                            @php 
                                $campo = 'ecp' . sprintf('%02d', $i+1);
                                $valor = $eixoComportamento->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Eixo Socioemocional -->
            <div class="section">
                <h2>EIXO INTERAÇÃO SOCIOEMOCIONAL</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pergunta</th>
                            <th>Sim</th>
                            <th>Não</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eixo_int_socio_emocional as $i => $pergunta)
                            @php 
                                $campo = 'eis' . sprintf('%02d', $i+1);
                                $valor = $eixoSocioEmocional->$campo ?? null;
                            @endphp
                            <tr>
                                <td>{{ $pergunta }}</td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor == 1 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                                <td>
                                    <input type="radio" 
                                           class="readonly-radio"
                                           {{ $valor === 0 ? 'checked' : '' }} 
                                           disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="button-group">
          
        <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        <button type="button" class="pdf-button">Gerar PDF</button>

</div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector(".pdf-button").addEventListener("click", function() {
        const { jsPDF } = window.jspdf;
        const element = document.querySelector(".container"); // Captura toda a área do container
        
        // Mostrar loading
        const loading = document.createElement('div');
        loading.style = 'position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; display:flex; justify-content:center; align-items:center;';
        loading.innerHTML = '<div style="font-size:20px;">Gerando PDF...</div>';
        document.body.appendChild(loading);

        html2canvas(element, {
            scale: 1.2, // Aumenta a qualidade
            useCORS: true, // Permite imagens externas
            logging: true // Habilita logs para debug
        }).then(canvas => {
            const imgData = canvas.toDataURL("image/jpeg", 0.98); // Melhor qualidade
            const pdf = new jsPDF("p", "mm", "a4");
            const imgWidth = 210;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            pdf.addImage(imgData, "JPEG", 0, 0, imgWidth, imgHeight);
            pdf.save("Inventario_{{ $aluno->alu_nome }}.pdf"); // Nome dinâmico
            
            document.body.removeChild(loading);
        }).catch(error => {
            console.error("Erro:", error);
            alert("Erro ao gerar PDF: " + error.message);
            document.body.removeChild(loading);
        });
    });
});
</script>


</body>
</html>
@endsection



<!-- Importação das bibliotecas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.querySelector(".pdf-button").addEventListener("click", function() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById("capture"); // Seleciona a área desejada

            html2canvas(element, {
                scale: 0.9, // Melhora a qualidade da imagem capturada
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "mm", "a4");

                const imgWidth = 210; // Largura A4 em mm
                const pageHeight = 297; // Altura A4 em mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width; // Mantém a proporção

                let y = 0;

                while (y < imgHeight) {
                    pdf.addImage(imgData, "PNG", 0, y * -1, imgWidth, imgHeight);
                    y += pageHeight;

                    if (y < imgHeight) {
                        pdf.addPage(); // Adiciona nova página se necessário
                    }
                }

                pdf.save("formulario.pdf");
            }).catch(error => console.error("Erro ao gerar PDF:", error));
        });
    </script>