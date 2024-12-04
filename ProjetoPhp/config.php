<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog";

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
