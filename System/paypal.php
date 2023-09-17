<?php
require_once("config.php");
require 'vendor/autoload.php';

// Verificar se o botão "Sair" foi clicado
if (isset($_POST["close"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Verificar se o botão "Enviar Pagamento" foi clicado
if (isset($_POST["enviar"])) {
    // Configurar o ambiente do PayPal
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'seu_client_id',
            'sua_secret'
        )
    );

    // Substitua as informações de pagamento abaixo com as informações relevantes
    $paymentAmount = '10.00'; // Valor do pagamento
    $currency = 'USD'; // Moeda da transação
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
                'return_url' => 'http://seusite.com/success',
                'cancel_url' => 'http://seusite.com/cancel'
            ]));

    try {
        // Criar o pagamento no PayPal
        $payment->create($apiContext);

        // Direcionar o usuário para a URL de aprovação do PayPal
        header('Location: ' . $payment->getApprovalLink());

        // Salvar as informações do pagamento no banco de dados
        $transactionId = /* ID da transação associada */
        $paypalPaymentId = $payment->getId();
        $paypalToken = $payment->getToken();
        $paypalPayerId = /* ID do pagador retornado pelo PayPal */

        $insertPaymentSQL = "INSERT INTO payments (transaction_id, payment_status, paypal_payment_id, paypal_token, paypal_payer_id) VALUES (?, 'Pending Payment', ?, ?, ?)";
        $stmt = $conn->prepare($insertPaymentSQL);
        $stmt->bind_param("issi", $transactionId, $paypalPaymentId, $paypalToken, $paypalPayerId);
        $stmt->execute();

    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        echo "Erro ao criar o pagamento: " . $ex->getMessage();
    }
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
            <label for="name" class="form_label">Nome</label>
            <input type="text" name="name" class="form_input" id="name" placeholder="Nome" required>
        <input type="submit" name="enviar" value="Enviar Pagamento" class="btn" />
        <input type="submit" name="close" value="Sair" class="btn" />
        </form>
    </div>
</body>
</html>
