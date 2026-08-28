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
<title>Cadastro — 100 Criptografia</title>
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
          <image style="width: 100%; height: auto;" src="assets/images/titulo-cadastro.png" alt="Logo do site">
        </div>

        <form id="formulario-cadastro" action="actions/register.php" method="POST" novalidate>

          <div class="campo">
            <div class="campo-entrada">
              
              <input type="text" id="cad-nome" placeholder="Nome" autocomplete="name" name="username" value="<?php echo getMessage("username"); ?>">
            </div>
            <p class="campo-mensagem" id="cad-nome-msg" style="color: red;"><?php echo getMessage("username-register-error"); ?></p>
          </div>

          <div class="campo">
            <div class="campo-entrada">
              <input type="email" id="cad-email" placeholder="E-mail" autocomplete="email" name="email" value="<?php echo getMessage("email"); ?>">
            </div>
            <p class="campo-mensagem" id="cad-email-msg" style="color: red;"><?php echo getMessage("email-register-error"); ?></p>
          </div>

          <div class="campo">
            <div class="campo-entrada">
              
              <input type="password" id="cad-senha" placeholder="Senha" autocomplete="new-password" name="password" value="<?php echo getMessage("password"); ?>">
            </div>
            <p class="campo-mensagem" id="cad-senha-msg" style="color: red;"><?php echo getMessage("password-register-error"); ?></p>
          </div>

          <div class="campo">
            <div class="campo-entrada">
              
              <input type="password" id="cad-confirmar-senha" placeholder="Confirmar senha" autocomplete="new-password" name="confirm_password" value="<?php echo getMessage("confirm_password"); ?>">
            </div>
            <p class="campo-mensagem" id="cad-confirmar-senha-msg" style="color: red;"><?php echo getMessage("confirm_password-register-error"); ?></p>
          </div>

          <p class="aviso-formulario" id="cadastro-aviso">
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
          </p>


          <button type="submit" class="botao botao-claro botao-bloco">Cadastrar</button>
        </form>

        <p class="cartao-rodape">Já tem uma conta? <a href="login.php"><strong>Entrar</strong></a></p>
      </div>
    </div>
  </div>
</body>
</html>