<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    
    <style>
        body {
    background-image: url('{{ asset("img/tela_azul.jpg") }}'); /* Caminho da imagem de fundo em Laravel */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;

}

        .notificacao {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            display: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease-in-out;
        }
        .notificacao.sucesso {
            background-color: #28a745;
            display: block;
        }
        .notificacao.erro {
            background-color: #dc3545;
            display: block;
        }
    </style>

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
        
        </a>
        </a>
    </div>
    <div class="page" style="margin-bottom: 110px; display: flex; justify-content: flex-end; width: 100%;">
        <img src="{{ asset('img/sap_logo2.png') }}" alt="Imagem representativa">
        <div class="formLogin" style="max-width: 600px; min-width: 360px; padding: 18px 32px 10px 32px; box-sizing: border-box; background: #fff; border-radius: 16px; box-shadow: 0 4px 18px #0001; display: flex; flex-direction: column; align-items: center; margin-right: 200px; margin-top: 40px;">
            <img src="{{ asset('img/logo_sap.png') }}" alt="Imagem de Login" class="logoSap">
            <div class="login-header">
        <h2>bem-vindo</h2>
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
    <!-- Logos nas extremidades, na mesma linha, abaixo do link 'Primeiro acesso' -->
    <div style="margin: 20px auto 0 auto; max-width: 420px; min-width: 300px; width: 100%; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
      <img src="{{ asset('img/logo_tea.png') }}" alt="Logo TEA" style="width: 150px; height: auto; object-fit: contain;">
      <img src="{{ asset('img/logo_foccus.png') }}" alt="Logo Foccus" style="width: 150px; height: auto; object-fit: contain;">
    </div>
    @if ($errors->any())
        <div class="notificacao erro" id="notificacao">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <style>
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-instrucoes {
            font-size: 1.05em;
            color: #333;
            margin-top: 8px;
            margin-bottom: 0;
        }
        .login-form {
            margin-top: 10px;
        }
        .form-group {
            margin-bottom: 14px;
        }
        .btn-acesso {
            width: 100%;
            background: #0056b3;
            color: #fff;
            font-weight: bold;
            font-size: 1.1em;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 8px;
        }
        .btn-acesso:hover {
            background: #003a75;
        }
        .login-links {
            text-align: center;
            margin-top: 5px;
        }
        .link-senha {
            color: #0056b3;
            text-decoration: underline;
            font-size: 1em;
            white-space: nowrap;
        }
        .link-senha:hover {
            color: #003a75;
        }
    </style>

        </div>
        <div class="notificacao" id="notificacao"></div>
    </div>

</body>
</html>
