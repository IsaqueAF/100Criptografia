<?php
require_once __DIR__ . "/actions/logged-in.php";
require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/includes/message-manager.php";

echo getMessage("database_anomaly");

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
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>100 Criptografia</title>
<link rel="stylesheet" href="assets/css/projeto.css">
<link rel="stylesheet" href="assets/css/barra-lateral.css">
<link rel="icon" href="assets/images/favicon.png">
</head>
<body>
<?php if (isset($_SESSION["user_id"])) {include_once "includes/barra-lateral.php";} ?>
<div class="pagina pagina-projeto">

  <?php if (isset($_SESSION["user_id"])): ?>
      <header class="topo-projeto">
        <button class="avatar" onclick="toggleSidebar()" aria-label="Abrir menu"><?php echo htmlspecialchars($_SESSION["user_data"]["nome"][0]); ?></button>
        <button class="historico" onclick="toggleHistory()">Historico</button>
        <image style="width: 5%; height: auto;" src="assets/images/icone.png" alt="Logo do site">
      </header>
  <?php else: ?>
      <header class="topo-projeto">
        <a class="back" href="index.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <image style="width: 5%; height: auto;" src="assets/images/icone.png" alt="Logo do site">
      </header>
  <?php endif; ?>

<div class="container-conversor">

  <div class="menu-cifras">
    <h3 class="titulo-secao">Escolha as Conversões</h3>
    <div class="grid-opcoes-cifras">
      <button class="opcao-cifra" data-nome="Número" data-cor="#ffff00">
        <span class="cor-indicador" style="background-color: #ffff00;"></span> Número
      </button>
      <button class="opcao-cifra" data-nome="Texto" data-cor="#00ff00">
        <span class="cor-indicador" style="background-color: #00ff00;"></span> Texto
      </button>
      <button class="opcao-cifra" data-nome="Binário" data-cor="#ff0000">
        <span class="cor-indicador" style="background-color: #ff0000;"></span> Binário
      </button>
      <button class="opcao-cifra" data-nome="Octal" data-cor="#0000ff">
        <span class="cor-indicador" style="background-color: #0000ff;"></span> Octal
      </button>
      <button class="opcao-cifra" data-nome="Hexadecimal" data-cor="#00ffff">
        <span class="cor-indicador" style="background-color: #00ffff;"></span> Hexadecimal
      </button>
      <button class="opcao-cifra" data-nome="César" data-cor="#ff8c00">
        <span class="cor-indicador" style="background-color: #ff8c00;"></span> César
      </button>
      <button class="opcao-cifra" data-nome="Bacon" data-cor="#00cc44">
        <span class="cor-indicador" style="background-color: #00cc44;"></span> Bacon
      </button>
      <button class="opcao-cifra" data-nome="Atbash" data-cor="#e600e6">
        <span class="cor-indicador" style="background-color: #e600e6;"></span> Atbash
      </button>
      <button class="opcao-cifra" data-nome="Vigenère" data-cor="#00008b">
        <span class="cor-indicador" style="background-color: #00008b;"></span> Vigenère
      </button>
      <button class="opcao-cifra" data-nome="Playfair" data-cor="#0088ff">
        <span class="cor-indicador" style="background-color: #0088ff;"></span> Playfair
      </button>
    </div>
  </div>

  <!-- 2. Caminho onde as conversões serão inseridas -->
  <div class="area-caminho">
    <h3 class="titulo-secao">Caminho da Conversão</h3>
    <div class="trilha" id="trilhaTracejada">
      <!-- Linha serpenteante tracejada de fundo -->
      <svg class="linha-fundo-svg" width="100%" height="100%">
        <path d="M 20 25 H 95% V 75 H 5% V 125 H 95% V 175 H 5%" fill="none" stroke="#5c665f" stroke-width="2" stroke-dasharray="6,6" stroke-linejoin="round"/>
      </svg>
      
      <!-- Container onde os quadrados das cifras ativas serão renderizados -->
      <div class="container-quadrados-ativos" id="containerQuadradosAtivos">
        <!-- Os quadrados entram aqui dinamicamente -->
      </div>
    </div>
  </div>

</div>
    <main class="central">
      <div class="area-conversao">
        <h1 class="pergunta">O que deseja decifrar?</h1>

        <div class="bloco-texto">
          <textarea class="area-texto" id="texto-entrada" placeholder="Entrada..."></textarea>
        </div>

        <div class="conector">
          <span class="conector-linha"></span>
          <span class="conector-icone">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
          </span>
          <span class="conector-linha"></span>
        </div>

        <div class="bloco-texto">
          <textarea class="area-texto" id="texto-saida" placeholder="Saída..." readonly></textarea>
        </div>

        <div class="rodape-projeto">
          <?php if(isset($_SESSION['user_id'])): ?>
          <div class="grupo-preset">
            <div class="campo-entrada">
              <input type="text" id="nome-preset" placeholder="Nome do preset">
            </div>
            <button type="button" class="botao botao-contorno" id="botao-salvar-preset">Salvar</button>
          </div>
          <?php else: ?>
          <p class="mensagem-aviso">Faça login para salvar presets.</p>
          <?php endif; ?>
          <button type="button" class="botao botao-claro" id="botao-converter">Converter</button>
        </div>
      </div>
    </main>
  </div>

<script src="assets/js/project.js"></script>
</body>
</html>
