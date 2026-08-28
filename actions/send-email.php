<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $to = htmlspecialchars($_POST["email"]);
    addmessage("email", $email, false);
    if (empty($email)) {
        addMessage("email-login-error", "O e-mail é obrigatório.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addMessage("email-login-error", "E-mail inválido.");
    }

    $subject = "Teste de envio de e-mail";
    $message = "Olá mundo!";
    $headers = "From:\r\n";

    if (hasMessages("email-login-error")) {
        header("Location: ../register.php");
        exit();
    }

    if (mail($to, $subject, $message, $headers)) {
        addMessage("send-email-success", "E-mail enviado com sucesso.");
    } else {
        addMessage("send-email-error", "Erro ao enviar e-mail.");
    }
    header("Location: ../send-email.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>