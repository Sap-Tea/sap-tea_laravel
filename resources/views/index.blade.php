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
<body>
    <!-- Barra horizontal -->
    <div class="horizontal-bar">
        <div class="logo">Supergando TEA</div>
        <div class="menu">
            <a href="#"><i class="fa-solid fa-user"></i> MINHA CONTA</a>
        </div>
    </div>

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
        <div class="welcome-block" style="background:#f0f6ff; border-left:5px solid #0056b3; padding:16px 18px; margin-bottom:18px; border-radius:7px;">
            <div style="font-size:1.15em; font-weight:600; color:#0056b3; margin-bottom:5px;">Bem-vindo ao SAP-TEA!</div>
            <div style="font-size:1em; color:#222;">Esta é sua área inicial. Utilize o menu ao lado para acessar as funcionalidades.<br>Conte sempre com o suporte do SAP-TEA para apoiar o desenvolvimento dos alunos TEA.<br><span style="color:#009688; font-weight:500;">"Juntos superando desafios, celebrando conquistas!"</span></div>
        </div>
        <ul>
            <li>
                <a href="{{ route('rotina.monitoramento.inicial') }}" class="menu-link"><i class="fa-solid fa-clipboard-list"></i> Monitoramento do Aluno</a>
            </li>
            <li>
                <a href="#" class="menu-toggle sondagem"><i class="fa-solid fa-school"></i> Sondagem Pedagógica ⬇</a>
                <ul class="submenu">
                    <li><a href="{{ route('eixos.alunos') }}" class="menu-link">.1 Inicial</a></li>
                    <li><a href="{{ route('sondagem.continuada1') }}" class="disabled">.2 Continuada</a></li>
                    <li><a href="{{ route('sondagem.continuada2') }}" class="disabled">.3 Continuada</a></li>
                    <li><a href="{{ route('sondagem.final') }}" class="disabled">.4 Final</a></li>
                </ul>
            </li>
    </ul>
</li>

            <li>
                <a href="#" class="menu-toggle"><i class="fa-solid fa-school"></i> Rotina e Monitoramento ⬇</a>
                <ul class="submenu_escola">
                    <li><a href="{{ route('rotina.monitoramento.inicial') }}">.1 Inicial</a></li>
                    <li><a href="#" class="disabled">.2 Continuada</a></li>
                    <li><a href="#" class="disabled">.2 Continuada</a></li>
                    <li><a href="#" class="disabled">.3 Continuada</a></li>
                    <li><a href="#" class="disabled">.4 Final</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="menu-toggle"><i class="fa-solid fa-school"></i> Indicativo de Atividades e Habilidades ⬇</a>
                <ul class="submenu_escola">
                    <li><a href="#" class="disabled">.1 Inicial</a></li>
                    <li><a href="#" class="disabled">.2 Continuada</a></li>
                    <li><a href="#" class="disabled">.3 Continuada</a></li>
                    <li><a href="#" class="disabled">.4 Final</a></li>
                </ul>
            </li>
            <li><a href="{{ route('perfil.estudante') }}" target="_blank"><i class="fa-solid fa-graduation-cap"></i> Perfil do Estudante</a></li>
        </ul>

        <h3>Foccus - Cadastros</h3>
        <ul>
            <li><a href="{{ route('foccus.xampp') }}"><i class="fa-solid fa-building-columns"></i> Gerenciamento</a></li>
            <h3>Download de Materiais</h3>
            <ul>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'como-eu-sou']) }}">
                        <i class="fa-solid fa-user"></i> Eu como sou
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'emocionometro']) }}">
                        <i class="fa-solid fa-heart"></i> Emocionômetro
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'rede-ajuda']) }}">
                        <i class="fa-solid fa-users"></i> Minha Rede de Ajuda
                    </a>
                </li>
                <li>
                    <a href="{{ route('download.material', ['tipo' => 'turma-supergando']) }}">
                        <i class="fa-solid fa-people-group"></i> Turma Supergando
                    </a>
                </li>
            </ul>
            <div style="font-size:13px;color:#555;margin:6px 0 18px 0;">
                <i class="fa-solid fa-circle-info"></i> Clique em um dos materiais acima para acessar e baixar os arquivos no Google Drive.
            </div>
        </div>

        <div id="formulario-container"></div>

        <script src="public/js/script.js"></script>

   
</body>
</html>
