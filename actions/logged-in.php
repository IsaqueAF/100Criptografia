<?php
require_once __DIR__ . "/../config/session.php";

if (!isset($_SESSION["user_id"]) && isset($_COOKIE["remember_me"])) {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $conn = getDB();

    $token_cookie = $_COOKIE["remember_me"];

    $sql = "SELECT id_conta_usuario FROM token_lembrete WHERE token = ? AND data_expiracao > NOW() AND ativo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token_cookie);

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($row["id_conta_usuario"]) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $row["id_conta_usuario"];
            } else {
                setcookie("remember_me", "", time() - 3600, "/", "", true, true);
            }

        }
        
    } catch (mysqli_sql_exception $error) {
        addMessage("database-anomaly", "Ocorreu um erro ao verificar o token de lembrete:" . $error->getMessage());
    }
}
?>