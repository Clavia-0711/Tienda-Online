<?php



require'config/config.php';
require'config/database.php';
require'clases/clienteFunciones.php';

$db=new Database();
$con=$db->conectar();
$errors =[];
if(!empty($_POST)){

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    if(esNulo([$nombres,$apellidos,$email,$telefono,$dni,$usuario,$password,$repassword])){
        $errors[]="Debe llenar todos los campos";
    }
    if(!esEmail($email)){
        $errors[]="La dirección de correo no es válida" ;   
    }
    if(!validaPassword($password,$repassword)){
        $errors[]="Las contraseñas no coinciden";
    }
    if(usuarioExiste($usuario,$con)){
        $errors[]="El nombre del usuario $usuario ya existe";
    }
    if(emailExiste($email,$con)){
        $errors[]="El correo electrónico $email ya existe";
    }
    if(count($errors)==0){

    
    $id= registraCliente([$nombres,$apellidos,$email,$telefono,$dni],$con);

    if($id>0){
        require 'clases/Mailer.php';
        $mailer= new Mailer();
        $token = generartoken();
       
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $idUsuario =registraUsuario([$usuario,$pass_hash,$token,$id], $con);
        if($idUsuario>0){
            $url =SITE_URL.'/activa_cliente.php?id='.$idUsuario.'&token='.$token;

            $asunto="Activar cuenta-Tienda Online";
            $cuerpo="Estimado $nombres:<br> Para continuar con el proceso de registro es necesario de click en la siguiente liga <a href='$url'>Activar cuenta</a>";
            if($mailer->enviarEmail($email,$asunto,$cuerpo)){
                echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado a la direccionde correo electrónico $email";
                exit;  
            }

        }else{$errors[]="Error al registrar usuario";
        }
    } else{
        $errors[]="Error al registrar cliente";
    }}

    
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

    <main>
        <div class="container">
            <h2>Datos del Cliente</h2>

            <?php mostrarMensajes($errors);?>

            <form class="row g-3" action="registro.php" method="post" autocomplete="off" >
                <div class="col-md-6">
                    <label for="nombre"><span class="text-danger">*</span> Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" requireda >
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" requireda >
                </div>
                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span> Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" requireda >
                    <span id="validaEmail" class="text-warning" ></span>
                </div>
                
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span> Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" requireda >
                </div>
                <div class="col-md-6">
                    <label for="dni"><span class="text-danger">*</span> DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" requireda >
                </div>
                
                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" requireda >
                    <span id="validaUsuario" class="text-warning" ></span>
                </div>
                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span>Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" requireda >
                </div>
                
                <div class="col-md-6">
                    <label for=repassword"><span class="text-danger">*</span> Repetir contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" requireda >
                </div>
                <i><b>Nota:</b>Los campos con asterisco son obligatorios</i>
            <div class="col-12">
                <button type=button"  class="btn btn-outline-transparent" ><a href="login.php" >Registrarse</a></button>

            </div>

            </form>
         
            </div>
           
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        let txtUsuario=document.getElementById('usuario')
        txtUsuario.addEventListener("blur", function(){
            existeUsuario(txtUsuario.value)
        },false)

        let txtEmail=document.getElementById('email')
        txtUsuario.addEventListener("blur", function(){
            existeUsuario(txtUsuario.value)
        },false)

        function existeEmail(email){
            let url="clases/clienteAjax.php"
            let formData =new FormData()
            formData.append("action","existeEmial")
            formData.append("email",email)

            fetch(url,{
                method: 'POST',
                body:formData
            }).then(response=>response.json())
            .then(data=>{
                if(data.ok){
                    document.getElementById('email').value=''
                    document.getElementById('validaEmail').innerHTML='Email no disponible'
                }else{
                    document.getElementById('validaEmail').innerHTML=''
                }
            })
        }

        function existeUsuario(usuario){
            let url="clases/clienteAjax.php"
            let formData =new FormData()
            formData.append("action","existeUsuario")
            formData.append("usuario",usuario)

            fetch(url,{
                method: 'POST',
                body:formData
            }).then(response=>response.json())
            .then(data=>{
                if(data.ok){
                    document.getElementById('usuario').value=''
                    document.getElementById('validaUsuario').innerHTML='Usuario no disponible'
                }else{
                    document.getElementById('validaUsuario').innerHTML=''
                }
            })
        }
    </script>
</body>

</html>