<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros Dinâmicos</title>
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>

<title>Barra Horizontal</title>

</head>
<body>
    <!-- Barra horizontal -->
    <div class="horizontal-bar">
        <div class="logo">Supergando TEA</div>
        <div class="menu">
            <a href="#">  <i class="fa-solid fa-user"></i> MINHA CONTA </a>
            <
        </div>
    </div>
</body>
</html>
<body>
    <div class="sidebar">
    <div class="menu-logo">
    <img src="{{ asset('img/logo_sap.png') }}" alt="Logo">
</div>

<li><a href="#" data-target="formulario-cad-escola"><i class="fa-solid fa-school"></i> Cadastro ⬇️ </a>
                <ul class="submenu_escola">
                <li><a href="{{ route('instituicao') }}">Instituição</a></li> 
                <li><a href="{{ route('escola') }}">Escola</a></li>
                <li><a href="{{ route('alunos') }}">Aluno</a></li>
                <li><a href="{{ route('orgao') }}">Órgão</a></li>
                </ul>
            </li>
        </ul>
    <li>
<ul>
    <li>
        <a href="#" class="menu-toggle"><i class="fa-solid fa-school"></i> Sondagem Pedagógica ⬇️ </a>
        <ul class="submenu">
            <li><a href="{{ route('eixos.alunos') }}" class="menu-link">.1 Inicial</a></li>
            <li><a href="{{ route('sondagem.continuada1') }}" class="menu-link">.2 Continuada</a></li>
            <li><a href="{{ route('sondagem.continuada2') }}" class="menu-link">.3 Continuada</a></li>
            <li><a href="{{ route('sondagem.final') }}" class="menu-link">.4 Final</a></li>
        </ul>
    </li>
</ul>
            <li><a href="#" data-target="formulario-cad-escola"><i class="fa-solid fa-school"></i> Rotina e Monitoramento ⬇️ </a>
                <ul class="submenu_escola">
                <li><a href="{{ route('modalidade.inicial') }}">.1 Inicial</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.2 Continuada</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.3 Continuada</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.4 Final</a></li>
                </ul>
            </li>
        </ul>
        <ul>
            <li><a href="#" data-target="formulario-cad-escola"><i class="fa-solid fa-school"></i> Indicativo de Atividades e Habilidades⬇️ </a>
                <ul class="submenu_escola">
                    <li><a href="#" data-target="modalidade-ensino">.1 Inicial</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.2 Continuada</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.3 Continuada</a></li>
                    <li><a href="#" data-target="modalidade-ensino">.4 Final</a></li>
            
                </ul>
                <li>
                <a href="{{ route('perfil.estudante') }}" target="_blank">
                            <i class="fa-solid fa-graduation-cap"></i> Perfil do Estudante
                </a>


  </a>
</li>
            </li>
        </ul>
        <h3>Foccus - Cadastros</h3>
   
        <ul>
            <li><a href="{{route('foccus.xampp')}}" ><i class="fa-solid fa-building-columns"></i> Gerênciamento</a></li>
           

</ul>
        <h3>Download de Materiais</h3>
   
        <ul>


        <ul>
        <li><a href="{{ route('download') }}">Baixar Material</a></li>
        
    </div>
    
    <div id="formulario-container"></div> 


    </ul>
         
    

    <script src="public/js/script.js"></script>

  

    
  </body>
</html>