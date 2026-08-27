<?php
require_once __DIR__ . "/actions/logged-in.php";

if (isset($_SESSION["user_id"])) {
    header("Location: project.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>100Criptografia</title>
      <link rel="icon" href="assets/images/favicon.png">
</head>
<body>
      <a href="login.php">Entrar</a>
      <br>
      <a href="register.php">Cadastrar</a>
      <br>
      <a href="project.php">Testar sem uma conta</a>
</body>
</html> 