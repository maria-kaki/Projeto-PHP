<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar os dados de login
    if (empty($email) || empty($password)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Verificar as credenciais do usuário no banco de dados
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                // Credenciais corretas, iniciar sessão
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["username"] = $row["username"];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "E-mail não encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="login.php">
        Email: <input type="email" name="email"><br>
        Senha: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
