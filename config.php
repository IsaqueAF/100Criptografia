<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/includes/message-manager.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
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
    <a href="project.php">Voltar</a>
    <form action="actions/alter-data.php" method="POST" novalidate>
            <label for="username">Nome de usuário:</label>
            <br>
            <input type="text" id="username" name="username" placeholder="<?php echo htmlspecialchars($_SESSION["user_data"]["nome"]); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("username-config-error"); ?></span>
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" placeholder="<?php echo htmlspecialchars($_SESSION["user_data"]["email"]); ?>">
            <br>
            <span style="color: red;"><?php echo getMessage("email-config-error"); ?></span>
            <label for="password">Senha:</label>
            <br>
            <input type="password" id="password" name="password">
            <br> 
            <span style="color: red;"><?php echo getMessage("password-config-error"); ?></span>
            <span style="color: green;"><?php echo getMessage("config-success"); ?></span>
            <br>
            <button type="submit">Alterar Dados</button>
      </form>
      <br>
      <form style="background-color: gray;" action="password-needed.php" method="POST" novalidate>
            <label for="password">Senha:</label>
            <br>
            <input type="password" id="password" name="password">
            <br> 
            <span style="color: red;"><?php echo getMessage("password-config-error"); ?></span>
            <button type="submit">Alterar Senha</button>
      </form>
      <br>
      <form action="actions/delete-account.php" method="POST" novalidate>
            <button type="submit">Deletar Conta</button>
      </form>
</body>
</html>