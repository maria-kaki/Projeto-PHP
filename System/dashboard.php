<?php
require_once("config.php");

// Verificar se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Recuperar informações do usuário
$user_id = $_SESSION["user_id"];

// Consulta ao banco de dados para recuperar o nome do usuário, id do cliente e o saldo da carteira
$stmt = $conn->prepare("SELECT username, balance, clientid FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $clientid = $row["clientid"];
    $balance = $row["balance"];
} else {
    header("Location: login.php");
    exit;
}
// Verificar se o botão "Sair" foi clicado
if (isset($_POST["close"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
// Verificar se o botão "Fazer Pagamento" foi clicado
if (isset($_POST["payment"])) {
    header("Location: paypal.php");
    exit;
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
        <p>ID do cliente: <?php echo $clientid; ?></p>
        <p>Saldo da Carteira: R$<?php echo $balance; ?></p>
        <input type="submit" name="payment" value="Fazer Pagamento" class="btn" />
        <input type="submit" name="close" value="Sair" class="btn" />
        </form>
    </div>
</body>
</html>
