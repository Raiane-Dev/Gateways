<!DOCTYPE html>
<html>
<head>
    <title>Stripe</title>
    <link href="style.css" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        $valor = 150;
        $valor = $valor*100;
    ?>
    <form action="processar.php" method="POST">
        <script 
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_51Jcdy2HUgQFXPmU58mprsA38lSQeG9GoVYZzd5bpBTnwIKsVjzAd66KMvXbhBz31xf2zJRyOAbRekxXBzo0UJuy100qZQdm6gG"
        data-amount="<?php echo $valor; ?>"
        data-name="Raiane Dev"
        data-description="Pagamento referente há..."
        data-image="Panda.png"
        data-locale="auto"
        data-label="Pagar com o Cartão"
        data-currency="BRL"
        data-panel-label="Pagar">
        </script>
        <input type="hidden" name="amount" value="<?php echo $valor; ?>" />


    </form>
</body>
</html>