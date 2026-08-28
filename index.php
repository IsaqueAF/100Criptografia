<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/includes/message-manager.php";

echo getMessage("database_anomaly");

if (isset($_SESSION["user_id"])) {
    header("Location: project.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>100 Criptografia</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="icon" href="assets/images/favicon.png">
</head>
<body>
  <div class="pagina">
    <nav class="barra-navegacao">
      <a class="link-navegacao" href="login.php">Entrar</a>
      <a class="botao botao-contorno" href="register.php">Cadastrar</a>
    </nav>

    <main class="central">
      <div class="heroi-marca">
        <image style="width: 100%; height: auto;" src="assets/images/titulo.png" alt="Logo do site">
        <p class="frase-destaque">Descubra o sentido de qualquer enigma, cifra ou simplesmente converta tipos de valores.</p>
        <div class="acoes-heroi">
          <a class="botao botao-texto" href="project.php">Testar sem uma conta</a>
          <a class="botao botao-claro" href="register.php">Criar uma conta</a>
        </div>
      </div>
    </main>
  </div>

  <script src="script.js"></script>
</body>
</html>