<?php
require_once("config.php");

// Configurações do PayPal
$paypal_client_id = "Abj9pThoGIT9MYUOpShoKerMqjoPByh5HuEu-rwyv1sq5OL2C-SdWGUCOv6iZ1djKI8fku66Mn9RPCdB";
$paypal_secret = "EDpRh2E4Ht_pcbp-izxSHCI3E-c1Ln7o-pcf2mHIFn-cagjSU8e2Qwc75e9GtvzVk7xSibd2WDXKoaN5";

// Configurações de URLs de retorno do PayPal
$paypal_return_url = "http://seusite.com/retorno_paypal.php";
$paypal_cancel_url = "http://seusite.com/cancelamento_paypal.php";

// Configurações do ambiente (sandbox ou produção)
$paypal_mode = "sandbox"; // Altere para "live" em produção
?>
