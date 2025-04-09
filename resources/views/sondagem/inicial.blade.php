@extends('layouts.app')

@section('content')
    <div style="background-color: #f0f0f0; padding: 15px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="margin-top: 0;">Informações do Aluno</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px; font-weight: bold;">Matrícula:</td>
                <td style="padding: 5px;">{{ $aluno->numero_matricula }}</td>

                <td style="padding: 5px; font-weight: bold;">Escola:</td>
                <td style="padding: 5px;">{{ $aluno->esc_razao_social }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold;">Aluno:</td>
                <td style="padding: 5px;">{{ $aluno->alu_nome }}</td>

                <td style="padding: 5px; font-weight: bold;">Código da Turma:</td>
                <td style="padding: 5px;"></td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold;">Professor:</td>
                <td style="padding: 5px;">{{ $aluno->func_nome }}</td>
                <td style="padding: 5px; font-weight: bold;">Modalidade:</td>
                <td style="padding: 5px;"></td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold;">Série/Modalidade:</td>
                <td style="padding: 5px;"></td>
            </tr>
        </table>
    </div>



    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulário</title>
        <style>
            /* Estilo geral */
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 20px;
                color: #333;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            /* Títulos */
            h2 {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                color: #db7a19;
            }

            /* Tabelas */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th,
            td {
                border: 1px solid #dee2e6;
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #db7a19;
                /* Cabeçalho azul */
                color: white;
                /* Texto branco */
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
                /* Linhas alternadas */
            }

            tr:hover {
                background-color: #f1f1f1;
                /* Linha destacada ao passar o mouse */
            }

            /* Inputs */
            /* Estilo para os botões de rádio */
            input[type="radio"] {
                appearance: none;
                /* Remove o estilo padrão do navegador */
                width: 20px;
                /* Largura do botão */
                height: 20px;
                /* Altura do botão */
                border: 2px solid #db7a19;
                /* Cor da borda */
                border-radius: 4px;
                /* Bordas arredondadas */
                display: inline-block;
                position: relative;
                cursor: pointer;
                background-color: #ffffff;
                /* Fundo branco */
            }

            input[type="radio"]:checked::after {
                content: "X";
                /* Adiciona o "X" */
                font-size: 16px;
                /* Tamanho do "X" */
                font-weight: bold;
                /* Deixa o "X" em negrito */
                color: rgb(14, 14, 14);
                /* Cor do "X" */
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                /* Centraliza o "X" dentro do botão */
            }

            input[type="radio"]:hover {
                border-color: #db7a19;
                /* Muda a cor da borda ao passar o mouse */
            }



            /* Estilos gerais dos botões */
            .button-group {
                display: flex;
                gap: 10px;
                /* Espaçamento entre os botões */
                justify-content: center;
                /* Centraliza os botões */
                margin-top: 20px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 16px;
                font-weight: bold;
                border-radius: 8px;
                text-decoration: none;
                transition: all 0.3s ease-in-out;
                border: none;
                cursor: pointer;
            }

            .btn-primary {
                background-color: #007bff;
                color: white;
            }

            .btn-primary:hover {
                background-color: #0056b3;
            }

            .btn-danger {
                background-color: #dc3545;
                color: white;
            }

            .btn-danger:hover {
                background-color: #a71d2a;
            }

            .pdf-button {
                background-color: #28a745;
                color: white;
                padding: 12px 20px;
                font-size: 16px;
                font-weight: bold;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }

            .pdf-button:hover {
                background-color: #1e7e34;
            }



            /* Formulários por eixo */
            #form1,
            #form2,
            #form3 {
                margin-bottom: 20px;
            }

            #form1 {
                background-color: #e3f2fd;
                /* Azul claro */
                padding: 20px;
                border-radius: 10px;
            }

            #form2 {
                background-color: #fffde7;
                /* Amarelo claro */
                padding: 20px;
                border-radius: 10px;
            }

            #form3 {
                background-color: #e8f5e9;
                /* Verde claro */
                padding: 20px;
                border-radius: 10px;
            }



            /* Responsividade */
            @media (max-width: 768px) {

                table,
                th,
                td {
                    font-size: 14px;
                    /* Reduz o tamanho da fonte em telas menores */
                }

                button[type="submit"] {
                    font-size: 14px;
                    /* Ajusta o botão para telas menores */
                }
            }
        </style>
    </head>

    <body>

        <div id="capture">
            <h2>Cadastro de inventários</h2>

            <form method="POST" action="{{ route('inserir_inventario') }}">
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

            </form>



            </tbody>
            </table>

            <form id="form2">
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

            </form>
            </tbody>
            </table>


            <form id="form3">
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
