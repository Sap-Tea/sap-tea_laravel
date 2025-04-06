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
            <li><a href="#" data-target="formulario-cad-instituicao"><i class="fa-solid fa-building-columns"></i> Gerênciamento</a></li>
           <!-- 
            <li><a href="#" data-target="formulario-cad-orgao"><i class="fa-solid fa-building"></i> Órgão</a></li>
            <li><a href="#" data-target="formulario-cad-escola"><i class="fa-solid fa-school"></i> Escola ▼ </a>
                <ul class="submenu_escola">
                    <li><a href="#" data-target="modalidade-ensino">Modalidade de ensino</a></li>
      
                </ul>
            </li>
            <li><a href="#" data-target="formulario-cad-aluno"><i class="fa-solid fa-user-graduate"></i> Aluno</a></li>
            <li><a href="#" data-target="funcao"><i class="fa-regular fa-keyboard"></i> Função</a></li>
            <li><a href="#" data-target="formulario-cad-funcionario"><i class="fa-solid fa-users"></i> Servidores</a></li>
            <li><a href="#" data-target="Enturmacao"><i class="fa-regular fa-folder"></i> Matriculas ▼ </a>
                <ul class="submenu_matriculas">
                    <li><a href="#" data-target="formulario-enturmar-escola">Enturmação</a></li>
                </ul>
            </li>
        </ul>

        <h2>Inventarios</h2>
        <ul>
            <li><a href="#" data-target="formulario-eixo-escola"><i class="fa-solid fa-shapes"></i> Eixos</a></li>
           
        </ul>

        <h2>Espaço Professor</h2>
        <ul>
            <li><a href="#" data-target="formulario-mig-download"><i class="fa-solid fa-shapes"></i> Download de material</a></li>
           
        </ul>

        <h2>Migrações</h2>
        <ul>
            <li><a href="#" data-target="formulario-mig-escola"><i class="fa-solid fa-code-branch"></i> Migrar Escola</a></li>
            <li><a href="#" data-target="formulario-mig-aluno"><i class="fa-solid fa-sitemap"></i> Migrar Aluno</a></li>
            <li><a href="#" data-target="formulario-mig-funcionario"><i class="fa-solid fa-sitemap"></i> Migrar Funcionario</a></li>
            
            
        </ul>

        <h2>Controles</h2>
        <ul>
            <li><a href="#" data-target="formulario-cad-usuarios"><i class="fa-solid fa-address-card"></i> Cadastro de usuários</a></li>
        </ul>
-->

</ul>
        <h3>Download de Materiais</h3>
   
        <ul>


        <ul>
            <li><a href="#" data-target="formulario-cad-instituicao"><i class="fa-solid fa-building-columns"></i> Atividades para impressão</a></li>
    </div>
    
    <div id="formulario-container"></div> 

    

    <script src="public/js/script.js"></script>

  
  </body>
</html>