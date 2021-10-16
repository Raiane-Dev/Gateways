<?php

    require('vendor/autoload.php');

    $mp = new MP('MINHA CHAVE APP ID','MINHA CHAVE SECRET KEY');

    $mp->sandbox_mode(true);

    $info = $mp->get_payment_info($_GET['id']);
    if($info['status'] == 200){
        //Foi feito com sucesso a requisição
        $ref = $info['response']['collection']['external_reference'];
        $status = $info['response']['collection']['status'];
        if($status == 'approved'){
            //Pagamento aprovado
            //Vamos atualizar no banco de dados!
        }
    }

?>