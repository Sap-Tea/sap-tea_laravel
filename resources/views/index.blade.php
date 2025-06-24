<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAP-TEA - @yield('title', 'Página Inicial')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Layout principal */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f4f4f4;
        }

        .horizontal-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .main-container {
            display: flex;
            margin-top: 60px;
            min-height: calc(100vh - 60px);
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;
            bottom: 0;
            width: 250px;
            overflow-y: auto;
            background: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 900;
            padding: 20px 0;
        }

        .content-area {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background: #f4f4f4;
            min-height: calc(100vh - 60px);
            overflow-y: auto;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            padding: 10px 20px;
            background: #fff;
            border-radius: 4px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .breadcrumbs a {
            color: #0056b3;
            text-decoration: none;
        }
        .breadcrumbs .separator {
            margin: 0 8px;
            color: #6c757d;
        }

        /* Menu styles */
        .menu-logo {
            text-align: center;
            padding: 15px 0;
        }
        .menu-logo img {
            max-width: 150px;
            height: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 5px;
        }

        .sidebar ul li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar ul li a:hover {
            background: #f8f9fa;
            color: #0056b3;
        }

        .submenu, .submenu_escola {
            display: none;
            margin-left: 20px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .submenu.active, .submenu_escola.active {
            display: block;
        }

        .menu-toggle.active + ul {
            display: block;
        }

        .menu-link.active {
            background: #e3f2fd;
            border-left: 4px solid #0056b3;
        }

        .disabled {
            color: #6c757d !important;
            cursor: not-allowed !important;
        }

        /* Welcome block */
        .welcome-block {
            margin: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Content container */
        #main-content {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Barra horizontal -->
    <div class="horizontal-bar">
        <div class="logo">Supergando TEA</div>
        <div class="menu">
            <a href="#"><i class="fa-solid fa-user"></i> MINHA CONTA</a>
        </div>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="menu-logo">
                <img src="{{ asset('img/logo_sap.png') }}" alt="Logo">
            </div>
            
            <div class="user-welcome" style="text-align:center; margin-bottom:15px;">
                <div style="font-size:1.15em; font-weight:600; color:#0056b3;">Olá, {{ Auth::guard('funcionario')->user()->func_nome ?? 'Usuário' }}!</div>
                <div style="font-size:0.97em; color:#555;">{{ Auth::guard('funcionario')->user()->email_func ?? '' }}</div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
                    @csrf
                    <button type="submit" style="background:#e74c3c; color:#fff; border:none; border-radius:4px; padding:4px 16px; font-weight:500; cursor:pointer;">Sair</button>
                </form>
            </div>

            <div class="welcome-block">
                <div style="font-size:1.15em; font-weight:600; color:#0056b3; margin-bottom:5px;">Bem-vindo ao SAP-TEA!</div>
                <div style="font-size:1em; color:#222;">Esta é sua área inicial. Utilize o menu ao lado para acessar as funcionalidades.<br>Conte sempre com o suporte do SAP-TEA para apoiar o desenvolvimento dos estudantes TEA.<br><span style="color:#009688; font-weight:500;">"Juntos superando desafios, celebrando conquistas!"</span></div>
            </div>

            <ul>
                {{--
                <li>
                    <a href="{{ route('rotina.monitoramento.inicial') }}" class="menu-link" data-page="Monitoramento do estudante">
                        <i class="fa-solid fa-clipboard-list"></i> Monitoramento do estudante
                    </a>
                </li>
                --}}
                <li>
                    <a href="#" class="menu-toggle sondagem" data-page="Sondagem Pedagógica">
                        <i class="fa-solid fa-school"></i> Sondagem Pedagógica ⬇
                    </a>
                    <ul class="submenu">
                      ->   <li><a href="{{ route('eixos.alunos') }}" class="menu-link" data-page="Sondagem Inicial">.1 Inicial</a></li>
                        <li><a href="{{ route('sondagem.continuada1') }}" class="disabled" title="Em breve">.2 Continuada</a></li>
                        <li><a href="{{ route('sondagem.continuada2') }}" class="disabled" title="Em breve">.3 Continuada</a></li>
                        <li><a href="{{ route('sondagem.final') }}" class="disabled" title="Em breve">.4 Final</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-toggle" data-page="Rotina e Monitoramento">
                        <i class="fa-solid fa-school"></i> Rotina e Monitoramento ⬇
                    </a>
                    <ul class="submenu_escola">
                        <li><a href="{{ route('rotina.monitoramento.inicial') }}" class="menu-link" data-page="Rotina Inicial">.1 Inicial</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.2 Continuada</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.3 Continuada</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.4 Final</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-toggle" data-page="Indicativo de Atividades">
                        <i class="fa-solid fa-tasks"></i> Indicativo de Atividades ⬇
                    </a>
                    <ul class="submenu_escola">
                        <li><a href="#" class="disabled" title="Em breve">.1 Inicial</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.2 Continuada</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.3 Continuada</a></li>
                        <li><a href="#" class="disabled" title="Em breve">.4 Final</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('perfil.estudante') }}" class="menu-link" data-page="Perfil do Estudante">
                        <i class="fa-solid fa-graduation-cap"></i> Perfil do Estudante
                    </a>
                </li>
                <!--
                <li>
                    <a href="{{ route('visualizar.perfil', ['id' => 1]) }}" class="menu-link" data-page="Atualizar Perfil">
                        <i class="fa-solid fa-user-edit"></i>  Perfil
                    </a>
                </li>
                -->
            </ul>

            <h3 style="margin:20px 15px 10px;">Foccus - Cadastros</h3>
            <ul>
                <li>
                    <a href="{{ route('foccus.xampp') }}" class="menu-link" data-page="Gerenciamento Foccus">
                        <i class="fa-solid fa-building-columns"></i> Gerenciamento
                    </a>
                </li>
            </ul>

            <h3 style="margin:20px 15px 10px;">Download de Materiais</h3>
            <ul>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'como-eu-sou']) }}" class="menu-link">
                        <i class="fa-solid fa-user"></i> Eu como sou
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'emocionometro']) }}" class="menu-link">
                        <i class="fa-solid fa-heart"></i> Emocionômetro
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'rede-ajuda']) }}" class="menu-link">
                        <i class="fa-solid fa-users"></i> Minha Rede de Ajuda
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'turma-supergando']) }}" class="menu-link">
                        <i class="fa-solid fa-people-group"></i> Turma Supergando
                    </a>
                </li>
            </ul>
            <div style="font-size:13px;color:#555;margin:15px;">
                <i class="fa-solid fa-circle-info"></i> Clique em um dos materiais acima para acessar e baixar os arquivos no Google Drive.
            </div>
        </div>

        <!-- Área de conteúdo principal -->
        <div class="content-area">
            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <a href="{{ route('index') }}"><i class="fa-solid fa-home"></i> Início</a>
                <span class="separator">/</span>
                <span id="current-page">@yield('title', 'Página Inicial')</span>
            </div>

            <!-- Área onde o conteúdo dos formulários será carregado -->
            <div id="main-content">
                @yield('content')

                <!-- Modal do Vídeo de Boas-Vindas -->
                <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="videoModalLabel">Bem-vindo ao Sistema SAP-TEA</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <div class="ratio ratio-16x9" style="width:100%; max-width:700px;">
                                        <video id="videoPlayer" controls playsinline style="width:100%; height:100%; object-fit:cover;">
                                            <source src="{{ asset('videos/exemplo.mp4') }}" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dontShowAgain">
                                        <label class="form-check-label" for="dontShowAgain">
                                            Não mostrar este vídeo novamente
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle para submenus
            const menuToggles = document.querySelectorAll('.menu-toggle');
            menuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    const submenu = this.nextElementSibling;
                    if (submenu) {
                        submenu.classList.toggle('active');
                    }
                });
            });

            // Atualizar breadcrumb e menu ativo baseado na página atual
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.menu-link');
            menuLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                    const pageName = link.getAttribute('data-page') || link.textContent.trim();
                    document.getElementById('current-page').textContent = pageName;
                    // Expandir submenu pai se existir
                    const parentToggle = link.closest('li').previousElementSibling;
                    if (parentToggle && parentToggle.classList.contains('menu-toggle')) {
                        parentToggle.classList.add('active');
                        parentToggle.nextElementSibling.classList.add('active');
                    }
                }
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts do Vídeo -->
    <script>
        // Função para verificar se o Bootstrap está carregado
        function isBootstrapLoaded() {
            return typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined';
        }

        // Função para mostrar o modal
        function showWelcomeVideo() {
            // Verifica se o usuário já viu o vídeo
            let videoSeen = localStorage.getItem('video_seen');
            console.log('Bootstrap:', typeof bootstrap, 'Modal:', typeof bootstrap.Modal, 'videoSeen:', videoSeen);

            // Se o vídeo não foi visto ainda
            if (!videoSeen) {
                // Espera o Bootstrap carregar
                if (isBootstrapLoaded()) {
                    // Mostra o modal após 2 segundos
                    setTimeout(function() {
                        var modal = new bootstrap.Modal(document.getElementById('videoModal'));
                        if (modal) {
                            console.log('Mostrando modal do vídeo!');
                            modal.show();
                        } else {
                            console.error('Não foi possível instanciar o modal!');
                        }
                    }, 2000);

                    // Quando o modal é fechado
                    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                        // Se o usuário marcou para não mostrar novamente
                        if (document.getElementById('dontShowAgain').checked) {
                            localStorage.setItem('video_seen', 'true');
                        }
                    });
                } else {
                    console.error('Bootstrap não está carregado');
                }
            }
        }

        // Inicializa quando o DOM estiver pronto
        document.addEventListener('DOMContentLoaded', function() {
            // Verifica se o modal existe
            if (document.getElementById('videoModal')) {
                showWelcomeVideo();
                // Botão de teste para forçar o modal
                document.getElementById('testModal').addEventListener('click', function() {
                    if (isBootstrapLoaded()) {
                        var modal = new bootstrap.Modal(document.getElementById('videoModal'));
                        modal.show();
                    } else {
                        alert('Bootstrap não está carregado!');
                    }
                });
            }
        });
    </script>
    @yield('scripts')

</body>
</html>
