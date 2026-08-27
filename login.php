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
      <form action="actions/login.php" method="POST" novalidate>
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" value="<?php echo getMessage("email"); ?>" required>
            <br>
            <span style="color: red;"><?php echo getMessage("email-login-error"); ?></span>
            <label for="password">Senha:</label>
            <br>
            <input type="password" id="password" name="password" value="<?php echo getMessage("password"); ?>" required>
            <br>
            <span style="color: red;"><?php echo getMessage("password-login-error"); ?></span>
            <br>
            <a href="send-email.php">Esqueci minha senha</a>
            <br>
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me">Lembrar-me</label>
            <br>
            <br>
            <span style="color: red;"><?php echo getMessage("login-error"); ?></span>
            <span style="color: green;"><?php
                  $sucessMessage = getMessage("login-success");
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
            <button type="submit">Entrar</button>
      </form>
      <br>
      <br>
      <a href="register.php">Ainda não tem uma conta? <strong>Registrar</strong></a>
</body>
</html>