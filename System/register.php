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
<html>
<head>
    <title>Registro de Usuário</title>
</head>
<body>
    <h1>Registro de Usuário</h1>
    <form method="post" action="register.php">
        Nome: <input type="text" name="name"><br>
        Email: <input type="email" name="email"><br>
        Senha: <input type="password" name="password"><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
