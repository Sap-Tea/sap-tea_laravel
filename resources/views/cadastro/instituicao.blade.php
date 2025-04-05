<!-- resources/views/cadastro/instituicao.blade.php -->
@extends('layouts.app')

@section('content')
    

<div id="formulario-cad-instituicao" class="formulario"> 
    <form action="views/forms/incluir_instituicao.php" method="POST">
        <h2>Cadastro de Instituição</h2>
        <section>
          

            <div class="elemento">
                <div>
                    <label> CNPJ <br></br></label>
                    <input class="inputgeral" style="width: 100%;" type='text' name="cnpj_inst" id="cnpj_inst" placeholder='__.___.___/___-__  ' autoComplete='off' required/>
                </div>
            </div>

            <div class="elemento">
                <div>
                    <label> Endereço<br></br></label>
                    <input class="inputgeral" style="width: 100%;" type='text' name="endereco_inst" id="endereco_inst" placeholder='Digite seu endereço' autoComplete='off' required/>
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label> Bairro<br></br></label>
                    <input class="inputgeral" style="width: 100%;" type='text' name="bairro_inst" id="bairro_inst" placeholder='Digite seu bairro' autoComplete='off' required/>
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label> Município<br></br></label>
                    <input class="inputgeral" style="width: 100%;" type='text' name="municipio_inst" id="municipio_inst" placeholder='Digite seu bairro' autoComplete='off' required/>
                </div>
            </div>

            <div class="elemento">
                <div>
                    <label> CEP <br></br></label>
                    <input class="inputgeral" style="width: 100%;" type='text' name="cep_inst" id="cep_inst" placeholder='*****-***' autoComplete='off' required/>
                </div>
            </div>

            <div class="elemento">
                <div class="elemento">
                    <div>
                        <label>Estado<br></br></label> 
                        <select name="inst_uf" class="selectgeral" style="width: 100%;" autoComplete='off' required> 
                            <option value="SP">SP</option>
                            <option value="RO">RO</option>
                            <option value="AC">AC</option>
                            <option value="AM">AM</option>
                            <option value="RR">RR</option>
                            <option value="PA">PA</option>
                            <option value="AP">AP</option>
                            <option value="TO">TO</option>
                            <option value="MA">MA</option>
                            <option value="PI">PI</option>
                            <option value="CE">CE</option>
                            <option value="RN">RN</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="AL">AL</option>
                            <option value="SE">SE</option>
                            <option value="BA">BA</option>
                            <option value="MG">MG</option>
                            <option value="ES">ES</option>
                            <option value="RJ">RJ</option>
                            <option value="PR">PR</option>
                            <option value="SC">SC</option>
                            <option value="RS">RS</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="GO">GO</option>
                            <option value="DF">DF</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label> E-mail<br></br></label> 
                    <input class="inputgeral" style="width: 100%;" type='text' name="email_inst" id="email_inst" placeholder='Exemplo@email.com' autoComplete='off' required/>
                </div>
            </div>
            <div class="elemento">
                <div>
                    <label> Telefone<br></br></label> 
                    <input class="inputgeral" style="width: 100%;" name="telefone_inst" id="telefone_inst" type='text' placeholder='( * * ) * * * * * - * * * * ' autoComplete='off' required/>
                </div>
                <div class="elemento">
                <div>
                    <label> Telefone 02<br></br></label> 
                    <input class="inputgeral" style="width: 100%;" name="telefone2_inst" id="telefone2_inst" type='text' placeholder='( * * ) * * * * * - * * * * ' autoComplete='off'/>
                </div>    

        </section>
<div class="di button-container">
    <button class="submitbtn" type="submit" name="submit">Enviar</button> 
    <button class="cancelbtn" id="fecharintituicao">Cancelar</button> 
    <a class="listarbtn" id="listarbtn" data-url="controller/imprime_instituicao.php">Listar</a>
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
</script>
@endsection