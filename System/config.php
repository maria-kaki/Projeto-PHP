Arquivo de configuração do banco de dados e API de pagamento.

<?php
// Configurações do banco de dados
$db_host = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "PaymentSystem";

// Configurações da API de pagamento
$api_key = "APIkey";
$api_secret = "APIsecret";

// Conexão com o banco de dados
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicialização da sessão
session_start();
?>
