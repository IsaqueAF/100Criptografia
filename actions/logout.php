<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../config/database.php";

    if (isset($_COOKIE["remember_me"])) {

        $conn = getDB();

        $token_cookie = $_COOKIE["remember_me"];

        $sql = "UPDATE token_lembrete SET ativo = 0 WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token_cookie);

        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $error) {
            require_once __DIR__ . "/../includes/message-manager.php";
            addMessage("database-anomaly", "Ocorreu um erro ao desativar o token de lembrete:" . $error->getMessage());
        }

        setcookie("remember_me", "", time() - 3600, "/", "", true, true);
    }

    session_destroy();
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../project.php");
    exit();
}
?>