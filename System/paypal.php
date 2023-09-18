<?php
require_once("config.php");
require 'vendor/autoload.php';

// Verificar se o botão "Enviar Pagamento" foi clicado
if (isset($_POST["enviar"])) {
    // Coletar e sanitizar os valores do formulário
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $clientid = mysqli_real_escape_string($conn, $_POST["clientid"]);
    $secretKey = mysqli_real_escape_string($conn, $_POST["secretkey"]);
    $recipientEmail = mysqli_real_escape_string($conn, $_POST["emaildestino"]);

    // Verificar se o email de destino existe no banco de dados
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $recipientEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtenha o user_id do resultado da consulta
        $row = $result->fetch_assoc();
        $userId = $row["user_id"];

        // Configurar o ambiente do PayPal
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $clientid,
                $secretKey
            )
        );

        // Todas essas informações devem ser pedidas ao usuario mas para testes eu especifiquei
        $paymentAmount = $amount; // Valor do pagamento
        $currency = 'BRL'; // Moeda da transação
        $description = 'Descrição da compra'; // Descrição da transação

        // Criar um objeto de pagamento
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
                ->setPayer(new \PayPal\Api\Payer(['payment_method' => 'paypal']))
                ->setTransactions([
                    (new \PayPal\Api\Transaction())
                        ->setAmount(new \PayPal\Api\Amount([
                            'total' => $paymentAmount,
                            'currency' => $currency
                        ]))
                        ->setDescription($description)
                ])
                ->setRedirectUrls(new \PayPal\Api\RedirectUrls([
                    'return_url' => 'http://localhost/System/historypayment.php',
                    'cancel_url' => 'http://localhost/System/dashboard.php'
                ]));

        try {
            // Criar o pagamento no PayPal
            $payment->create($apiContext);

            // Salvar as informações do pagamento no banco de dados
            $paypalPaymentId = $payment->getId();
            $paypalToken = $payment->getToken();

            // Inserir um registro na tabela de transações
            $insertTransactionSQL = "INSERT INTO transactions (user_id, amount, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertTransactionSQL);
            $stmt->bind_param("ids", $userId, $paymentAmount, $description);
            $stmt->execute();

            // Obter o último ID de transação inserido
            $transactionId = $stmt->insert_id;

            // Inserir um registro na tabela de pagamentos
            $insertPaymentSQL = "INSERT INTO payments (transaction_id, payment_status, paypal_payment_id, paypal_token, paypal_payer_id) VALUES (?, 'Pending Payment', ?, ?, ?)";
            $stmt = $conn->prepare($insertPaymentSQL);
            $stmt->bind_param("issi", $transactionId, $paypalPaymentId, $paypalToken, $paypalPayerId);
            $stmt->execute();

            // Direcionar o usuário para a URL de aprovação do PayPal (HTTP)
            header('Location: http://localhost/System/historypayment.php');
            exit;
            // Enviar um email de confirmação para o cliente
            $to = $recipientEmail;
            $subject = 'Confirmação de Pagamento';
            $message = 'Seu pagamento foi processado com sucesso.';
            $headers = 'From: maria.oliveira170922@gmail.com' . "\r\n" .
                    'Reply-To: maria.oliveira170922@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);


        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo "Erro ao criar o pagamento: " . $ex->getMessage();
        }
    } else {
        echo "E-mail de destino não encontrado no banco de dados.";
    }
}

// Verificar se o botão "Sair" foi clicado
if (isset($_POST["close"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/index.css">
    <title>Pagamento</title>
</head>
<body>
<div class="page">
    <form method="POST" class="formIndex">
        <h1>Realizar Pagamento</h1>
        <p>Digite os dados abaixo para enviar o pagamento.</p>
        <label for="amount" class="form_label">Valor que deseja transferir</label>
        <input type="text" name="amount" class="form_input" id="amount" placeholder="Valor" required>

        <label for="clientid" class="form_label">Client ID</label>
        <input type="text" name="clientid" class="form_input" id="clientid" placeholder="Client ID" required>

        <label for="secretkey" class="form_label">Secret Key</label>
        <input type="text" name="secretkey" class="form_input" id="secretkey" placeholder="Secret Key" required>

        <label for="emaildestino" class="form_label">E-mail de Destino</label>
        <input type="email" name="emaildestino" class="form_input" id="emaildestino" placeholder="E-mail de Destino" required>

        <input type="submit" name="enviar" value="Enviar Pagamento" class="btn" />
        <input type="submit" name="close" value="Sair" class="btn" />
    </form>
</div>
</body>
</html>