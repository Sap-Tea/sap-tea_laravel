<!-- resources/views/cadastro/instituicao.blade.php -->
@extends('layouts.app')

@section('content')

    <style>
        .inputgeral {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none; /* Remove a borda azul padrão */
        }

        .inputgeral.meio {
            width: 50%;
        }

        .inputgeral:focus {
            border: 1px solid #007bff; /* Cor azul ao focar */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>

<div id="formulario-cad-funcionario" class="formulario">
    <form action="/proj_foccus/views/forms/incluir_funcionario.php" method="POST">
        <h2>Cadastro de Funcionario</h2>
        <section>
            <div class="elemento">
                <div>
                    <label>Inep da escola</label>
                    <input class="inputgeral meio" type='text' name="func_inep" id="func_inep" placeholder='Inep da escola' autoComplete='off' required />
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label>Nome do funcionario</label>
                    <input class="inputgeral meio" type='text' name="func_nome" id="func_nome" placeholder='Nome do funcionario' autoComplete='off' required />
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label>Cpf do funcionário</label>
                    <input class="inputgeral meio" type='text' name="func_cpf" id="func_cpf" placeholder='CPF' autoComplete='off' required maxlength="14" />

                    <span id="cpfValido"></span>
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label>Email do funcionário</label>
                    <input class="inputgeral meio" type="email" name="func_email" id="func_email" placeholder="Digite um email válido" autoComplete="off" required />
                </div>
            </div>

            <div class="elemento">
                <?php
                require_once('../../models/conexao.php');

                // Fetch data from the database
                $stmt = $conn->prepare("SELECT tipo_funcao_id,desc_tipo_funcao FROM tipo_funcao");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div>
                    <label for="func_desc">Cargo Ocupado</label>
                    <select name="func_desc" id="func_desc" class="selectgeral" style="width: 50%;" autocomplete="off">
                        <?php foreach ($result as $cargo) { ?>
                            <option value="<?php echo htmlspecialchars($cargo['tipo_funcao_id']); ?>">
                                <?php echo htmlspecialchars($cargo['desc_tipo_funcao']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <section>
                <div class="di button-container">
                    <button class="submitbtn" type="submit" name="submit" id="enviar">Enviar</button>
                    <button class="cancelbtn" id="fecharorgao">Cancelar</button>
                    
                    <button class="listarbtn" id="listarbtn" onclick="window.location.href='controller/imprime_funcionario.php'">
                        Listar
                    </button>
                    </div>
                    <div id="lista-container"></div>
                </div>
            </section>
        </section>
    </form>
</div>

<script>
   function mascaraCPF(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, '$1.$2.$3-$4');
}

document.getElementById('func_cpf').addEventListener('input', function (e) {
    let cpf = this.value.replace(/\D/g, '');
    this.value = mascaraCPF(cpf);
});

document.getElementById('func_cpf').addEventListener('blur', function (e) {
    let cpf = this.value.replace(/\D/g, '');
    if (validaCPF(cpf)) {
        document.getElementById('cpfValido').innerText = 'CPF válido';
        document.getElementById('cpfValido').style.color = 'green';
    } else {
        document.getElementById('cpfValido').innerText = 'CPF inválido';
        document.getElementById('cpfValido').style.color = 'red';
    }
});

document.getElementById('enviar').addEventListener('click', function (e) {
    let cpf = document.getElementById('func_cpf').value.replace(/\D/g, '');
    if (!validaCPF(cpf)) {
        alert('CPF inválido. Por favor, verifique e tente novamente.');
        e.preventDefault();
    }
});


</script>

</body>
</html>
@endsection