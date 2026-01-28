<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
include '../config/conexion.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    
    $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' AND password = '$pass'");
    
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['usuario'] = $user;
        header("Location: panel.php"); 
    } else {
        echo "<script>alert('Datos incorrectos');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Hoja de Vida</title>
    <link rel="stylesheet" href="../public/estilo.css">
</head>
<body>
    <form method="POST">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario (admin)" required>
        <input type="password" name="password" placeholder="Contraseña (123)" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>