<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Look at me</title>

   
</head> <script src="https://www.paypal.com/sdk/js?client-id=ATJIdi4OsWJLVk3IdT-1uKg2XsFpNe7R89Jm3pj8NwgaxUGF5WiGQMoFB96TPkR-jMpFjPFc2inLyBqW&currency=USD"></script>

<body>
    <div id="paypal-button-container"></div>
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
                            value: 100
                        }
                    }]

                });
                
            },
            onApprove: function (data, actions) {
                    actions.order.capture().then(function(detalles) {
                        console.log(detalles)
                    });
            },
            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }

        }).render('#paypal-button-container')
    </script>

</body>

</html>