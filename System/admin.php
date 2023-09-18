<?php
// Incluir arquivos necessários e estabelecer conexão com o banco de dados
require_once("config.php");

// Função para listar usuários
function listUsers() {
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Erro ao buscar usuários: " . mysqli_error($conn);
        return;
    }

    echo "<h2>Lista de Usuários</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Função para listar transações
function listTransactions() {
    global $conn;
    $query = "SELECT * FROM transactions";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Erro ao buscar transações: " . mysqli_error($conn);
        return;
    }

    echo "<h2>Lista de Transações</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Usuário</th><th>Valor</th><th>Descrição</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['transaction_id'] . "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['amount'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
// Verificar se o botão "Sair" foi clicado
if (isset($_POST["close"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" href="style/index.css">
    <title>Painel de Administração</title>
</head>
<body>
    <h1>Painel de Administração</h1>
    
    <div>
        <h2>Gerenciar Usuários</h2>
        <?php listUsers(); ?>
    </div>

    <div>
        <h2>Revisar Transações</h2>
        <?php listTransactions(); ?>
    </div>

    <div>
        <h2>Gerar Relatórios</h2>
        <!-- Adicione a lógica para gerar relatórios aqui -->
    </div>
    
    <input type="submit" name="close" value="Sair" class="btn" />

</body>
</html>
