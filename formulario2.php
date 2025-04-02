<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Estudante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;

            position: relative;
    border-left: 10px solid rgba(0, 0, 0, 0.5); /* Amarelo apagado */
    padding-left: 15px; /* Ajuste para não colar no conteúdo */
        }
        h2 {
            text-align: center;
            color: #d35400;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }
        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        button {
            background-color: #d35400;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
        button:hover {
            background-color: #b03a00;
        }
        input, select, textarea {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .comunicacao-section {
    border-left: 10px solid #003366; /* Azul escuro */
    padding-left: 15px; /* Para afastar o texto da borda */
}


    </style>
</head>
<body>
    <div class="container">
        
        <h2>I - Perfil do Estudante</h2>
        <form>
            <div class="form-group">
                <label>Selecione o aluno:</label>
                <select><option>-- Selecione --</option></select>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Ano/Série:</label>
                    <input type="text">
                </div>
                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input type="date">
                </div>
                <div class="form-group">
                    <label>Idade:</label>
                    <input type="number">
                </div>
            </div>
            
            <div class="form-group">
                <label>Nome do Professor:</label>
                <input type="text" disabled placeholder="Dados importados do sistema">
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Possui diagnóstico/laudo?</label>
                    <select><option>Sim</option><option>Não</option></select>
                </div>
                <div class="form-group">
                    <label>CID:</label>
                    <input type="text">
                </div>
                <div class="form-group">
                    <label>Médico:</label>
                    <input type="text">
                </div>
                <div class="form-group">
                    <label>Data do Laudo:</label>
                    <input type="date">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Nível de suporte:</label>
                    <input type="text">
                </div>
                <div class="form-group">
                    <label>Faz uso de medicamento?</label>
                    <select><option>Sim</option><option>Não</option></select>
                </div>
                <div class="form-group">
                    <label>Quais?</label>
                    <input type="text">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Necessita de profissional de apoio em sala?</label>
                    <select><option>Sim</option><option>Não</option></select>
                </div>
                <div class="form-group">
                    <label>O estudante conta com profissional de apoio?</label>
                    <select><option>Sim</option><option>Não</option></select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Em quais momentos da rotina esse profissional se faz necessário?</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="locomocao"><label for="locomocao">Locomoção</label>
                    <input type="checkbox" id="higiene"><label for="higiene">Higiene</label>
                    <input type="checkbox" id="alimentacao"><label for="alimentacao">Alimentação</label>
                    <input type="checkbox" id="comunicacao"><label for="comunicacao">Comunicação</label>
                    <input type="checkbox" id="outros"><label for="outros">Outros momentos</label>
                </div>
                <input type="text" placeholder="Quais?">
            </div>
            
            <div class="form-group">
                <label>O estudante conta com Atendimento Educacional Especializado?</label>
                <select><option>Sim</option><option>Não</option></select>
            </div>
            
            <div class="form-group">
                <label>Nome do profissional do AEE:</label>
                <input type="text">
            </div>
            
            <h2>II - Particularidades da sua personalidade</h2>
            
            <div class="form-group">
                <label>Principais características:</label>
                <textarea rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Principais áreas de interesse (brinquedos, jogos, temas, etc.):</label>
                <textarea rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Gosta de fazer no tempo livre:</label>
                <textarea rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Deixa o estudante muito feliz:</label>
                <textarea rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label>Deixa o estudante muito triste ou desconfortável:</label>
                <textarea rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Objeto de apego? Qual?</label>
                <textarea rows="3"></textarea>
            </div>


            <h2 class="comunicacao-section">III - Comunicação</h2>


            <div class="form-group">
                <label>Precisa de comunicação alternativa para expressar-se?</label>
                <select>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label>Entende instruções? dadas de forma verbal ?</label>
                <select>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label>Caso não, qual? Como você recomenda dar instruções?</label>
                <textarea rows="3"></textarea>
            </div>


            <h2>III - Preferencias, sensibilidade e dificuldades</h2>
    
            <div class="form-group">
                <label>Apresenta sensibilidade:</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="s_auditiva"><label for="s_auditiva">Auditiva</label>
                    <input type="checkbox" id="s_visual"><label for="s_visual">Visual</label>
                    <input type="checkbox" id="s_tatil"><label for="s_tatil">Tátil</label>
                    <input type="checkbox" id="s_outros"><label for="s_outros">Outros estímulos</label>
                </div>
                
            </div>
            <div class="form-group">
                <label>Caso sim, qual? Como manejar em sala de aula</label>
                <textarea rows="3"></textarea>
            </div>
           
            <div class="form-group">
                <label>Apresenta seletividade alimentar?</label>
                <select>
                    <option>Sim</option>
                    <option>Não</option>
                </select>

            </div>
            <div class="form-group">
                <label>Alimentos preferidos:</label>
                <textarea rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Alimentos que evita:</label>
                <textarea rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Com quem tem mais afinidade na escola (professores,colegas)?Identifique</label>
                <textarea rows="3"></textarea>
            </div>
              <div class="form-group">
                <label>Como reage no contato com novas pessoas ou situaçõess</label>
                <textarea rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
          <label>O que ajuda e o que dificulta sua interação na escola?</label>
          <textarea rows="3"></textarea>
      </div>




            
            <button type="submit">Salvar</button>
        </form>
    </div>

    
</body>
</html>
