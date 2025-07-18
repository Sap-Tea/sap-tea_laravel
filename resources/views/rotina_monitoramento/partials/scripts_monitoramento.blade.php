<script>
// Garantir que o JS está carregado
console.log('[scripts_monitoramento] JS carregado');

// Listener para todos os botões salvar do eixo comunicacao
function adicionarListenersSalvarLinhaGenerico() {
    document.querySelectorAll('button.btn-salvar-linha').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const eixo = this.getAttribute('data-eixo');
            console.log(`[scripts_monitoramento] Clique no botão salvar atividade (eixo: ${eixo})`, this);
            // Coletar dados da linha
            const linha = this.closest(`tr[data-eixo="${eixo}"]`);
            if (!linha) {
                console.error('Linha não encontrada para salvar.');
                alert('Erro interno: linha não localizada.');
                return;
            }
            // Coleta campos dinâmicos
            const idx = linha.getAttribute('data-idx') || '';
            const cod_atividade = linha.getAttribute('data-cod-atividade') || '';
            const alunoInput = document.getElementById('aluno_id_hidden') || document.querySelector('input[name="aluno_id"]');
            let aluno_id = alunoInput ? alunoInput.value : '';
            if (!aluno_id) {
                // Extrai o ID da URL, ex: /rotina_monitoramento/cadastrar/52
                const match = window.location.pathname.match(/cadastrar\/(\d+)/);
                if (match) {
                    aluno_id = match[1];
                    if (alunoInput) alunoInput.value = aluno_id;
                }
            }
            if (!aluno_id) {
                alert('ID do aluno não encontrado! Não é possível salvar.');
                return;
            }
            const dataInput = linha.querySelector('input[type="date"]');
            const data_aplicacao = dataInput ? dataInput.value : '';
            // Checagem dinâmica dos checkboxes
            const simInput = linha.querySelector('input[name$="[sim_inicial]"]');
            const sim_inicial = simInput ? (simInput.checked ? 1 : 0) : 0;
            const naoInput = linha.querySelector('input[name$="[nao_inicial]"]');
            const nao_inicial = naoInput ? (naoInput.checked ? 1 : 0) : 0;
            const obsInput = linha.querySelector('textarea[name$="[observacoes]"]');
            const observacoes = obsInput ? obsInput.value : '';
            const flagInput = linha.querySelector('input[name$="[flag]"]');
            let flag = flagInput ? flagInput.value : '';
            flag = flag ? parseInt(flag, 10) : 1;
            const registro_timestamp = Date.now();

            // Validação: exige data_aplicacao e apenas um checkbox marcado (sim OU não)
            if (!data_aplicacao) {
                alert('Por favor, preencha a data de aplicação.');
                return;
            }
            if ((sim_inicial === 1 && nao_inicial === 1) || (sim_inicial === 0 && nao_inicial === 0)) {
                alert('Por favor, marque apenas uma opção: "Sim" OU "Não" para realização da atividade.');
                return;
            }
            
            console.log(`[scripts_monitoramento] Flag encontrado: ${flag}`);
            
            // Monta os dados para envio
            // Payload exatamente como o backend espera
            const payload = {
                aluno_id: aluno_id ? parseInt(aluno_id, 10) : null,
                cod_atividade: cod_atividade || '',
                data_inicial: data_aplicacao || '', // O backend converte para data_aplicacao
                sim_inicial: sim_inicial,
                nao_inicial: nao_inicial,
                observacoes: observacoes || '',
                flag: flag, // Usa o valor exato do flag da linha
                registro_timestamp: registro_timestamp
            };
            console.log(`[scripts_monitoramento] Payload FINAL para eixo ${eixo}:`, payload);

            // Monta o objeto para o backend: { eixo: [payload], aluno_id: xxx }
            const dataToSend = {
                aluno_id: aluno_id // Garante que aluno_id está no nível principal
            };
            dataToSend[eixo] = JSON.stringify([payload]); // Converte array para string JSON como o backend espera
            
            console.log('[scripts_monitoramento] Dados para enviar:', dataToSend);
            
            // Vamos criar um FormData diretamente com os dados corretos
            const formData = new FormData();
            
            // Adiciona todos os campos do dataToSend ao FormData
            for (const key in dataToSend) {
                formData.append(key, dataToSend[key]);
            }
            
            // Adiciona o token CSRF
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            console.log('[scripts_monitoramento] Enviando para backend (FormData):', formData);
            
            fetch('{{ route('monitoramento.salvar') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    // Não definimos Content-Type para que o navegador defina automaticamente com boundary
                },
                body: formData
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    // MODAL DE SUCESSO ROBUSTO
const modalMsg = document.getElementById('modalDuplicidadeMsg');
if (modalMsg) {
    modalMsg.textContent = 'Atividade salva com sucesso!';
}
const modalEl = document.getElementById('modalDuplicidadeMonitoramento');
if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
const botao = linha.querySelector('.btn-salvar-linha');
if (botao) {
    botao.disabled = true;
    botao.classList.remove('btn-success');
    botao.classList.add('btn-danger');
    botao.style.backgroundColor = '#dc3545'; // força cor vermelha
    botao.textContent = 'Atividade Salva';
    // Desabilitar os inputs da linha também
    const inputs = linha.querySelectorAll('input, textarea');
    inputs.forEach(input => { input.disabled = true; });
    console.log('[scripts_monitoramento] Botão desabilitado e cor alterada para vermelho (sucesso)');
}
return;
                } else {
                    // MODAL DE ERRO DE DUPLICIDADE OU OUTRO ERRO (ROBUSTO)
const modalMsg = document.getElementById('modalDuplicidadeMsg');
if (modalMsg) {
    modalMsg.textContent = data.message || 'Erro desconhecido ao salvar.';
}
const modalEl = document.getElementById('modalDuplicidadeMonitoramento');
if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}
const botao = linha.querySelector('.btn-salvar-linha');
if (botao) {
    botao.disabled = true;
    botao.classList.remove('btn-success');
    botao.classList.add('btn-danger');
    botao.style.backgroundColor = '#dc3545';
    botao.textContent = 'Já cadastrado!';
    console.log('[scripts_monitoramento] Botão desabilitado e cor alterada para vermelho (erro/duplicidade)');
}
return;
                }
            })
            .catch(err => {
                console.error('Erro AJAX:', err);
                const modalMsg = document.getElementById('modalDuplicidadeMsg');
if (modalMsg) {
    modalMsg.textContent = 'Erro na requisição: ' + err.message;
}
const modal = new bootstrap.Modal(document.getElementById('modalDuplicidadeMonitoramento'));
modal.show();
return;
            });
        });
    });
}

// Chama imediatamente ao carregar o script
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', adicionarListenersSalvarLinhaGenerico);
} else {
    adicionarListenersSalvarLinhaGenerico();
}


</script>
