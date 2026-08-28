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
<title>Recuperar senha — 100 Criptografia</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="icon" href="assets/images/favicon.png">
</head>
<body>
  <div class="pagina central">
    <div style="position: relative;"> 
      <a class="voltar" href="<?php echo isset($_SESSION["user_id"]) ? "config.php" : "index.php" ?>" aria-label="Voltar">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
      </a>

      <div class="principal">
        <div class="cabecalho">
          <image style="width: 100%; height: auto;" src="assets/images/titulo-recuperar-senha.png" alt="Logo do site">
        </div>

        <p class="descricao">Informe seu e-mail para solicitar uma nova senha.</p>

        <form id="formulario-enviar-email" action="actions/send-email.php" method="POST" novalidate>

          <div class="campo">
            <div class="campo-entrada">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg>
              <input type="email" id="envio-email" placeholder="E-mail" autocomplete="email">
            </div>
            <p class="campo-mensagem" id="envio-email-msg"></p>
          </div>

          <p class="aviso-formulario" id="envio-email-aviso"></p>

          <button type="submit" class="botao botao-claro botao-bloco">Enviar</button>
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