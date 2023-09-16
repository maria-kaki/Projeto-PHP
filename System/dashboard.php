<?php
require_once("config.php");

// Verificar se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Recuperar informações do usuário e saldo da carteira

// Exibir informações e permitir processamento de transações

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Painel de Controle</h1>
    <p>Bem-vindo, [Nome do Usuário]!</p>
    <p>Saldo da Carteira: $[Saldo da Carteira]</p>
    <!-- Adicione aqui a lógica e formulários para processamento de transações -->
    <p><a href="logout.php">Sair</a></p>
</body>
</html>

