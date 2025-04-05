
<!-- resources/views/cadastro/instituicao.blade.php -->
@extends('layouts.app')

@section('content')
    


<div id="formulario-cad-instituicao" class="formulario"> 
    <form action="views/forms/incluir_escola.php" method="POST">
        <h2>Cadastro de Escola</h2>
        <section>
        <div class="elemento">
        <div>
            <label>Inep da escola<br></br></label>
            <input class="inputgeral" name="esc_inep"  style="width: 100%;" type='text' id="esc_inep"  autoComplete='off' required/>
        </div>
        </div>        
        <div class="elemento">
        <div>
            <label>CNPJ<br></br></label>
            <input class="inputgeral" name="esc_cnpj"  id="esc_cnpj" style="width: 100%;" type='text' id="cnpj"  placeholder='__.____.____ / ______' autoComplete='off' required/>
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>Nome da escola<br></br></label>
            <input class="inputgeral" name="esc_razao_social" id="esc_razao_social" style="width: 100%;" type='text' placeholder='Digite o nome da escola' autoComplete='off' required />
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>Endereco<br></br></label>
            <input class="inputgeral" name="esc_endereco" id="esc_endereco" 
            style="width: 100%;" type='text' placeholder='Digite o endereco da escola'
             autoComplete='off' required />
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>Bairro<br></br></label>
            <input class="inputgeral" name="esc_bairro" id="esc_bairro" style="width: 100%;" type='text' placeholder='Digite o bairro da escola' autoComplete='off' required/>
        </div>
        </div>

        <div class="elemento">
        <div>
            <label>Município<br></br></label>
            <input class="inputgeral" name="esc_municipio" id="esc_municipio"  style="width: 100%;" type='text' placeholder='Cidade' autoComplete='off' required/>
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>CEP<br></br></label>
            <input class="inputgeral" name="esc_cep" id="esc_cep"  style="width: 100%;" id="cep" type='text' placeholder=' * *   * * * - * * * ' autoComplete='off' required/>
        </div>
        </div>
        <div class="elemento">
        <div>
        <label>Estado<br></label>
        <select name="uf_org" id="uf_org" class="selectgeral" style="width: 100%;" autocomplete="off" required></select>
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>Telefone da Escola<br></br></label>
            <input class="inputgeral" style="width: 100%;"name="esc_telefone" id="esc_telefone" type='text' placeholder='( * * ) * * * * * - * * * *' autoComplete='off' required/>
        </div>
        </div>
        <div class="elemento">
        <div>
            <label>Email da escola<br></br></label>
            <input class="inputgeral" style="width: 100%;" name="esc_email" id="esc_email"   type='text' placeholder='Digite o email da escola' autoComplete='off' required/>
        </div>
        </div>
  
          
            
        </section>
<div class="di button-container">
    <button class="submitbtn" type="submit" name="submit">Enviar</button> 
    <button class="cancelbtn" id="fecharintituicao">Cancelar</button> 
    <a class="listarbtn" id="listarbtn" data-url="controller/imprime_escola.php">Listar</a>
</div>
        

            <div id="lista-container"></div>
        </div>
    </form>
</div>

<script>
  const estados = [
    "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA",
    "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN",
    "RS", "RO", "RR", "SC", "SP", "SE", "TO"
  ];

  const select = document.getElementById('uf_org');
  estados.forEach(uf => {
    const option = document.createElement('option');
    option.value = uf;
    option.textContent = uf;
    select.appendChild(option);
  });

@endsection