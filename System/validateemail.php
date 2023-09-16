<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["validar"])) {
        // Botão de envio foi clicado, dashboard.php
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Validação de E-mail</title>
</head>
<body>
    <div class="page">
        <form method="POST" class="formIndex">
            <h1>Validação</h1>
            <p>Escreva o código enviado no seu e-mail</p>
            <input type="text" name="code" class="form_input" id="code" placeholder="Código" required>
            <input type="submit" name="validar" value="Validar" class="btn" />
        </form>
    </div>
</body>
</html>
