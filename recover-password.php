<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/includes/message-manager.php";

echo getMessage("database_anomaly");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alterar senha — 100 Criptografia</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="icon" href="assets/images/favicon.png">
</head>
<body>
  <div class="pagina central">
    <div style="position: relative;">
      <div class="principal">
        <div class="cabecalho">
          <image style="width: 100%; height: auto;" src="assets/images/titulo-recuperar-senha.png" alt="Logo do site">
        </div>

        <form id="formulario-recuperar-senha" action="actions/recover-password.php" method="POST" novalidate>

          <div class="campo">
            <div class="campo-entrada">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="recuperar-senha" placeholder="Nova senha" autocomplete="new-password">
            </div>
            <p class="campo-mensagem" id="recuperar-senha-msg"></p>
          </div>

          <div class="campo">
            <div class="campo-entrada">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              <input type="password" id="recuperar-confirmar-senha" placeholder="Confirmar nova senha" autocomplete="new-password">
            </div>
            <p class="campo-mensagem" id="recuperar-confirmar-senha-msg"></p>
          </div>

          <p class="aviso-formulario" id="recuperar-aviso"></p>

          <button type="submit" class="botao botao-claro botao-bloco">Alterar senha</button>
        </form>

        <?php 
          if (!isset($_SESSION["user_id"])) {
            ?>
            <p class="rodape">Lembrou da senha? <a href="login.php"><strong>Entrar</strong></a></p>
            <?php
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>