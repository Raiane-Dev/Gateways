<?php
    ini_set('max_execution_time','0');

    if(isset($_POST['gerar_sessao'])){
        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=raiane.dev@gmail.com&token=MEU-TOKEN';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $retorno = curl_exec($curl);
        curl_close($curl);
        $session = simplexml_load_string($retorno);
        die(json_encode($session));
    }else if(isset($_POST['fechar_pedido'])){
        $data = [
            'email'=>'MEU EMAIL',
            'token'=>'MEU TOKEN',
            'paymentMode'=>'default',
            'paymentMethod'=>'creditCard',
            'receiverEmail'=>'meu email',
            'currency'=>'BRL',
            'extraAmount'=>'0.00',
            'itemId1'=>'1',
            'itemDescription1'=>'Camisa',
            'itemAmount1'=>number_format($_POST['amount'],2,'.',''),
            'itemQuantity1'=>'1',
            'notificationURL'=>'http://localhost/Curso/Projeto/Gateways/PagSeguro/',
            'reference'=>uniqid,
            'senderName'=>'Raiane Dev',
            'senderCPF'=>'05421455025',
            'senderAreaCode'=>'51',
            'senderPhone'=>'5199999999',
            'senderEmail'=>'raiane.dev@gmail.com',
            'senderHash'=>$_POST['hash'],
            'shippingAddressStreet'=>'Rua Getúlio Dorneles Vargas',
            'shippingAddressNumber'=>'496',
            'shippingAddressComplement'=>'Casa sem reboco',
            'shippingAddressDistrict'=>'Vila norte',
            'shippingAddressPostalCode'=>'96270000',
            'shippingAddressCity'=>'Mostardas',
            'shippingAddressState'=>'RS',
            'shippingCountry'=>'BRA',
            'shippingType'=>'3',
            'shippingCost'=>'0.00',
            'creditCardToken'=>$_POST['token'],
            'installmentQuantity'=>$_POST['parcelas'],
            'installmentValue'=>number_format($_POST['valorParcela'],2,'.',''),
            'noInterestInstallmentQuantity'=>4,
            'creditCardHolderName'=>'RAIANE ARCARO DAROS',
            'creditCardHolderCPF'=>'05421455025',
            'creditCardHolderBithDate'=>'10/01/2004',
            'creditCardHolderAreaCode'=>'48',
            'creditCardHolderPhone'=>'5199999999',
            'bilingAddressStreet'=>'Rua getúlio dorneles vargas',
            'bilingAddressNumber'=>'244',
            'bilingAddressComplement'=>'Casa sem reboco',
            'bilingAddressDistrict'=>'Vila Norte',
            'bilingAddressPostalCode'=>'962700000',
            'bilingAddressCity'=>'Mostardas',
            'bilingAddressState'=>'RS',
            'bilingAddressCountry'=>'BRA'
        ];
        $query = http_build_query($data);
        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
        curl_setopt($curl, CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$query);

        $retorno = curl_exec($curl);
        $xml = json_encode(simplexml_load_string($retorno));

        die($xml);
    }
?>