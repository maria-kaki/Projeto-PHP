<?php
// Configurações do banco de dados
$db_host = "127.0.0.1:3306";
$db_username = "root";
$db_password = "root";
$db_name = "paymentsystem";

// Conexão com o banco de dados
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicialização da sessão
session_start();
?>