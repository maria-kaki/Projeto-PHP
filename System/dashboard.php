<?php
require_once("config.php");

// Verificar se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Recuperar informações do usuário e saldo da carteira
$user_id = $_SESSION["user_id"];

// Implemente a lógica para recuperar as informações do usuário e o saldo da carteira do banco de dados

// Exemplo de consulta ao banco de dados para recuperar o nome do usuário e o saldo da carteira
$stmt = $conn->prepare("SELECT username, balance FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $balance = $row["balance"];
} else {
    // Lida com o caso em que o usuário não é encontrado
    // Você pode redirecionar para uma página de erro ou tomar outra ação apropriada
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Dashboard</title>
</head>
<body>
<div class="page">
        <form method="POST" class="formIndex">
        <h1>Painel de Controle</h1>
        <p>Bem-vindo(a), <?php echo $username; ?>!</p>
        <p>Saldo da Carteira: $<?php echo $balance; ?></p>
        <!-- Adicione aqui a lógica e formulários para processamento de transações -->
        <p><a href="login.php">Sair</a></p>
        </form>
    </div>
    
</body>
</html>
