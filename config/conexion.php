<?php

$host = getenv('DB_HOST') ?: "sql300.infinityfree.com"; 
$user = getenv('DB_USER') ?: "if0_41000446";           
$pass = getenv('DB_PASS') ?: "uhLVwIB9ZWNug1";       
$db   = getenv('DB_NAME') ?: "if0_41000446_web";       

$conexion = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($conexion, "utf8");

if (!$conexion) {
    
    die("Error de conexión: " . mysqli_connect_error());
}
?>