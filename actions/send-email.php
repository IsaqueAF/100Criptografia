<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . "/../includes/message-manager.php";
    require_once __DIR__ . "/../config/database.php";

    $to = $_POST["email"];
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        addMessage("send-email-error", "E-mail inválido.");
    }

    $subject = "Teste de envio de e-mail";
    $message = "Olá mundo!";
    $headers = "From:\r\n";

    if (hasMessages()) {
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