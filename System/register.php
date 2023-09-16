<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Armazenar a senha de forma segura com criptografia

    // Validação dos dados de entrada
    if (empty($name) || empty($email) || empty($_POST["password"])) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Verifica se o email já está registrado
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Este email já está registrado.";
        exit;
    }

    // Insere o novo usuário no banco de dados
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "Registro bem-sucedido. Você pode fazer login agora.";
        // Redireciona para a página de login
        header("Location: login.php");
    } else {
        echo "Erro ao registrar usuário.";
    }
    
    exit;
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
            <h1>Registro</h1>
            <p>Digite os seus dados de acesso para cadastro nos campos abaixo.</p>
            <label for="nome" class="form_label">Nome</label>
            <input type="text" name="nome" class="form_input" id="nome" placeholder="Nome" required>
            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" />
            <label for="password">Senha</label>
            <input type="password" placeholder="Digite sua senha" />
            <input type="submit" value="Registrar" class="btn" />
        </form>
    </div>
</body>
</html>