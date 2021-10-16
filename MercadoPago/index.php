<!DOCTYPE html>
<html>
<head>
    <title>Mercado Pago</title>
    <link href="style.css" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
</head>
<body>

<?php
    /*
        Primeiro criamos uma aplicação
    */
    require('vendor/autoload.php');

    $mp = new MP('MINHA CHAVE APP ID','MINHA CHAVE SECRET KEY');

    $data = array(
        'items'               => array(),
        'shipments'           => array(
            'mode'            => 'custom',
            'cost'            => 20.00,
            'receiver_adress' => array(
                'zip_code'    => '96270-000'
            )
        ),
        'back_urls'           => array(
            'success'         => 'http://localhost/Curso/Projeto/Gateways/MercadoPago/obrigado.php',
            'pending'         => 'http://localhost/Curso/Projeto/Gateways/MercadoPago/pendente.php',
            'failure'         => 'http://localhost/Curso/Projeto/Gateways/MercadoPago/falhou.php',
        ),
        'notification_url'    => 'http://localhost/Curso/Projeto/Gateways/MercadoPago/notificacao.php',
        'auto_return'         => 'approved',
        'external_reference'  => uniqid()
    );

    $data['items'][0] = array(
        'title'       => 'Sapato',
        'quantity'    => 1,
        'currency_id' => 'BRL',
        'unit_price'  => 200.00
    );

    $link = $mp->create_preference($data);
    header('Location: '.$link['response']['sandbox_init_point']);
    die();


?>


</body>
</html>