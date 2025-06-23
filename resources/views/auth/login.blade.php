<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
     
<link rel="stylesheet" href="{{ asset('css/login-custom.css') }}">
  
    <script>
        function compararValor() {
            var nome = document.getElementById("usuario").value;
            var senha = document.getElementById("senha").value;
        
            if (nome === "" || senha === "") {
                notificar("Por favor, preencha todos os campos.", "erro");
                return;
            }
        
            if (nome === "foccus" && senha === "123") {
                notificar("Login bem-sucedido!", "sucesso");
            } else {
                notificar("Usuário ou senha incorretos.", "erro");
            }
        }

        function notificar(mensagem, tipo){
            var notificacao = document.getElementById("notificacao");
            notificacao.className = `notificacao ${tipo}`;
            notificacao.textContent = mensagem;
            notificacao.style.display = "block";
            
            setTimeout(() => {
                notificacao.style.opacity = "0";
                setTimeout(() => {
                    notificacao.style.display = "none";
                    notificacao.style.opacity = "1";
                    notificacao.className = "notificacao";
                    if (tipo === "sucesso"){
                        window.location.href = "/index";
                    }
                }, 500);
            }, 2000);
        }
    </script>
</head>
<body>

    <!-- Barra de navegação -->
    <div class="navbar">
        <a href="https://wa.me/5511992312745" target="_blank" style="text-decoration: none; color: inherit;">
            Não consegue acessar sua conta? Entre em contato com nosso suporte: (11) 9 9231-2745 ou suporte@foccuseditora.com.br
        </a>
    </div>
    
    <div class="page" style="margin-bottom: 20px; display: flex; justify-content: flex-end; width: 100%;">
        <img src="{{ asset('img/sap_logo2.png') }}" alt="Imagem representativa">
        <div class="formLogin" style="max-width: 600px; min-width: 360px; padding: 18px 32px 10px 32px; box-sizing: border-box; background: #fff; border-radius: 16px; box-shadow: 0 4px 18px #0001; display: flex; flex-direction: column; align-items: center; margin-right: 200px; margin-top: 40px;">
            <div class="login-header">
        <h2>bem-vindo</h2>
        <img src="{{ asset('img/logo_sap.png') }}" alt="Logo SAP" class="logo-inside">
        <p class="login-instrucoes">Acesse com seu e-mail institucional e senha cadastrada.<br>Se for o <strong>primeiro acesso</strong>, clique no link abaixo para cadastrar sua senha.</p>
    </div>
    @if (session('status'))
        <div class="notificacao sucesso" id="notificacao">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}" class="login-form" autocomplete="on" onsubmit="salvarLoginSenha()">
        @csrf
        <div class="form-group">
            <label for="email_func">Usuário</label>
            <input type="email" name="email_func" id="email_func" placeholder="Digite seu e-mail" required autofocus value="{{ old('email_func') }}" autocomplete="username">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required autocomplete="current-password">
        </div>
        <div class="form-group" style="display: flex; align-items: center; margin-bottom: 10px;">
            <input type="checkbox" name="remember" id="remember" style="margin-right: 7px;">
            <label for="remember" style="margin-bottom: 0; font-size: 1em; cursor: pointer;">Lembre-me nesta máquina</label>
            <input type="checkbox" id="mostrarSenhaLogin" onclick="mostrarOcultarSenhaLogin()" style="margin-left: 16px;">
            <label for="mostrarSenhaLogin" style="font-size:0.97em;cursor:pointer;margin-left:2px;">Mostrar senha</label>
        </div>
        <script>
            function mostrarOcultarSenhaLogin() {
                var senha = document.getElementById('password');
                if(document.getElementById('mostrarSenhaLogin').checked){
                    senha.type = 'text';
                } else {
                    senha.type = 'password';
                }
            }
        </script>
        <script>
        // Preencher campos se houver dados salvos
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('lembrar_login') === 'true') {
                var emailSalvo = localStorage.getItem('login_email') || '';
                var senhaSalva = localStorage.getItem('login_senha') || '';
                document.getElementById('email_func').value = emailSalvo;
                document.getElementById('password').value = senhaSalva;
                document.getElementById('remember').checked = true;
            }
        });
        // Salvar dados ao enviar o formulário
        function salvarLoginSenha() {
            var lembrar = document.getElementById('remember').checked;
            if(lembrar) {
                localStorage.setItem('lembrar_login', 'true');
                localStorage.setItem('login_email', document.getElementById('email_func').value);
                localStorage.setItem('login_senha', document.getElementById('password').value);
            } else {
                localStorage.removeItem('lembrar_login');
                localStorage.removeItem('login_email');
                localStorage.removeItem('login_senha');
            }
        }
        </script>
        <button class="btn btn-acesso" type="submit">Entrar</button>
        <div class="login-links">
            <a href="{{ route('password.request') }}" class="link-senha">Esqueci minha senha</a>
        </div>
    </form>
    <div class="login-links" style="margin-top: 22px;">
        <a href="{{ url('/primeiro-acesso') }}" class="link-senha" style="font-size:1.02em;font-weight:bold;">Primeiro acesso? Clique aqui para cadastrar sua senha</a>
    </div>
    </div>
    </div>
</div>

<!-- LOGOS CENTRALIZADAS (subindo devagar) -->
<div class="logos-container">
    <img src="{{ asset('img/logo_tea.png') }}" alt="Logo TEA">
    <img src="{{ asset('img/logo_foccus.png') }}" alt="Logo Foccus">
</div>

@if ($errors->any())
    <div class="notificacao erro" id="notificacao">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="notificacao" id="notificacao"></div>


</body>
</html>
