<!DOCTYPE html>
<html>
<head>
    <title>PayPal</title>
    <link href="style.css" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
</head>
<body>

<?php
    require('vendor/autoload.php');

    $api = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential('AZh9Q6n6RjrAiLqX3PDbQmw3gWNiwx2__kZyKF4FxiOePCPFQIAOX0ruH3WD9Q0KTObFAnXAIwwSysm8','ENrgWzy8yPRmN84DFYjVcJrAKO_5r1EO3bgFS2EQZg2jYjNl3CEd9frIAp7MVou2yhaoJxWvInS-b-dM')
    );

    $payer = new  \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $amount = new \PayPal\Api\Amount();
    $amount->setCurrency('BRL')->setTotal('200.00');

    $transaction = new \PayPal\Api\Transaction();

    $transaction->setAmount($amount);

    //Gerar ID
    $transaction->setInvoiceNumber(time());

    $redirectUrls = new \PayPal\Api\redirectUrls();

    $redirectUrls->setReturnUrl('http://localhost/Curso/Projeto/Gateways/PayPal/obrigado.php');
    $redirectUrls->setCancelUrl('http://localhost/Curso/Projeto/Gateways/PayPal/cancelar.php');

    $payment = new \PayPal\Api\Payment();
    $payment->setIntent('sale');

    $payment->setPayer($payer);

    $payment->setTransactions(array($transaction));
    $payment->setRedirectUrls($redirectUrls);

    try{
        $payment->create($api);
        header('Location: '.$payment->getApprovalLink());
    }catch(Exception $e){

    }
?>

</body>
</html>