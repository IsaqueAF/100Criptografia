function codificacaoHexadecimal(texto) {
    let resultado = "";

    for (let i = 0; i < texto.length; i++) {
        
        let caractere = texto[i];
        let codigo = caractere.charCodeAt(0);
        if (codigo >= 97 && codigo <= 122) {
            let hexa = codigo.toString(16);
            resultado += hexa + " ";
        } else if (codigo >= 65 && codigo <= 90) {
            let hexa = codigo.toString(16);
            resultado += hexa + " ";
        } else if (codigo === 32) {
            let hexa = codigo.toString(16);
            resultado += hexa + " ";
        }
    }

    return resultado;

}


function decodificacaoHexadecimal(digito) {
    let resultado = "";

    let blocoAscii = digito.split(" ");

    for (let i = 0; i < blocoAscii.length; i ++) {
        let vireInteiro = parseInt(blocoAscii[i], 16);

        if (isNaN(vireInteiro)) continue;

        const converter = String.fromCharCode(vireInteiro);

        resultado += converter;
    }

    return resultado;

}
