<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Armazenar a senha de forma segura com criptografia

    // Validação dos dados de entrada
    if (empty($name) || empty($email) || empty($_POST["password"])) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Verifica se o email já está registrado
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Este email já está registrado.";
        } else {
            // Insere o novo usuário no banco de dados
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                session_start(); // Inicia a sessão
                $_SESSION["user_id"] = $stmt->insert_id; // Obtém o ID do novo usuário
                $_SESSION["username"] = $name; // Define o nome de usuário na sessão

                // Redireciona para a página de dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Erro ao registrar usuário.";
            }
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
    <title>Registro de Usuário</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="page">
        <form method="POST" class="formLogin">
            <h1>Registrar</h1>
            <p>Digite os seus dados de acesso para cadastro nos campos abaixo.</p>
            <label for="name" class="form_label">Nome</label>
            <input type="text" name="name" class="form_input" id="name" placeholder="Nome" required>
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Digite seu e-mail" autofocus="true" />
            <label for="password">Senha</label>
            <input type="password" name="password" placeholder="Digite sua senha" />
            <input type="submit" value="Registrar" class="btn" />
            <div class="login-button">
                <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
            </div>
        </form>
    </div>
</body>
</html>
