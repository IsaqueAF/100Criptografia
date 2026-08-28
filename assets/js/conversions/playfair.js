// ============================================================================
// ETAPA 1: GERADOR DA MATRIZ 5x5
// ============================================================================
function gerarMatrizPlayfair(chave) {
    // Transforma em maiúsculas, troca J por I e remove caracteres inválidos
    chave = chave.toUpperCase().replace(/J/g, "I").replace(/[^A-Z]/g, "");
    
    const alfabeto = "ABCDEFGHIKLMNOPQRSTUVWXYZ"; // Alfabeto sem o J
    const stringBruta = chave + alfabeto;
    let letrasUnicas = "";

    // Remove duplicatas
    for (let i = 0; i < stringBruta.length; i++) {
        let letra = stringBruta[i];
        if (letrasUnicas.indexOf(letra) === -1) {
            letrasUnicas += letra;
        }
    }

    // Estrutura a matriz bidimensional 5x5
    let matriz = [];
    for (let i = 0; i < 25; i += 5) {
        matriz.push(letrasUnicas.slice(i, i + 5).split(""));
    }
    return matriz;
}

// Função auxiliar para encontrar a Linha e Coluna de uma letra na matriz
function encontrarPosicao(matriz, letra) {
    // Lógica de segurança: se a mensagem contiver J, trata como I
    if (letra === "J") letra = "I"; 
    
    for (let l = 0; l < 5; l++) {
        for (let c = 0; c < 5; c++) {
            if (matriz[l][c] === letra) {
                return { linha: l, coluna: c };
            }
        }
    }
    return null;
}

// ============================================================================
// ETAPA 2: TRATAMENTO DO TEXTO EM PARES (DÍGRAFOS)
// ============================================================================
function prepararTexto(texto) {
    texto = texto.toUpperCase().replace(/J/g, "I").replace(/[^A-Z]/g, "");
    let resultado = [];
    
    for (let i = 0; i < texto.length; i += 2) {
        let letra1 = texto[i];
        let letra2 = texto[i + 1];

        // Se sobrar uma letra sozinha no final do texto
        if (letra2 === undefined) {
            resultado.push(letra1 + "X");
        } 
        // Se as duas letras do par forem iguais (ex: EE)
        else if (letra1 === letra2) {
            resultado.push(letra1 + "X");
            i--; // Decrementa para processar a segunda letra no próximo par
        } 
        // Par normal e válido
        else {
            resultado.push(letra1 + "letra2" === undefined ? letra1 + "X" : letra1 + letra2);
        }
    }
    return resultado;
}

// Função de correção para garantir o split correto de dígrafos normais
function organizarEmPares(texto) {
    texto = texto.toUpperCase().replace(/J/g, "I").replace(/[^A-Z]/g, "");
    let pares = [];
    let i = 0;
    
    while (i < texto.length) {
        let l1 = texto[i];
        let l2 = texto[i + 1];
        
        if (!l2) {
            pares.push(l1 + "X");
            i++;
        } else if (l1 === l2) {
            pares.push(l1 + "X");
            i++;
        } else {
            pares.push(l1 + l2);
            i += 2;
        }
    }
    return pares;
}

// ============================================================================
// ETAPA 3: MOTOR DA CIFRA (CODIFICAÇÃO E DECODIFICAÇÃO)
// ============================================================================
function processarPlayfair(texto, chave, modo) {
    const matriz = gerarMatrizPlayfair(chave);
    const pares = organizarEmPares(texto);
    let resultadoFinal = "";

    // Define a direção do movimento na tabela (+1 para codificar, -1/4 para decodificar)
    // Usamos +4 na subtração para evitar problemas com números negativos no operador de resto (%)
    let deslocamento = (modo === "criptografar") ? 1 : 4;

    for (let i = 0; i < pares.length; i++) {
        let p1 = encontrarPosicao(matriz, pares[i][0]);
        let p2 = encontrarPosicao(matriz, pares[i][1]);

        if (!p1 || !p2) continue; // Pula se houver caracteres inválidos estranhos

        // REGRA 1: Mesma Linha -> Move para a direita (ou esquerda na decodificação)
        if (p1.linha === p2.linha) {
            resultadoFinal += matriz[p1.linha][(p1.coluna + deslocamento) % 5];
            resultadoFinal += matriz[p2.linha][(p2.coluna + deslocamento) % 5];
        }
        // REGRA 2: Mesma Coluna -> Move para baixo (ou cima na decodificação)
        else if (p1.coluna === p2.coluna) {
            resultadoFinal += matriz[(p1.linha + deslocamento) % 5][p1.coluna];
            resultadoFinal += matriz[(p2.linha + deslocamento) % 5][p2.coluna];
        }
        // REGRA 3: Retângulo -> Inverte as colunas mantendo as linhas originais
        else {
            resultadoFinal += matriz[p1.linha][p2.coluna];
            resultadoFinal += matriz[p2.linha][p1.coluna];
        }
    }

    return resultadoFinal;
}

// Funções públicas que serão chamadas pelos botões do seu site
function codificacaoPlayfair(texto, chave) {
    return processarPlayfair(texto, chave, "criptografar");
}

function decodificacaoPlayfair(texto, chave) {
    return processarPlayfair(texto, chave, "descriptografar");
}
