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
                session_start(); // Inicia a sessão se ainda não estiver iniciada
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["username"] = $row["username"];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "E-mail não encontrado.";
            header("Location: register.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    <div class="page">
        <form method="POST" class="formIndex">
            <h1>Login</h1>
            <p>Digite os seus dados de acesso nos campos abaixo.</p>
            <input type="email" name="email" placeholder="Digite seu e-mail" autofocus="true" />
            <input type="password" name="password" placeholder="Digite sua senha" />
            <a href="forgot_password.php">Esqueci minha senha</a>
            <input type="submit" value="Acessar" class="btn" />
            <div class="register-button">
                <p>Não tem uma conta? <a href="register.php">Crie uma aqui</a></p>
            </div>
        </form>
    </div>
</body>
</html>