<!DOCTYPE html>
<html>
<head>
    <title>PagSeguro</title>
    <link href="css/style.css" rel="stylesheet" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<section class="pagamento">
    <div class="pagamento">

        <div class="breadcumb">
            <span><i data-feather="chevron-left"></i> Voltar para o checkout</span>
        </div><!--breadcumb-->

        <div class="container">
            <div class="metodo">
                <h2>Método de Pagamento</h2>
                <p>Meios de pagamento</p>
                <div class="metodo-boxes">
                    <ul>
                        <li>
                            <label><i data-feather="credit-card"></i> Cartão de Crédito</label>
                        </li>
                        <li>
                            <label><i data-feather="bar-chart-2"></i> Boleto Báncario</label>
                        </li>
                    </ul>
                </div><!--metodo-boxes-->
            </div><!--metodo-->

            <div class="bandeira">
                <div class="bandeira-boxes">

                    <div class="bandeira-single">
                        <div class="single-area">
                            <i data-feather="credit-card"></i>
                            <h6>**** **** **** ****</h6>
                            <p>Valido até 11/27</p>
                        </div><!--single-area-->
                        <div class="single-area">
                            <p>Nome Completo</p><img src="" />
                            <!--COLOCAR AS IMAGENS DA BANDEIRAS DO PAGSEGURO AI-->
                        </div><!--single-area-->
                    </div><!--bandeira-single-->

                </div><!--bandeira-boxes-->
            </div><!--bandeira-->
            
            <div class="formulario-checkout">
                <div class="formulario-campos">
                    <form method="post">

                    <label>Nome Completo</label>
                    <input name="nome" type="text" placeholder="" />

                    <label>CPF</label>
                    <input name="cpf" type="text" placeholder="" />

                    <label>Número do Cartão</label>
                    <input type="text" name="numero_cartao" />

                    <label>Bandeira</label>
                    <select name="bandeira">

                    </select>

                    <div class="form-grupo">
                        <div>
                        <label>Data de Expiração</label>
                        <input name="mes_validade" type="number" placeholder="Mês" />
                        <input name="ano_validade" type="number" placeholder="Ano" />
                        </div>

                        <div>
                        <label>CVV</label>
                        <input type="number" min="1" max="3" name="cvv" placeholder="***"/>
                        </div>
                    </div><!--form-grupo-->

                    <select name="valores">
                        
                    </select>

                    <div class="finalizar">
                        <h6>Total preço <span> 79,89</span></h6>
                        <input type="submit" name="acao" value="Confirmar" />
                    </div><!--finalizar-->

                    </form>
                </div><!--formulario-campos-->
            </div><!--formulario-checkout-->
        </div><!--container-->
    </div><!--pagamento-->
</section><!--pagamento-->






<script>
    feather.replace()
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script>

    valor = 400.50;
    var imagens = [];

    //Listar Bandeiras
    $.ajax({
        dataType:'json',
        url:'cartao_credito.php',
        method:'post',
        data:{'gerar_sessao':'true'}
    }).done(function(data){
        PagSeguroDirectPayment.setSessionId(data.id);
        PagSeguroDirectPayment.getPaymentMethods({
            success: function(response){
                var bancos = '';
                var bandeiras = '';

                $.each(response.paymentMethods.CREDIT_CARD.options,function(key,value){
                    imagens[value.name.toLowerCase()] = 'https://stc.pagseguro.uol.com.br'+value.images.MEDIUM.path;
                    bandeiras+='<option value="'+value.name.toLowerCase()+'">'+value.name+'</option>';
                })
                $('select[name=bandeira]').html(bandeiras);
            }
        })
    })

    //Detectando a bandeira do cartão
    $('input[name=numero_cartao]').on('keyup', function(){
        if($(this).val().length >= 6){
            PagSeguroDirectPayment.getBrand({
                cardBin:$(this).val().substring(0,6),
                success:function(v){
                    var cartao = v.brand.name;
                    PagSeguroDirectPayment.getInstallments({
                        amount:valor,
                        maxInstallmentNoInterest:4,
                        brand:cartao,
                        success:function(data){
                            var bandeirasSelect = $('select[name=bandeira]');
                            bandeirasSelect.find('option').removeAttr('selected');
                            bandeirasSelect.find('option[value='+cartao+']').attr('selected','selected');

                            $('select[name=valores]').html('');
                            //Listar opções de Parcelamento
                            $.each(data.installments[cartao],function(index,value){
                                var htmlAtual = $('select[name=valores').html();
                                var valorParcela = value.installmentAmount;
                                var juros = value.interestFree == true ? ' Sem Juros' : ' Com Juros';
                                $('select[name=valores]').html(htmlAtual+'<option value"'+(index+1)+':'+valorParcela+'">'+valorParcela+juros+'</option>');
                            })
                        }
                    })
                }
            })
        }
    })

    $('select[name=bandeira]').change(function(){
        var bandeira = (this).val();
        PagSeguroDirectPayment.getInstallments({
            amount:valor,
            maxInstallmentNoInterest:4,
            brand:bandeira,
            success: function(data){


                $.each(data.installments[bandeira],function(index,value){
                    $('select[name=valores]').html('');
                    var htmlAtual = $('select[name=valores]').html();
                    var valorParcela = value.installmentAmount;
                    var juros = value.interestFree == true ? ' Sem Juros' : ' Com Juros';
                    $('select[name=valores]').html(htmlAtual+'<option value="'+(index+1)+':'+valorParcela+'">'+valorParcela+juros'</option>');
                })
            }
        })
    })


    $('form').submit(function(e){
        e.preventDefault();
        $('.container').animate({'opacity':'0.4'});
        $('form').find('input').attr('disabled','disabled');

        var numero_cartao = $('[name=numero_cartao]').val();
        var cvv = $('[name=cvv]').val();
        var bandeira = $('[name=bandeira]').val();
        var parcela = $('[name=valores]').val();
        var mes = $('[name=mes_validade]').val();
        var ano = $('[name=ano_validade]').val();

        var hash = PagSeguroDirectPayment.getSenderHash();

        //Pegar a bandeira
        PagSeguroDirectPayment.createCardToken({
            cardNumber: numero_cartao,
            brand: bandeira,
            cvv: cvv,
            expirationMonth: mes,
            expirationYear: ano,
            success: function(data){
                console.log('Sucesso');
                var token = data.card.token;
                var splitParcelas = parcela.split(':');
                var valorParcela = splitParcela[1];
                var numeroParcela = splitParcela[0];

                $.ajax({
                    'method':'post',
                    'dataType':'json',
                    'url':'cartao_credito.php',
                    'data':{'fechar_pedido':true,'token':token,'cartao':bandeira,'parcelas':numeroParcela,'valorParcela':valorParcela,'hash':hash,'amount':valor},
                    success:function(data){
                        if(data.status == undefined){
                            //ocorreu algum erro ao pagar
                            alert('Ocorreu algum erro ao pagar.');
                        }else{
                            //O pagamento foi processado com sucesso
                            $('.container').animate({'opacity':'1'});
                            alert('O pagamento foi realizado com sucesso.');
                        }
                    }
                })
            },
            error:function(data){
                console.log(data);
                alert('Ocorreu algum erro ao pagar.');
            }
        })        
    });
</script>
</body>
</html>