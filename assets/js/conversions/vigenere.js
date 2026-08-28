function codificacaoVigenere(texto, chave) {
    texto = texto.toUpperCase();
    chave = chave.toUpperCase();
    let resultado = "";

    let iChave = 0;
    
    for (let i=0; i < texto.length; i++) {
        let textCode = texto.charCodeAt(i);

        if (textCode >= 65 && textCode <= 90) {
            let preResposta = chave.charCodeAt(iChave % chave.length) - 65;
            let resposta = ((textCode - 65 + preResposta) % 26) + 65;

            resultado += String.fromCharCode(resposta);
            iChave++;
        } else {
            resultado += texto[i];
        }
    }
    return resultado;
}


function decodificacaoVigenere(texto, chave) {
    texto = texto.toUpperCase();
    chave = chave.toUpperCase();
    let resultado = "";

    let iChave = 0;
    
    for (let i=0; i < texto.length; i++) {
        let textCode = texto.charCodeAt(i);

        if (textCode >= 65 && textCode <= 90) {
            let preResposta = chave.charCodeAt(iChave % chave.length) - 65;
            let resposta = ((textCode - 65 - preResposta + 26) % 26) + 65;

            resultado += String.fromCharCode(resposta);
            iChave++;
        } else {
            resultado += texto[i];
        }
    }
    return resultado;
}
