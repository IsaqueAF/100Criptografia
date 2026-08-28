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
<title>Entrar — 100 Criptografia</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="icon" href="assets/images/favicon.png">
</head>
<body>
  <div class="pagina central">
    <div style="position: relative;">
      <a class="voltar" href="index.php" aria-label="Voltar">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
      </a>

      <div class="principal">
        <div class="cabecalho">
          <image style="width: 100%; height: auto;" src="assets/images/titulo-entrar.png" alt="Logo do site">
        </div>

        <form id="formulario-login" action="actions/login.php" method="POST" novalidate>

          <div class="campo">
            <div class="campo-entrada">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg>
              <input type="email" id="login-email" name="email" placeholder="E-mail" autocomplete="email" value="<?php echo getMessage("email"); ?>">
            </div>
            <p class="campo-mensagem" id="login-email-msg" style="color: red;"><?php echo getMessage("email-login-error"); ?></p>
          </div>

          <div class="campo">
            <div class="campo-entrada">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="login-senha" name="password" placeholder="Senha" autocomplete="current-password" value="<?php echo getMessage("password"); ?>">
            </div>
            <p class="campo-mensagem" id="login-senha-msg" style="color: red;"><?php echo getMessage("password-login-error"); ?></p>
          </div>

          <div class="linha-formulario">
            <a class="link-discreto" href="send-email.php">Esqueci minha senha</a>
            <label class="caixa-selecao">
              <input type="checkbox" id="login-lembrar" name="remember_me">
              Lembrar-me
            </label>
          </div>

          <p class="aviso-formulario" id="login-aviso">
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
          </p>

          <button type="submit" class="botao botao-claro botao-bloco">Entrar</button>
        </form>

        <p class="cartao-rodape">Ainda não tem uma conta? <a href="register.php"><strong>Cadastrar</strong></a></p>
      </div>
    </div>
  </div>
</body>
</html>