<?php
require 'config/config.php';
require 'config/database.php';
require   'vendor/autoload.php';

MercadoPago\SDK::setAccessToken(TOKEN_MP);

$preference = new MercadoPago\Preference();
$producto_mp = array();


$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id,nombre,precio,descuento,$cantidad as cantidad FROM productos WHERE id=? and activo=1");

        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("location: index.php");
    exit;
}


//session_destroy();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online Look at me</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
    <script src="https://sdk.mercadopago.com/js/v2">
    </script>
    <script src="https://www.paypal.com/sdk/js?client-id=ATJIdi4OsWJLVk3IdT-1uKg2XsFpNe7R89Jm3pj8NwgaxUGF5WiGQMoFB96TPkR-jMpFjPFc2inLyBqW&currency=USD"></script>



</head>

<body>


    <header>

        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="#" class="navbar-brand ">

                    <strong><i>Look At Me</i></strong>&nbsp
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera2" viewBox="0 0 16 16">
                        <path d="M5 8c0-1.657 2.343-3 4-3V4a4 4 0 0 0-4 4z" />
                        <path d="M12.318 3h2.015C15.253 3 16 3.746 16 4.667v6.666c0 .92-.746 1.667-1.667 1.667h-2.015A5.97 5.97 0 0 1 9 14a5.972 5.972 0 0 1-3.318-1H1.667C.747 13 0 12.254 0 11.333V4.667C0 3.747.746 3 1.667 3H2a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1h.682A5.97 5.97 0 0 1 9 2c1.227 0 2.367.368 3.318 1zM2 4.5a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0zM14 8A5 5 0 1 0 4 8a5 5 0 0 0 10 0z" />
                    </svg>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catálogo</a>

                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link ">Contacto</a>

                        </li>
                    </ul>


                    <a href="carrito.php" class="btn btn-dark">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span>
                    </a>



                </div>

            </div>
        </div>
    </header>

    <main>
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <h4> Detalles de pago</h4>
                    <div class="row">
                        <div class="col-12">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="checkout-btn"></div>
                        </div>
                    </div>
                </div>


                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>

                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if ($lista_carrito == null) {
                                        echo '<tr><td colspan="5" class="text-center" <b>Lista vacía</b></td></tr>';
                                    } else {
                                        $total = 0;
                                        foreach ($lista_carrito as $producto) {
                                            $_id = $producto['id'];
                                            $nombre = $producto['nombre'];
                                            $precio = $producto['precio'];
                                            $descuento = $producto['descuento'];
                                            $cantidad = $producto['cantidad'];
                                            $precio_desc = $precio - (($precio * $descuento) / 100);
                                            $subtotal = $cantidad * $precio_desc;
                                            $total += $subtotal;

                                            $item = new MercadoPago\Item();
                                            $item->id = $_id;
                                            $item->title = $nombre;
                                            $item->quantity = $cantidad;
                                            $item->unit_price = $precio_desc;
                                            $item->currency_id = "USD";

                                            array_push($producto_mp, $item);
                                            unset($item);
                                    ?>

                                            <tr>
                                                <td> <?php echo $nombre ?></td>


                                                <td>
                                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[] "><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                                </td>

                                            </tr>
                                        <?php } ?>

                                        <tr>

                                            <td colspan="2">
                                                <p class="h3 text-end" id="total"><?php echo  MONEDA . number_format($total, 2, '.', ','); ?></p>
                                            </td>
                                        </tr>
                                </tbody>
                            <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
            
    </main>
    <?php
    $preference->items = $producto_mp;
    $preference->back_urls = array(
        "success" => "http://localhost/FINAL/captura.php",
        "failure" => "http://localhost/FINAL/fallo.php"
    );
    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay',
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]

                });

            },
            onApprove: function(data, actions) {
                let URL = 'clases/captura.php'
                actions.order.capture().then(function(detalles) {
                    console.log(detalles)

                    let url = 'clases/captura.php'

                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },

                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(respose) {
                        window.location.href = "completado.php?key=" + detalles['id'];
                    })
                });
            },
            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }

        }).render('#paypal-button-container');

        const mp = new MercadoPago('TEST-b03518d8-b408-4505-918d-6ba6d8ff6bf3', {
            locale: 'es-USA'
        });

        mp.checkout ({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con Mercado Pago'

            }
        })
    </script>

</body>

</html>