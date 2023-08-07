<?php

define("SITE_URL","http://localhost/FINAL");
define("KEY_TOKEN","APR.wqc-354*");
define("MONEDA","$");

define("CLIENT_ID","ATJIdi4OsWJLVk3IdT-1uKg2XsFpNe7R89Jm3pj8NwgaxUGF5WiGQMoFB96TPkR-jMpFjPFc2inLyBqW");
define("TOKEN_MP","TEST-2699663145596670-080614-abdc2352d4550d6ef71c4e544cda7a52-1442593803");

define("CURRENCY","USD");


define("MAIL_HOST","mail.elishalom1107.com");
define("MAIL_USER","ronalmilla2000@gmail.com");
define("MAIL_PASS","71194922");
define("MAIL_PORT","465");

session_start();

$num_cart=0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart=count($_SESSION['carrito']['productos']);
}

?>