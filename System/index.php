<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        // Botão de login foi clicado, redirecione para login.php
        header("Location: login.php");
        exit;
    } elseif (isset($_POST["registro"])) {
        // Botão de registro foi clicado, redirecione para register.php
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Home</title>
</head>
<body>
    <div class="page">
        <form method="POST" class="formIndex">
            <h1>Bem-vindo ao Sistema de Pagamento</h1>
            <p>Escolha como deseja prosseguir.</p>
            <input type="submit" name="login" value="Login" class="btn" />
            <input type="submit" name="registro" value="Registro" class="btn" />
        </form>
    </div>
</body>
</html>
