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
            <label for="usuario">Usuário</label>
            <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" autofocus>
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
            <a href="/">Esqueci minha senha</a>
            <button class="btn" onclick="compararValor()">Acessar</button>
        </div>
        <div class="notificacao" id="notificacao"></div>
    </div>
</body>
</html>
