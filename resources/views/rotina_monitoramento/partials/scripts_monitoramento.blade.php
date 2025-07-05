<script>
// Garantir que o JS está carregado
console.log('[scripts_monitoramento] JS carregado');

// Listener para todos os botões salvar do eixo comunicacao
function adicionarListenersSalvarComunicacao() {
    document.querySelectorAll('button.btn-salvar-linha[data-eixo="comunicacao"]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('[scripts_monitoramento] Clique no botão salvar atividade (comunicacao)', this);
            // Coletar dados da linha
            const linha = this.closest('tr[data-eixo="comunicacao"]');
            if (!linha) {
                console.error('Linha não encontrada para salvar.');
                return;
            }
            const idx = linha.getAttribute('data-idx');
            const cod_atividade = linha.getAttribute('data-cod-atividade');
            const aluno_id = document.querySelector('input[name="aluno_id"]').value;
            const data_aplicacao = linha.querySelector('input[type="date"]').value;
            const sim_inicial = linha.querySelector('input[name$="[sim_inicial]"]').checked ? 1 : 0;
            const nao_inicial = linha.querySelector('input[name$="[nao_inicial]"]').checked ? 1 : 0;
            const observacoes = linha.querySelector('textarea[name$="[observacoes]"]').value;
            const flag = linha.querySelector('input[name$="[flag]"]').value;
            // Gera registro_timestamp único
            const registro_timestamp = Date.now();

            // Monta os dados para envio
            const payload = {
                aluno_id,
                cod_atividade,
                data_aplicacao,
                realizado: sim_inicial,
                observacoes,
                fase_cadastro: 'Inicial',
                registro_timestamp,
                flag
            };
            console.log('[scripts_monitoramento] Dados a enviar:', payload);

            // Envia via AJAX para a rota Laravel (ajuste a rota conforme seu backend)
            fetch('/monitoramento/salvar-eixo-comunicacao', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    alert('Atividade salva com sucesso!');
                    // Opcional: desabilitar a linha ou atualizar visualmente
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
    document.addEventListener('DOMContentLoaded', adicionarListenersSalvarComunicacao);
} else {
    adicionarListenersSalvarComunicacao();
}

</script>
