@extends('layouts.app')

@section('content')

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
<form method="POST" action="{{ route('inserir_inventario') }}">
    <div class="menu">
        <img src="{{ asset('img/LOGOTEA.png') }}" alt="Logo" class="logo">
        <img src="{{ asset('img/logo_sap.png') }}" alt="Logo SAP" class="logo-right">

        <h1>SONDAGEM PEDAGÓGICA 1 - INICIAL</h1>
        <p>Secretaria de Educação do Município</p>
        <div class="fields">
            <p>Data de inicio inventario: <input type="date"></p>
            <p>Orgão: <input type="text" style="width: 300px;"></p>

            <p>Escola: <input type="text" style="width: 300px;"></p>
            <p>Nome do Aluno: <input type="text" style="width: 250px;"value = "{{$aluno->alu_nome}}"></p>
            <p>Data de Nascimento: <input type="date"> Idade: <input type="number" min="0" style="width: 50px;"></p>
            <p>Ano/Série: <input type="text" style="width: 50px;"> Turma: <input type="text" style="width: 50px;"> Período: <input type="text"style="width: 200px;" style="width: 250px;"></p>
        </div>
        <div class="support">
            <p><strong>Responsável pelo preenchimento:</strong></p>
            <p><input type="radio" name="responsavel" class="radio-toggle"> Professor de sala Regular</p>
            <p><input type="radio" name="responsavel" class="radio-toggle"> Professor do Atendimento Educacional Especializado (AEE)</p>
            <p><strong>Assinale o nível de suporte necessário para o estudante:</strong></p>
            <p><input type="radio" name="suporte" class="radio-toggle"> Nível 1 de Suporte - Exige pouco apoio</p>
            <p><input type="radio" name="suporte" class="radio-toggle"> Nível 2 de Suporte - Exige apoio substancial</p>
            <p><input type="radio" name="suporte" class="radio-toggle"> Nível 3 de Suporte - Exige apoio muito substancial</p>
            <p><strong>Assinale a forma de comunicação utilizada pelo estudante:</strong></p>
            <p><input type="radio" name="comunicacao" class="radio-toggle"> Comunicação verbal</p>
            <p><input type="radio" name="comunicacao" class="radio-toggle"> Comunicação não verbal com uso de métodos alternativos de comunicação</p>
            <p><input type="radio" name="comunicacao" class="radio-toggle"> Comunicação não Verbal</p>
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
                    <tr>
                        <td>Amplia gradativamente seu vocabulário?</td>
                        <td><input type="radio" name="ecm01" id="ecm01_s" value="sim"></td>
                        <td><input type="radio" name="ecm01" id="ecm01_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Amplia gradativamente sua comunicação social?</td>
                        <td><input type="radio" name="ecm02" id="ecm02_s" value="sim"></td>
                        <td><input type="radio" name="ecm02" id="ecm02_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Apresenta entonação vocal, com boa articulação e ritmo adequado?</td>
                        <td><input type="radio" name="ecm03" id="ecm03_s" value="sim"></td>
                        <td><input type="radio" name="ecm03" id="ecm03_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Ativa conhecimentos prévios em situações de novas aprendizagens?</td>
                        <td><input type="radio" name="ecm04" id="ecm04_s" value="sim"></td>
                        <td><input type="radio" name="ecm04" id="ecm04_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Categoriza diferentes elementos de acordo com critérios preestabelecidos?</td>
                        <td><input type="radio" name="ecm05" id="ecm05_s" value="sim"></td>
                        <td><input type="radio" name="ecm05" id="ecm05_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Compreende e utiliza comunicação alternativa para se comunicar?</td>
                        <td><input type="radio" name="ecm06" id="ecm06_s" value="sim"></td>
                        <td><input type="radio" name="ecm06" id="ecm06_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Compreende que pode receber ajuda de pessoas conhecidas que estão ao seu redor?</td>
                        <td><input type="radio" name="ecm07" id="ecm07_s" value="sim"></td>
                        <td><input type="radio" name="ecm07" id="ecm07_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Comunica fatos, acontecimentos e ações de seu cotidiano de modo compreensível, ainda que não
                            seja por meio da linguagem verbal?</td>
                        <td><input type="radio" name="ecm08" id="ecm08_s" value="sim"></td>
                        <td><input type="radio" name="ecm08" id="ecm08_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Comunica suas necessidades básicas (banheiro, água, comida, entre outros)?</td>
                        <td><input type="radio" name="ecm09" id="ecm09_s" value="sim"></td>
                        <td><input type="radio" name="ecm09" id="ecm09_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Entende expressões faciais em uma conversa?</td>
                        <td><input type="radio" name="ecm10" id="ecm10_s" value="sim"></td>
                        <td><input type="radio" name="ecm10" id="ecm10_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Executa mais de um comando sequencialmente?</td>
                        <td><input type="radio" name="ecm11" id="ecm11_s" value="sim"></td>
                        <td><input type="radio" name="ecm11" id="ecm11_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Expressa-se com clareza e objetividade?</td>
                        <td><input type="radio" name="ecm12" id="ecm12_s" value="sim"></td>
                        <td><input type="radio" name="ecm12" id="ecm12_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Faz uso de expressões faciais para se comunicar?</td>
                        <td><input type="radio" name="ecm13" id="ecm13_s" value="sim"></td>
                        <td><input type="radio" name="ecm13" id="ecm13_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Faz uso de gestos para se comunicar?</td>
                        <td><input type="radio" name="ecm14" id="ecm14_s" value="sim"></td>
                        <td><input type="radio" name="ecm14" id="ecm14_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Identifica diferentes elementos, ampliando seu repertório?</td>
                        <td><input type="radio" name="ecm15" id="ecm15_s" value="sim"></td>
                        <td><input type="radio" name="ecm15" id="ecm15_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Identifica semelhanças e diferenças entre elementos?</td>
                        <td><input type="radio" name="ecm16" id="ecm16_s" value="sim"></td>
                        <td><input type="radio" name="ecm16" id="ecm16_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Inicia uma situação comunicativa?</td>
                        <td><input type="radio" name="ecm17" id="ecm17_s" value="sim"></td>
                        <td><input type="radio" name="ecm17" id="ecm17_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Mantem uma situação comunicativa?</td>
                        <td><input type="radio" name="ecm18" id="ecm18_s" value="sim"></td>
                        <td><input type="radio" name="ecm18" id="ecm18_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Nomeia as pessoas que fazem parte de sua rede de apoio?</td>
                        <td><input type="radio" name="ecm19" id="ecm19_s" value="sim"></td>
                        <td><input type="radio" name="ecm19" id="ecm19_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Nomeia diferentes elementos, ampliando seu vocabulário? </td>
                        <td><input type="radio" name="ecm20" id="ecm20_s" value="sim"></td>
                        <td><input type="radio" name="ecm20" id="ecm20_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Possui autonomia para se comunicar, mesmo em situações que geram conflito?</td>
                        <td><input type="radio" name="ecm21" id="ecm21_s" value="sim"></td>
                        <td><input type="radio" name="ecm21" id="ecm21_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Realiza pareamento de elementos idênticos?</td>
                        <td><input type="radio" name="ecm22" id="ecm22_s" value="sim"></td>
                        <td><input type="radio" name="ecm22" id="ecm22_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Reconhece e pareia elementos diferentes?</td>
                        <td><input type="radio" name="ecm23" id="ecm23_s" value="sim"></td>
                        <td><input type="radio" name="ecm23" id="ecm23_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Reconhece visualmente estímulos apresentados?</td>
                        <td><input type="radio" name="ecm24" id="ecm24_s" value="sim"></td>
                        <td><input type="radio" name="ecm24" id="ecm24_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Refere-se a si mesmo em primeira pessoa?</td>
                        <td><input type="radio" name="ecm25" id="ecm25_s" value="sim"></td>
                        <td><input type="radio" name="ecm25" id="ecm25_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Respeita turnos de fala?</td>
                        <td><input type="radio" name="ecm26" id="ecm26_s" value="sim"></td>
                        <td><input type="radio" name="ecm26" id="ecm26_n" value="nao"></td>
                    </tr>

                    <tr>
                        <td>Responde ao ouvir seu nome?</td>
                        <td><input type="radio" name="ecm27" id="ecm27_s" value="sim"></td>
                        <td><input type="radio" name="ecm27" id="ecm27_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Solicita ajuda de pessoas que estão ao seu redor, quando necessário?</td>
                        <td><input type="radio" name="ecm28" id="ecm28_s" value="sim"></td>
                        <td><input type="radio" name="ecm28" id="ecm28_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Utiliza linguagem não verbal para se comunicar?</td>
                        <td><input type="radio" name="ecm29" id="ecm29_s" value="sim"></td>
                        <td><input type="radio" name="ecm29" id="ecm29_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Utiliza linguagem verbal para se comunicar?</td>
                        <td><input type="radio" name="ecm30" id="ecm30_s" value="sim"></td>
                        <td><input type="radio" name="ecm30" id="ecm30_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Utiliza respostas simples para se comunicar?</td>
                        <td><input type="radio" name="ecm31" id="ecm31_s" value="sim"></td>
                        <td><input type="radio" name="ecm31" id="ecm31_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Utiliza vocabulário adequado, de acordo com seu nível de desenvolvimento?</td>
                        <td><input type="radio" name="ecm32" id="ecm32_s" value="sim"></td>
                        <td><input type="radio" name="ecm32" id="ecm32_n" value="nao"></td>
                    </tr>

       


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
                    <tr>
                        <td>Adapta-se com flexibilidade a mudanças, em sua rotina (familiar, escolar e social)?</td>
                        <td><input type="radio" name="ecp1" id="ecp1_s" value="sim"></td>
                        <td><input type="radio" name="ecp1" id="ecp1_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Apresenta autonomia na realização das atividades propostas?</td>
                        <td><input type="radio" name="ecp2" id="ecp2_s" value="sim"></td>
                        <td><input type="radio" name="ecp2" id="ecp2_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Autorregula-se evitando comportamentos disruptivos em situações de desconforto?</td>
                        <td><input type="radio" name="ecp3" id="ecp3_s" value="sim"></td>
                        <td><input type="radio" name="ecp3" id="ecp3_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Compreende acontecimentos de sua rotina por meio de ilustrações?</td>
                        <td><input type="radio" name="ecp4" id="ecp4_s" value="sim"></td>
                        <td><input type="radio" name="ecp4" id="ecp4_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Compreende regras de convivência?</td>
                        <td><input type="radio" name="ecp5" id="ecp5_s" value="sim"></td>
                        <td><input type="radio" name="ecp5" id="ecp5_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Entende ações de autocuidado?</td>
                        <td><input type="radio" name="ecp6" id="ecp6_s" value="sim"></td>
                        <td><input type="radio" name="ecp6" id="ecp6_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Faz uso de movimentos corporais, como: apontar, movimentar a cabeça em sinal
                            afirmativo/negativo, entre outros?</td>
                        <td><input type="radio" name="ecp7" id="ecp7_s" value="sim"></td>
                        <td><input type="radio" name="ecp7" id="ecp7_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Imita gestos, movimentos e segue comandos?</td>
                        <td><input type="radio" name="ecp8" id="ecp8_s" value="sim"></td>
                        <td><input type="radio" name="ecp8" id="ecp8_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Inicia e finaliza as atividades propostas diariamente?</td>
                        <td><input type="radio" name="ecp9" id="ecp9_s" value="sim"></td>
                        <td><input type="radio" name="ecp9" id="ecp9_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Interage nos momentos de jogos, lazer e demais atividades, respeitando as regras de
                            convivência?</td>
                        <td><input type="radio" name="ecp10" id="ecp10_s" value="sim"></td>
                        <td><input type="radio" name="ecp10" id="ecp10_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Mantem a organização em sua rotina escolar?</td>
                        <td><input type="radio" name="ecp11" id="ecp11_s" value="sim"></td>
                        <td><input type="radio" name="ecp11" id="ecp11_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Permanace sentado por mais de dez minutos para a realização das atividades?</td>
                        <td><input type="radio" name="ecp12" id="ecp12_s" value="sim"></td>
                        <td><input type="radio" name="ecp12" id="ecp12_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Realiza ações motoras que envolvam movimento e equilíbrio?</td>
                        <td><input type="radio" name="ecp13" id="ecp13_s" value="sim"></td>
                        <td><input type="radio" name="ecp13" id="ecp13_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Realiza atividades com atenção e tolerância?</td>
                        <td><input type="radio" name="ecp14" id="ecp14_s" value="sim"></td>
                        <td><input type="radio" name="ecp14" id="ecp14_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Realiza, em sua rotina, ações de autocuidado com autonomia?</td>
                        <td><input type="radio" name="ecp15" id="ecp15_s" value="sim"></td>
                        <td><input type="radio" name="ecp15" id="ecp15_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Reconhece e identifica alimentos que lhe são oferecidos?</td>
                        <td><input type="radio" name="ecp16" id="ecp16_s" value="sim"></td>
                        <td><input type="radio" name="ecp16" id="ecp16_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Responde a comandos de ordem direta?</td>
                        <td><input type="radio" name="ecp17" id="ecp17_s" value="sim"></td>
                        <td><input type="radio" name="ecp17" id="ecp17_n" value="nao"></td>
                    </tr>

        
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
                    <tr>

                    <tr>
                        <td>Compartilha brinquedos e brincadeiras?</td>
                        <td><input type="radio" name="eis1" id="eis1_s" value="sim"></td>
                        <td><input type="radio" name="eis1" id="eis1_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Compartilha interesses?</td>
                        <td><input type="radio" name="eis2" id="eis2_s" value="sim"></td>
                        <td><input type="radio" name="eis2" id="eis2_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Controla suas emoções? (Autorregula-se)</td>
                        <td><input type="radio" name="eis3" id="eis3_s" value="sim"></td>
                        <td><input type="radio" name="eis3" id="eis3_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Coopera em situações que envolvem interação?</td>
                        <td><input type="radio" name="eis4" id="eis4_s" value="sim"></td>
                        <td><input type="radio" name="eis4" id="eis4_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Demonstra e compartilha afeto?</td>
                        <td><input type="radio" name="eis5" id="eis5_s" value="sim"></td>
                        <td><input type="radio" name="eis5" id="eis5_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Demonstra interesse nas atividades propostas?</td>
                        <td><input type="radio" name="eis6" id="eis6_s" value="sim"></td>
                        <td><input type="radio" name="eis6" id="eis6_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Expressa suas emoções?</td>
                        <td><input type="radio" name="eis7" id="eis7_s" value="sim"></td>
                        <td><input type="radio" name="eis7" id="eis7_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Identifica/reconhece a emoção do outro?</td>
                        <td><input type="radio" name="eis8" id="eis8_s" value="sim"></td>
                        <td><input type="radio" name="eis8" id="eis8_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Identifica/reconhece suas emoções?</td>
                        <td><input type="radio" name="eis9" id="eis9_s" value="sim"></td>
                        <td><input type="radio" name="eis9" id="eis9_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Inicia e mantém interação em situações sociais?</td>
                        <td><input type="radio" name="eis10" id="eis10_s" value="sim"></td>
                        <td><input type="radio" name="eis10" id="eis10_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Interage com o(a) professor(a), seus colegas e outras pessoas de seu convívio escolar?</td>
                        <td><input type="radio" name="eis11" id="eis11_s" value="sim"></td>
                        <td><input type="radio" name="eis11" id="eis11_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Interage, fazendo contato visual?</td>
                        <td><input type="radio" name="eis12" id="eis12_s" value="sim"></td>
                        <td><input type="radio" name="eis12" id="eis12_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Reconhece e entende seus sentimentos, pensamentos e comportamentos?</td>
                        <td><input type="radio" name="eis13" id="eis13_s" value="sim"></td>
                        <td><input type="radio" name="eis13" id="eis13_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Relaciona-se, estabelecendo vínculos?</td>
                        <td><input type="radio" name="eis14" id="eis14_s" value="sim"></td>
                        <td><input type="radio" name="eis14" id="eis14_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Respeita regras em jogos e brincadeiras?</td>
                        <td><input type="radio" name="eis15" id="eis15_s" value="sim"></td>
                        <td><input type="radio" name="eis15" id="eis15_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Respeita regras sociais?</td>
                        <td><input type="radio" name="eis16" id="eis16_s" value="sim"></td>
                        <td><input type="radio" name="eis16" id="eis16_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Responde a interações?</td>
                        <td><input type="radio" name="eis17" id="eis17_s" value="sim"></td>
                        <td><input type="radio" name="eis17" id="eis17_n" value="nao"></td>
                    </tr>
                    <tr>
                        <td>Solicita ajuda, quando necessário?</td>
                        <td><input type="radio" name="eis18" id="eis18_s" value="sim"></td>
                        <td><input type="radio" name="eis18" id="eis18_n" value="nao"></td>
                    </tr>



        </form>



        </tbody>
        </table>

    </div>



    <br>
    <div class="button-group">

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('index') }}" class="btn btn-danger">Cancelar</a>
        <button type="button" class="pdf-button">Gerar PDF</button>

    </div>


    </form>


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
</body>

</html>
@endsection