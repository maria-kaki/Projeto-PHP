<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a Senha</title>
</head>
<body>
    <h1>Esqueceu a Senha</h1>
    <p>Informe seu endereço de e-mail para redefinir sua senha.</p>
    <form action="send_reset_email.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>
        <button type="submit">Enviar E-mail de Redefinição de Senha</button>
    </form>
</body>
</html>