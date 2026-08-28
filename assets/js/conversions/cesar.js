function codificacaoCesar(texto, chave) {
    let resultado = "";

    for (let i = 0; i < texto.length; i++) {
        let caractere = texto[i];
        let codigo = caractere.charCodeAt(0);

        // Letras maiúsculas: A-Z
        if (codigo >= 65 && codigo <= 90) {
           
            codigo = ((codigo - 65 + chave) % 26) + 65;

            // Letras minúsculas: a-z
        } else if (codigo >= 97 && codigo <= 122) {
           
            codigo = ((codigo - 97 + chave) % 26) + 97;
        }

        resultado += String.fromCharCode(codigo);
    }

    return resultado;

}


function decodificacaoCesar(texto, chave) {
    let resultado = "";

    for (let i = 0; i < texto.length; i++) {
        let caractere = texto[i];
        let codigo = caractere.charCodeAt(0);

        // Letras maiúsculas: A-Z
        if (codigo >= 65 && codigo <= 90) {
            
            codigo = ((codigo - 65 - chave + 26) % 26) + 65;

        // Letras minúsculas: a-z
        } else if (codigo >= 97 && codigo <= 122) {
    
            codigo = ((codigo - 97 - chave + 26) % 26) + 97;
        }

        resultado += String.fromCharCode(codigo);
    }

    return resultado;

}