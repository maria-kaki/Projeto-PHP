<?php
require_once("config.php");
// Função para gerar um código de verificação único
function generateVerificationCode() {
    return bin2hex(random_bytes(16)); // Gera uma sequência hexadecimal aleatória
}

// Função para enviar um e-mail de verificação
function sendVerificationEmail($email, $verificationCode) {
    $to = $email;
    $subject = "Confirmação de E-mail";
    $message = "Por favor, clique no link a seguir para verificar seu endereço de e-mail:\n\n";
    $message .= "http://seusite.com/confirmar_email.php?code=$verificationCode";
    $headers = "From: jorgeantoniomeireles@hotmail.com";

    return mail($to, $subject, $message, $headers);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Realiza a validação do e-mail (exemplo simples)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "O endereço de e-mail não é válido.";
    } else {
        // Verifique se o e-mail já está registrado (você precisa implementar essa verificação)

        // Gere um código de verificação único
        $verificationCode = generateVerificationCode();
        
        // Armazene o código de verificação no banco de dados
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO verification (verificationcode) VALUES (?)");
        $stmt->bind_param("i", $verificationCode);

        if ($stmt->execute()) {
            // Envie um e-mail de verificação
            if (sendVerificationEmail($email, $verificationCode)) {
                echo "Um e-mail de verificação foi enviado para o seu endereço de e-mail.";
                header("Location: verificationform.php");
            } else {
                echo "Falha ao enviar o e-mail de verificação.";
            }
        } else {
            echo "Erro ao armazenar o código de verificação no banco de dados.";
        }

        $stmt->close();
        $conn->close();
    }
}
