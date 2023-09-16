<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["enviar"])) {
        // Botão de envio foi clicado, validateemail.php
        header("Location: validateemail.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Esqueceu a Senha</title>
</head>
<body>
    <div class="page">
        <form method="POST" class="formIndex">
            <h1>Esqueceu a Senha</h1>
            <p>Informe seu endereço de e-mail para redefinir sua senha.</p>
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>
            <input type="submit" name="enviar" value="Enviar" class="btn">
        </form>
    </div>
</body>
</html>