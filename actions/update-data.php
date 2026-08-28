<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $conn = getDB();

    $username = isset($_POST["username"]) && !empty($_POST["username"]) ? htmlspecialchars($_POST["username"]) : htmlspecialchars($_SESSION["user_data"]["nome"]);
    addmessage("username", $username, false);
    if (!empty($username) && strlen($username) > 100) {
        addMessage("username-config-error", "O nome de usuário deve ter no máximo 100 caracteres.");
    }

    $email = isset($_POST["email"]) && !empty($_POST["email"]) ? htmlspecialchars($_POST["email"]) : htmlspecialchars($_SESSION["user_data"]["email"]);
    addmessage("email", $email, false);
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            addMessage("email-config-error", "E-mail inválido.");
        }
        if (strlen($email) > 100) {
            addMessage("email-config-error", "O e-mail deve ter no máximo 100 caracteres.");
        }   
    }

    $password = isset($_POST["password"]) && !empty($_POST["password"]) ? htmlspecialchars($_POST["password"]) : htmlspecialchars($_SESSION["user_data"]["senha"]);
    addmessage("password", $password, false);
    if (!empty($password)) {
        if (strlen($password) < 8) {
            addMessage("password-config-error", "A senha deve ter pelo menos 8 caracteres.");
        }
        if (!preg_match("/[A-Z]/", $password)) {
            addMessage("password-config-error", "A senha deve conter pelo menos uma letra maiúscula.");
        }
        if (!preg_match("/[a-z]/", $password)) {
            addMessage("password-config-error", "A senha deve conter pelo menos uma letra minúscula.");
        }
        if (!preg_match("/[0-9]/", $password)) {
            addMessage("password-config-error", "A senha deve conter pelo menos um número.");
        }
        if (!preg_match("/[\W_]/", $password)) {
            addMessage("password-config-error", "A senha deve conter pelo menos um caractere especial.");
        }
        if (strlen($password) > 100) {
            addMessage("password-config-error", "A senha deve ter no máximo 100 caracteres.");
        }
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE conta_usuario SET nome = ?, email = ?, senha = ? WHERE id = 1 AND ativo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if (hasMessages("username-config-error", "email-config-error", "password-config-error")) {
        addMessage("confirm-access", "1", false);
        header("Location: ../config.php");
        exit();
    }

    try {
        $stmt->execute();
        addMessage("config-success", "Dados alterados com sucesso.");
        clearMessages("username", "email", "password");
        addMessage("confirm-access", "1", false);
        $_SESSION["user_data"]["nome"] = $username;
        $_SESSION["user_data"]["email"] = $email;
        $_SESSION["user_data"]["senha"] = $password;

        header("Location: ../config.php");
        exit();
    } catch (mysqli_sql_exception $error) {
        addMessage("confirm-access", "1", false);
        if ($error->getCode() === 1062) {
            addMessage("email-config-error", "E-mail já registrado.");
            header("Location: ../config.php");
            exit();
        } else {
            addMessage("database-anomaly", "Ocorreu um erro ao alterar o usuário: " . $error->getMessage());
            header("Location: ../config.php");
            exit();
        }
    }

} else {
    header("Location: ../config.php");
    exit();
}
?>