<?php
require_once __DIR__ . "/../includes/message-manager.php";

function getDB (): mysqli {
    $host = $_SERVER["MYSQL_HOST"] ?? getenv("MYSQL_HOST");
    $db   = $_SERVER["MYSQL_DATABASE"] ?? getenv("MYSQL_DATABASE");
    $user = $_SERVER["MYSQL_USER"] ?? getenv("MYSQL_USER");
    $pass = $_SERVER["MYSQL_PASSWORD"] ?? getenv("MYSQL_PASSWORD");

    try {
        $conn = new mysqli(
            hostname: $host,
            username: $user,
            password: $pass,
            database: $db
        );

        return $conn;
    } catch (mysqli_sql_exception $error) {
        addMessage("database_anomaly", "Falha na conexão com o banco de dados: " . $error->getMessage());
        die("Falha na conexão com o banco de dados.");
    }
}


// provavelmente terá uma função para centralizar a requisição do banco de dados. request();
?>