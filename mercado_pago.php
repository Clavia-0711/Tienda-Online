<?php

require   'vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-2699663145596670-080614-abdc2352d4550d6ef71c4e544cda7a52-1442593803');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = '0001';
$item->title = 'Producto LAT';
$item->quantity = 1;
$item->unit_price = 150.00;
$item->currency_id = "USD";

$preference->items = array($item);

$preference->back_urls =array(
    "success"=>"http://localhost/FINAL/captura.php",
    "failure"=>"http://localhost/FINAL/fallo.php"
);

$preference->auto_return ="approved";
$preference->binary_mode = true;

$preference->save();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script
        src = "https://sdk.mercadopago.com/js/v2">
    </script>
</head>

<body>
    <h3>Mercado Pago</h3>
    <div class="checkout-btn"></div>
    <script>
        const mp = new MercadoPago('TEST-b03518d8-b408-4505-918d-6ba6d8ff6bf3', {
            locale: 'es-USA'
        });

        mp.checkout ({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'

            }
        })
    </script>
</body>

</html>