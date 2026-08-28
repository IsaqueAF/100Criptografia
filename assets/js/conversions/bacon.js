function codificarBacon(texto) {
    const alfabeto = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O",
        "P","Q","R","S","T","U","V","W","X","Y","Z"
    ];
    
    const codigos = [
        "aaaaa", "aaaab", "aaaba", "aaabb", "aabaa", "aabab", "aabba", "aabbb", 
        "abaaa", "abaab", "ababa", "ababb", "abbaa", "abbab", "abbba", "abbbb", 
        "baaaa", "baaab", "baaba", "baabb", "babaa", "babab", "babba", "babbb", 
    ];

    let resultado = "";
    let textoMaiusculo = texto.toUpperCase();

    for (let letra of textoMaiusculo) { 
        let indice = alfabeto.indexOf(letra);

        if (indice !== -1) {
            resultado += codigos[indice] + " ";
        }
    } 
    
    return resultado.trim();
}


function decodificarBacon(textoCifrado) {
    const alfabeto = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O",
        "P","Q","R","S","T","U","V","W","X","Y","Z"
    ];
    
    const codigos = [
        "aaaaa", "aaaab", "aaaba", "aaabb", "aabaa", "aabab", "aabba", "aabbb", 
        "abaaa", "abaab", "ababa", "ababb", "abbaa", "abbab", "abbba", "abbbb", 
        "baaaa", "baaab", "baaba", "baabb", "babaa", "babab", "babba", "babbb"
    ];

    let resultado = "";

  
    let blocoDecodificando = textoCifrado.toLowerCase().split(' ');

    for (let bloco of blocoDecodificando) {
        let indice = codigos.indexOf(bloco);

        if (indice !== -1) {
            resultado += alfabeto[indice];
        }
    }

    return resultado;
}


