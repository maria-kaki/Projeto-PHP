<?php
require_once("config.php");
require 'vendor/autoload.php';
// Verificar se o botão "Enviar Pagamento" foi clicado
if (isset($_POST["enviar"])) {
    // Coletar os valores do formulário
    $amount = $_POST["amount"];
    $clientid = $_POST["clientid"];
    $privateKey = $_POST["private_key"];

    // Verificar se o clientid existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM users WHERE clientid = ?");
    $stmt->bind_param("s", $clientid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Configurar o ambiente do PayPal
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $clientid,
                $privateKey
            )
        );
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
    
            // Direcionar o usuário para a URL de aprovação do PayPal
            header('Location: ' . $payment->getApprovalLink());
    
            // Salvar as informações do pagamento no banco de dados
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
    } else {
        echo "ID do Cliente não encontrado.";
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

        <label for="clientid" class="form_label">ID do Cliente</label>
        <input type="text" name="clientid" class="form_input" id="clientid" placeholder="ID do Cliente" required>

        <label for="private_key" class="form_label">Chave Privada</label>
        <input type="text" name="private_key" class="form_input" id="private_key" placeholder="Chave Privada" required>

        <input type="submit" name="enviar" value="Enviar Pagamento" class="btn" />
        <input type="submit" name="close" value="Sair" class="btn" />
    </form>
</div>
</body>
</html>
