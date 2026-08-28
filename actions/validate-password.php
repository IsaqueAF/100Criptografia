<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $conn = getDB();

    $password = htmlspecialchars($_POST["password"]);
    addmessage("validate-password", $password, false);
    if (empty($password)) {
        addMessage("password-config-error", "A senha é obrigatória.");
    }

    $sql = "SELECT senha FROM conta_usuario WHERE id = ? AND ativo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);

    if (hasMessages("password-config-error")) {
        header("Location: ../config.php");
        exit();
    }

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row["senha"])) {
                addMessage("confirm-access", "1", false);
                clearMessages("validate-password");
                header("Location: ../config.php");
                exit();
            } else {
                addMessage("validate-password-error", "Senha inválida.");
                header("Location: ../config.php");
                exit();
            }
        } else {
            addMessage("validate-password-error", "Usuário não encontrado.");
            header("Location: ../config.php");
            exit();
        }
    } catch (mysqli_sql_exception $error) {
        addMessage("database-anomaly", "Ocorreu um erro ao verificar a senha: " . $error->getMessage());
        header("Location: ../config.php");
        exit();
    }
} else {
    header("Location: ../config.php");
    exit();
}
?>