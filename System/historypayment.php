<?php
require_once("config.php");

// Verificar se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Recuperar o ID do usuário autenticado
$user_id = $_SESSION["user_id"];

// Consultar o banco de dados para recuperar o histórico de pagamentos do usuário
$query = "SELECT p.*, t.description AS transaction_description
          FROM payments AS p
          INNER JOIN transactions AS t ON p.transaction_id = t.transaction_id
          WHERE t.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Histórico de Pagamentos</title>
</head>
<body>
<div class="page">
    <h1>Histórico de Pagamentos</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID do Pagamento</th>
                <th>Status do Pagamento</th>
                <th>ID do PayPal</th>
                <th>Data do Pagamento</th>
                <th>Descrição da Transação</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["payment_id"]; ?></td>
                    <td><?php echo $row["payment_status"]; ?></td>
                    <td><?php echo $row["paypal_payment_id"]; ?></td>
                    <td><?php echo $row["payment_date"]; ?></td>
                    <td><?php echo $row["transaction_description"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum pagamento encontrado no histórico.</p>
    <?php endif; ?>

    <a href="dashboard.php">Voltar para o Painel</a>
</div>
</body>
</html>
