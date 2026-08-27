<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/includes/message-manager.php";

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
      <a href="index.php">Voltar</a>
      <br>
      <br>
      <form action="actions/send-email.php" method="POST">
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" required>
            <br>
            <span style="color: red;"><?php echo getMessage("send-email-error"); ?></span>
            <span style="color: green;"><?php echo getMessage("send-email-success"); ?></span>
            <button type="submit">Enviar</button>
      </form>
      <br>
      <br>
      <a href="login.php">Lembrou a senha? <strong>Entrar</strong></a>
</body>
</html>