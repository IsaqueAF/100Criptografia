
/* página: Presets / barra lateral*/



function inicializarProjeto() {
  const botaoConverter = document.getElementById("botao-converter");
  if (!botaoConverter) return;

  const entrada = document.getElementById("texto-entrada");
  const saida = document.getElementById("texto-saida");
  const botaoSalvarPreset = document.getElementById("botao-salvar-preset");
  const nomePreset = document.getElementById("nome-preset");

  botaoConverter.addEventListener("click", function () {
    try {
      saida.value = btoa(unescape(encodeURIComponent(entrada.value)));
    } catch (erro) {
      saida.value = "Não foi possível converter o texto informado.";
    }
  });

  botaoSalvarPreset.addEventListener("click", function () {
    if (nomePreset.value.trim().length === 0) {
      nomePreset.focus();
    }
  });
}


document.addEventListener("DOMContentLoaded", function () {

  inicializarProjeto();
});