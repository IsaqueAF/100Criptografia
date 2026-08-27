<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $conn = getDB();

    $username = htmlspecialchars($_POST["username"]);
    addmessage("username", $username, false);
    if (empty($username)) {
        addMessage("username-register-error", "O nome de usuário é obrigatório.");
    } else if (strlen($username) > 100) {
        addMessage("username-register-error", "O nome de usuário deve ter no máximo 100 caracteres.");
    }

    $email = htmlspecialchars($_POST["email"]);
    addmessage("email", $email, false);
    if (empty($email)) {
        addMessage("email-register-error", "O e-mail é obrigatório.");
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            addMessage("email-register-error", "E-mail inválido.");
        }
        if (strlen($email) > 100) {
            addMessage("email-register-error", "O e-mail deve ter no máximo 100 caracteres.");
        }   
    }

    $password = htmlspecialchars($_POST["password"]);
    addmessage("password", $password, false);
    if (empty($password)) {
        addMessage("password-register-error", "A senha é obrigatória.");
    } else {
        if (strlen($password) < 8) {
            addMessage("password-register-error", "A senha deve ter pelo menos 8 caracteres.");
        }
        if (!preg_match("/[A-Z]/", $password)) {
            addMessage("password-register-error", "A senha deve conter pelo menos uma letra maiúscula.");
        }
        if (!preg_match("/[a-z]/", $password)) {
            addMessage("password-register-error", "A senha deve conter pelo menos uma letra minúscula.");
        }
        if (!preg_match("/[0-9]/", $password)) {
            addMessage("password-register-error", "A senha deve conter pelo menos um número.");
        }
        if (!preg_match("/[\W_]/", $password)) {
            addMessage("password-register-error", "A senha deve conter pelo menos um caractere especial.");
        }
        if (strlen($password) > 100) {
            addMessage("password-register-error", "A senha deve ter no máximo 100 caracteres.");
        }
    }

    $confirm_password = htmlspecialchars($_POST["confirm_password"]);
    addmessage("confirm_password", $confirm_password, false);
    if (empty($confirm_password)) {
        addMessage("confirm_password-register-error", "A confirmação da senha é obrigatória.");
    } else if ($password !== $confirm_password) {
        addMessage("confirm_password-register-error", "As senhas não coincidem.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO conta_usuario (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if (hasMessages("username-register-error", "email-register-error", "password-register-error", "confirm_password-register-error")) {
        header("Location: ../register.php");
        exit();
    }

    try {
        $stmt->execute();
        addMessage("register-success", "Usuário cadastrado com sucesso.");
        clearMessages("username", "email", "password", "confirm_password");
        $_SESSION["user_id"] = $stmt->insert_id;
        header("Location: ../register.php");
        exit();
    } catch (mysqli_sql_exception $error) {
        if ($error->getCode() === 1062) {
            addMessage("email-register-error", "E-mail já registrado.");
            header("Location: ../register.php");
            exit();
        } else {
            addMessage("database-anomaly", "Ocorreu um erro ao registrar o usuário: " . $error->getMessage());
            header("Location: ../register.php");
            exit();
        }
    }

} else {
    header("Location: ../register.php");
    exit();
}
?>