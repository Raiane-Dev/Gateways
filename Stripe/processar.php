<?php
    require('vendor/autoload.php');

    $stripe = array(
        "secret_key"      => "sk_test_51Jcdy2HUgQFXPmU5PD2UU9FYazEDyZUrSyoX9yCf0AO02hEel5OOEi0UlfZ8lrOB7WuNJCsyV5HaU8rGWSkHkmzv00b1EBQawD",
        "publishable_key" => "pk_test_51Jcdy2HUgQFXPmU58mprsA38lSQeG9GoVYZzd5bpBTnwIKsVjzAd66KMvXbhBz31xf2zJRyOAbRekxXBzo0UJuy100qZQdm6gG"
    );
    \Stripe\Stripe::setApiKey($stripe['secret_key']);


    $token = $_POST['stripeToken'];
    $email = $_POST['stripeEmail'];

    $customer = \Stripe\Customer::create(array(
        'email'  => $email,
        'source' => $token
    ));

    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $_POST['amount'],
        'currency' => 'brl'
    ));
    echo '<h2>Sucesso.</h2>';
?>