<?php
require_once __DIR__ . "/actions/logged-in.php";

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
      <form action="actions/recover-password.php" method="POST">
            <label for="password">Senha:</label>
            <br>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirmar Senha:</label>
            <br>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <button type="submit">Alterar Senha</button>
      </form>
      <br>
      <br>
      <a href="login.php">Lembrou a senha? <strong>Entrar</strong></a>
</body>
</html> 