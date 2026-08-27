<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/message-manager.php";

if (isset($_SESSION["user_id"])) {

      $conn = getDB();

      if (!isset($_SESSION["user_data"])) {

            $sql = "SELECT nome, email, senha FROM conta_usuario WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["user_id"]);

            try {
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $_SESSION["user_data"] = $result->fetch_assoc();
            } catch (mysqli_sql_exception $error) {
                  addMessage("user-data-error", "Erro ao buscar dados do usuário: " . $error->getMessage());
                  header("Location: logout.php");
                  exit();
            } finally {
                  $stmt->close();
            }

      }
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
      <?php if (isset($_SESSION["user_id"])): ?>
            <button onclick="toggleSidebar()"> <?php echo htmlspecialchars($_SESSION["user_data"]["nome"][0]); ?></button>
            <div style="background-color: gray; display: none;" class="sidebar">
                  <span><?php echo htmlspecialchars($_SESSION["user_data"]["nome"]); ?></span>
                  <button onclick="toggleSidebar()">Fechar</button>
                  <br>
                  <hr>
                  <form action="actions/search-preset.php" method="POST">
                        <label for="search">Pesquisar Preset:</label>
                        <input type="text" name="search" id="search" required>
                        <button type="submit">Pesquisar</button>
                  </form>
                  <ul>
                        <div style="background-color: red;" class="preset"></div>
                  </ul>
                  <br>
                  <hr>
                  <form action="actions/logout.php" method="POST">
                        <button type="submit">Sair</button>
                  </form>
                  <a href="config.php">Configurações</a>
            </div>
            <form action="actions/history.php" method="POST">
                  <button type="submit" onclick="toggleHistory()">Historico</button>
            </form>
            <div style="background-color: gray; display: none;" class="history">
                  <ul>
                        <div style="background-color: red;" class="preset"></div>
                  </ul>
            </div>
      <?php else: ?>
            <a href="index.php">Voltar</a>
      <?php endif; ?>
      
      <script>
            function toggleSidebar() {
                  const sidebar = document.querySelector('.sidebar');
                  sidebar.style.display = sidebar.style.display == 'block' ? 'none' : 'block';
            }

            function toggleHistory() {
                  const history = document.querySelector('.history');
                  history.style.display = history.style.display == 'block' ? 'none' : 'block';
            }
      </script>
</body>
</html>