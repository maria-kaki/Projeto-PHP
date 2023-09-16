// registro e login

<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validação dos dados de entrada

    // Verifica se o email já está registrado

    // Insere o novo usuário no banco de dados

    // Redireciona para a página de login
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
