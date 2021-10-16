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

    $paymentId = $_GET['paymentId'];

    $payment = \PayPal\Api\Payment::get($paymentId,$api);

    $execute = new \PayPal\Api\PaymentExecution();

    $execute->setPayerId($_GET['PayerID']);

    try{
        $result = $payment->execute($execute,$api);
        try{
            $payment = \PayPal\Api\Payment::get($paymentId,$api);
            $status = $payment->getState();
            if($status == 'approved'){
                //Pagamento Aprovado
                //Atualizar banco de dados
                echo 'Pagamento Aprovado.';
                $info = current($payment->getTransactions());
                $info = $info->toArray();
                $referencia = $info['invoice_number'];
                echo 'Minha Referência: '.$referencia;
            }else{
                //Deu algum erro
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>


</body>
</html>