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
            header("Location: register.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="PROJETO/Style/style.css">
</head>
<body>
    <div class="box-login">
    <h1 class="title_login"><i class="icon icon-key-1"></i> Login</h1>

    <form action="#" method="post" class="form login">

        <div class="form_field">
        
            <label for="login__username">
                <i class="icon icon-user-1"></i>
                <span class="hidden">E-mail</span>
            </label>
            
            <input autocomplete="off" id="login_username" type="text" name="email" class="form_input" placeholder="E-mail" required>

        </div>

        <div class="form_field">
        
            <label for="login_password">

                <i class="icon icon-lock"></i>
                <span class="hidden">Senha</span>
            
            </label>
        
            <input id="login_password" type="password" name="password" class="form_input" placeholder="Password" required>
    
        </div>

        <div class="form_field">
            <input type="submit" value="Entrar">
        </div>

    </form>

    <p class="resgatar-senha">Resgatar Senha, 

        <a href="#">Agora </a> 

    </p>

    </div><!--Box Login-->
        <form method="post" action="login.php">
            Email: <input type="email" name="email"><br>
            Senha: <input type="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
</body>
</html>
