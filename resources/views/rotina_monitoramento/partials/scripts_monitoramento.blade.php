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
            const alunoInput = document.querySelector('input[name="aluno_id"]');
            const aluno_id = alunoInput ? alunoInput.value : '';
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

            // Monta os dados para envio
            // Payload exatamente como o backend espera
            const payload = {
                aluno_id: aluno_id ? parseInt(aluno_id, 10) : null,
                cod_atividade: cod_atividade || '',
                data_inicial: data_aplicacao || '', // O backend converte para data_aplicacao
                sim_inicial: sim_inicial,
                nao_inicial: nao_inicial,
                observacoes: observacoes || '',
                flag: flag ? parseInt(flag, 10) : 1,
                registro_timestamp: registro_timestamp
            };
            console.log(`[scripts_monitoramento] Payload FINAL para eixo ${eixo}:`, payload);

            // Monta o objeto para o backend: { eixo: [payload] }
            const dataToSend = {};
            dataToSend[eixo] = [payload];
            console.log('[scripts_monitoramento] Enviando para backend:', dataToSend);
            fetch('{{ route('monitoramento.salvar') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(dataToSend)
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    alert('Atividade salva com sucesso!');
                } else {
                    alert('Erro ao salvar: ' + (data.message || 'Erro desconhecido.'));
                }
            })
            .catch(err => {
                console.error('Erro AJAX:', err);
                alert('Erro na requisição: ' + err.message);
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
