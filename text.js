function codificacao(texto) {   
    let resultado = "";

    for (let i = 0; i < texto.length; i++) {
        
        let caractere = texto[i];
        let codigo = caractere.charCodeAt(0);
        if (codigo >= 97 && codigo <= 122) {
            resultado += codigo + " ";
        } else if (codigo >= 65 && codigo <= 90) {
            resultado += codigo + " ";
        } else if (codigo === 32) {
            resultado += codigo + " ";
        }
    }

    return resultado;

}


function decodificacao(digito) {   
    let resultado = "";

    let blocoAscii = digito.split(" ");

    for (let i = 0; i < blocoAscii.length; i ++) {
        let vireInteiro = parseInt(blocoAscii[i]);

        if (isNaN(vireInteiro)) continue;

        const converter = String.fromCharCode(vireInteiro);

        resultado += converter;
    }

    return resultado;

}
