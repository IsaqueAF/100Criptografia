function codificarBinario(texto) {
    let resultado = "";

    // Codificar
    for (let i = 0; i < texto.length; i++) {
        let userSend = texto[i];
        let codigo = userSend.charCodeAt(0);

        const binario = codigo.toString(2).padStart(8, '0');
        
        resultado += binario;

    }

    return resultado;
}


function decodificarBinario(texto) {
    let resultado = "";

    for (let i = 0; i < texto.length; i += 8) {
        let binaryBlock = texto.substring(i, i + 8);
        const converter = parseInt(binaryBlock, 2);
        const ogText = String.fromCharCode(converter);

        resultado += ogText;
    }

    return resultado;

}
