<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/includes/message-manager.php";

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
      <a href="index.php">Voltar</a>
      <br>
      <br>
      <form action="actions/register.php" method="POST" novalidate>
            <label for="username">Nome de usuário:</label>
            <br>
            <input type="text" id="username" name="username" value="<?php echo getMessage("username"); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("username-register-error"); ?></span>
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" value="<?php echo getMessage("email"); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("email-register-error"); ?></span>
            <label for="password">Senha:</label>
            <br>
            <input type="password" id="password" name="password" value="<?php echo getMessage("password"); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("password-register-error"); ?></span>
            <label for="confirm_password">Confirmar Senha:</label>
            <br>
            <input type="password" id="confirm_password" name="confirm_password" value="<?php echo getMessage("confirm_password"); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("confirm_password-register-error"); ?></span>
            <span style="color: green;"><?php
                  $sucessMessage = getMessage("register-success");
                  if (!empty($sucessMessage)) {
                        echo $sucessMessage;
                        ?>
                        <script>
                              setTimeout(function() {
                                    window.location.href = "project.php";
                              }, 1000);
                        </script>
                        <?php
                  }
            ?></span>
            <button type="submit">Cadastrar</button>
      </form>
      <br>
      <br>
      <a href="login.php">Já tem uma conta? <strong>Entrar</strong></a>
</body>
</html>