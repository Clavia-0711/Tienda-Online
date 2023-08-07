

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP:: DEBUG_OFF;                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.elishalom1107.com';   //mail_host                  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   ='ronalmilla2000@gmail.com';    //mail_user                 //SMTP username
    $mail->Password   = '71194922';               //mail_pass                //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                       //mail_port             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ronalmilla2000@gmail.com', 'Tienda LAM');
    $mail->addAddress('elishalom1107@gmail.com', 'Joe User');     //Add a recipient
   

    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Detalles de su compra';
    
    $cuerpo ='<h4> Gracias por su preferencia</h4>';
    $cuerpo .='<p>El ID de su compra es <b>'.$id_transaccion.'</b></p>';

    $mail->Body    = utf8_decode($cuerpo) ;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail -> setLanguage('es','../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la compra : {$mail->ErrorInfo}";
    //exit;
}