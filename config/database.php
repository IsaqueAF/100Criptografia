<?php
function getDB (): mysqli {
    $host = 'db';
    $db   = $_SERVER['MYSQL_DATABASE'] ?? getenv('MYSQL_DATABASE');
    $user = $_SERVER['MYSQL_USER'] ?? getenv('MYSQL_USER');
    $pass = $_SERVER['MYSQL_PASSWORD'] ?? getenv('MYSQL_PASSWORD');

    $conn = new mysqli(
        hostname: $host,
        username: $user,
        password: $pass,
        database: $db
    );

    if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
}

// provavelmente terá uma função para centralizar a requisição do banco de dados. request();
?>