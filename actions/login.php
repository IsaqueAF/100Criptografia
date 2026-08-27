<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $conn = getDB();

    $email = htmlspecialchars($_POST["email"]);
    addmessage("email", $email, false);
    if (empty($email)) {
        addMessage("email-login-error", "O e-mail é obrigatório.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addMessage("email-login-error", "E-mail inválido.");
    }

    $password = htmlspecialchars($_POST["password"]);
    addmessage("password", $password, false);
    if (empty($password)) {
        addMessage("password-login-error", "A senha é obrigatória.");
    }

    $sql = "SELECT id, senha FROM conta_usuario WHERE email = ? AND ativo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if (hasMessages("email-login-error", "password-login-error")) {
        header("Location: ../login.php");
        exit();
    }

    try {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row["senha"])) {

                session_regenerate_id(true);
                $_SESSION["user_id"] = $row["id"];

                if (isset($_POST["remember_me"]) && $_POST["remember_me"] === "on") {
                    $token = bin2hex(random_bytes(32));
                    $expiry_time = date("Y-m-d H:i:s", strtotime("+30 days"));

                    $sql_token = "INSERT INTO token_lembrete (id_conta_usuario, token, data_expiracao) VALUES (?, ?, ?)";
                    $stmt_token = $conn->prepare($sql_token);
                    $stmt_token->bind_param("iss", $row["id"], $token, $expiry_time);

                    try {
                        $stmt_token->execute();
                    } catch (mysqli_sql_exception $error) {
                        addMessage("database-anomaly", "Ocorreu um erro ao criar o token de lembrete: " . $error->getMessage());
                        header("Location: ../login.php");
                        exit();
                    }
                    
                    setcookie("remember_me", $token, time() + (30 * 24 * 60 * 60), "/", "", true, true);
                }

                addMessage("login-success", "Direcionando para entrada.");
                clearMessages("email", "password");
                header("Location: ../login.php");
                exit();
            } else {
                addMessage("login-error", "Usuário e/ou senha inválidos.");
                header("Location: ../login.php");
                exit();
            }
        } else {
            addMessage("login-error", "Usuário e/ou senha inválidos.");
            header("Location: ../login.php");
            exit();
        }
    } catch (mysqli_sql_exception $error) {
        addMessage("database-anomaly", "Ocorreu um erro ao tentar fazer login: " . $error->getMessage());
        header("Location: ../login.php");
        exit();
    }
}
?>