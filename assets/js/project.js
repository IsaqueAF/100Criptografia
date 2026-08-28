function toggleSidebar() {
    const sidebar = document.querySelector('.barra-lateral');
    if (sidebar) sidebar.style.display = sidebar.style.display == 'flex' ? 'none' : 'flex';
}

const etapas = [];
const nomes = {
    'Número': 'numero', 'Texto': 'texto', 'Binário': 'binario', 'Octal': 'octal',
    'Hexadecimal': 'hexadecimal', 'César': 'cesar', 'Bacon': 'bacon',
    'Atbash': 'atbash', 'Vigenère': 'vigenere', 'Playfair': 'playfair'
};
let presetSelecionado = null;

function pedirParametros(tipo) {
    if (tipo === 'cesar') return { chave: Number(prompt('Chave César:', '3')) || 0 };
    if (tipo === 'playfair') return { chave: prompt('Chave Playfair:', 'CHAVE') || 'CHAVE' };
    return {};
}

function desenharTrilha() {
    const container = document.getElementById('containerQuadradosAtivos');
    const vazio = document.getElementById('trilhaVazia');
    if (!container) return;
    container.innerHTML = '';
    vazio.hidden = etapas.length > 0;
    etapas.forEach((etapa, indice) => {
        const card = document.createElement('div');
        card.className = 'etapa-cifra';
        card.style.setProperty('--cor-etapa', etapa.cor);
        card.innerHTML = `<strong>${etapa.nome}</strong><span>${etapa.modo === 'decodificar' ? '←' : '→'}</span><button type="button" data-acao="editar" aria-label="Editar etapa">✎</button><button type="button" data-acao="remover" aria-label="Remover etapa">×</button>`;
        card.querySelector('[data-acao="editar"]').onclick = () => {
            etapa.modo = etapa.modo === 'codificar' ? 'decodificar' : 'codificar';
            if (etapa.nome === 'César' || etapa.nome === 'Playfair') etapa.parametros = pedirParametros(nomes[etapa.nome]);
            desenharTrilha();
        };
        card.querySelector('[data-acao="remover"]').onclick = () => { etapas.splice(indice, 1); desenharTrilha(); };
        container.appendChild(card);
    });
}

function converter(texto) {
    return etapas.reduce((valor, etapa) => {
        const tipo = nomes[etapa.nome];
        const parametros = etapa.parametros || {};
        if (tipo === 'atbash') return codificarAtbash(valor);
        if (tipo === 'bacon') return etapa.modo === 'codificar' ? codificarBacon(valor) : decodificarBacon(valor);
        if (tipo === 'binario') return etapa.modo === 'codificar' ? codificarBinario(valor) : decodificarBinario(valor);
        if (tipo === 'cesar') return etapa.modo === 'codificar' ? codificacaoCesar(valor, parametros.chave) : decodificacaoCesar(valor, parametros.chave);
        if (tipo === 'hexadecimal') return etapa.modo === 'codificar' ? codificacaoHexadecimal(valor) : decodificacaoHexadecimal(valor);
        if (tipo === 'octal') return etapa.modo === 'codificar' ? codificacaoOctal(valor) : decodificacaoOctal(valor);
        if (tipo === 'texto') return etapa.modo === 'codificar' ? codificacaoTexto(valor) : decodificacaoTexto(valor);
            if (tipo === 'numero') return etapa.modo === 'codificar' ? codificacaoTexto(valor) : decodificacaoTexto(valor);
            if (tipo === 'playfair') return etapa.modo === 'codificar' ? codificacaoPlayfair(valor, parametros.chave) : decodificacaoPlayfair(valor, parametros.chave);
        if (tipo === 'vigenere') return vigenere(valor, parametros.chave || 'CHAVE', etapa.modo === 'decodificar');
        return valor;
    }, texto);
}

function vigenere(texto, chave, decodificar) {
    let indice = 0;
    return [...texto].map(caractere => {
        if (!/[a-z]/i.test(caractere)) return caractere;
        const deslocamento = (chave.toUpperCase().charCodeAt(indice++ % chave.length) - 65) * (decodificar ? -1 : 1);
        const base = caractere === caractere.toUpperCase() ? 65 : 97;
        return String.fromCharCode((caractere.charCodeAt(0) - base + deslocamento + 26) % 26 + base);
    }).join('');
}

async function requisicao(dados) {
    const resposta = await fetch('actions/project-data.php', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(dados) });
    const corpo = await resposta.json();
    if (!resposta.ok) throw new Error(corpo.erro || 'Operação não concluída.');
    return corpo;
}

function aplicarPreset(preset) {
    etapas.splice(0, etapas.length, ...preset.estrutura.map(etapa => ({ ...etapa })));
    presetSelecionado = preset;
    desenharTrilha();
}

async function carregarPresets() {
    const lista = document.getElementById('lista-presets');
    if (!lista) return;
    try {
        const dados = await (await fetch('actions/project-data.php?acao=listar')).json();
        lista.innerHTML = '';
        dados.presets.forEach(preset => {
            const item = document.createElement('div');
            item.className = 'item-preset';
            item.innerHTML = `<span>${preset.nome}</span><button type="button" data-acao="carregar" title="Carregar">↓</button><button type="button" data-acao="substituir" title="Substituir">↻</button><button type="button" data-acao="deletar" title="Desativar">×</button>`;
            item.querySelector('[data-acao="carregar"]').onclick = () => aplicarPreset(preset);
            item.querySelector('[data-acao="substituir"]').onclick = async () => { await requisicao({ acao: 'substituir', id: preset.id, nome: preset.nome, estrutura: etapas }); carregarPresets(); };
            item.querySelector('[data-acao="deletar"]').onclick = async () => { if (confirm('Desativar este preset?')) { await requisicao({ acao: 'deletar', id: preset.id }); carregarPresets(); } };
            lista.appendChild(item);
        });
        if (!dados.presets.length) lista.textContent = 'Nenhum preset salvo.';
    } catch (erro) { lista.textContent = erro.message; }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.opcao-cifra').forEach(botao => botao.onclick = () => {
        const tipo = nomes[botao.dataset.nome];
        const parametros = pedirParametros(tipo);
        etapas.push({ nome: botao.dataset.nome, cor: botao.dataset.cor, modo: 'codificar', parametros });
        desenharTrilha();
    });
    document.getElementById('botao-converter')?.addEventListener('click', async () => {
        const entrada = document.getElementById('texto-entrada').value;
        const saida = converter(entrada);
        document.getElementById('texto-saida').value = saida;
        try { await requisicao({ acao: 'historico', entrada, saida, estrutura: etapas }); } catch (erro) { alert(erro.message); }
    });
    document.getElementById('botao-historico')?.addEventListener('click', async () => {
        try {
            const dados = await (await fetch('actions/project-data.php?acao=listar-historico')).json();
            if (!dados.historico.length) return alert('Nenhum histórico encontrado.');
            alert(dados.historico.map(item => `${item.data_execucao}: ${item.entrada} → ${item.saida}`).join('\n'));
        } catch (erro) { alert('Não foi possível carregar o histórico.'); }
    });
    document.getElementById('botao-salvar-preset')?.addEventListener('click', async () => {
        const nome = document.getElementById('nome-preset').value.trim();
        if (!nome) return alert('Informe um nome para o preset.');
        try { await requisicao({ acao: 'salvar', nome, estrutura: etapas }); document.getElementById('nome-preset').value = ''; carregarPresets(); } catch (erro) { alert(erro.message); }
    });
    carregarPresets();
    desenharTrilha();
});