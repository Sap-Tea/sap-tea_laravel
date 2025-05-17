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
            <strong>Não consegue acessar sua conta?</strong> Entre em contato com o suporte 
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width: 20px; height: 20px; margin-left: 5px; vertical-align: middle;">
            <span style="font-weight: bold;">+55 11 99231-2745</span>
        </a>
        
        </a>
        </a>
    </div>
    <div class="page">
        <img src="{{ asset('img/sap_logo2.png') }}" alt="Imagem representativa">
        <div class="formLogin">
            <img src="{{ asset('img/logo_sap.png') }}" alt="Imagem de Login" class="logoSap">
            <div class="login-header">
        <h2>Bem-vindo ao SAP-TEA</h2>
        <p class="login-instrucoes">Acesse com seu e-mail institucional e senha cadastrada.<br>Se for o <strong>primeiro acesso</strong>, clique no link abaixo para cadastrar sua senha.</p>
    </div>
    @if (session('status'))
        <div class="notificacao sucesso" id="notificacao">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        <div class="form-group">
            <label for="email_func">E-mail</label>
            <input type="email" name="email_func" id="email_func" placeholder="Digite seu e-mail" required autofocus value="{{ old('email_func') }}">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
        </div>
        <div class="form-group" style="display: flex; align-items: center; margin-bottom: 10px;">
            <input type="checkbox" name="remember" id="remember" style="margin-right: 7px;">
            <label for="remember" style="margin-bottom: 0; font-size: 1em; cursor: pointer;">Lembre-me nesta máquina</label>
        </div>
        <button class="btn btn-acesso" type="submit">Entrar</button>
        <div class="login-links">
            <a href="{{ route('password.request') }}" class="link-senha">Esqueci minha senha</a>
        </div>
    </form>
    <div class="login-links" style="margin-top: 22px;">
        <a href="{{ url('/primeiro-acesso') }}" class="link-senha" style="font-size:1.02em;font-weight:bold;">Primeiro acesso? Clique aqui para cadastrar sua senha</a>
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
