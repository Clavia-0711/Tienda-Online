<?php



require'config/config.php';
require'config/database.php';
require'clases/clienteFunciones.php';

$db=new Database();
$con=$db->conectar();
$errors =[];
if(!empty($_POST)){

    
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
   
    if(esNulo([$usuario,$password])){
        $errors[]="Debe llenar todos los campos";
    }
   
    
    
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
    <link href="css/all.min.css" rel="stylesheet" >
    <link href="css/estilos.css" rel="stylesheet" >
     
   


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

                   
                    <a href="checkout.php" class="btn btn-dark">
                        Carrito <span id="num_cart" class="badge bg-secondary" ><?php echo $num_cart ?></span>
                    </a>



                </div>

            </div>
        </div>
    </header>

    <center><main class="form-login m-auto pt-4" >
        <h2>Iniciar Sesión</h2>
        <?php mostrarMensajes($errors);?>
        <form class="row g-3" style="max-width: 350px;" action="login.php" method="post" autocomplete="off"  " >
            <div class="form-floating" >
                <input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" required >
                <label for="usuario" >Usuario</label>

            </div>
            <div class="form-floating" >
                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
                <label for="password" >Contraseña</label>

            </div>
            <div class="col-12"  ><a href="recuperar.php" >¿Olvidaste tu contraseña?
            </a></div>
            <div class="d-grid gap-3 col-12" >
               <a href="index.php" > <button type="button" class="btn btn-secondary" >Ingresar</button></a>
            </div>

            <hr>
            <div class="col-12" >
                ¿No tiene cuenta?<a href="registro.php" >Regístrate aquí</a>
            </div>
        </form>
        
        
           
    </main></center>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>

</html>