<?php
require_once __DIR__ . "/../includes/message-manager.php";
require_once __DIR__ . "/../config/database.php";

if (!empty(getMessage("config-free"))) {
    $conn = getDB();

    $sql = "UPDATE conta_usuario SET ativo = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);

    try {
        $stmt->execute();
        header("Location: ../actions/logout.php");
        exit();
    } catch (mysqli_sql_exception $error) {
        addMessage("database-anomaly", "Ocorreu um erro ao tentar deletar a conta do usuário: " . $error->getMessage());
        header("Location: ../config.php");
        exit();
    }
}
?>