<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include '../config/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    // Consulta directa a tu base de datos en Aiven
    $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' AND password = '$pass'");
    
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['usuario'] = $user;
        header("Location: panel.php"); 
        exit();
    } else {
        echo "<script>alert('Datos incorrectos. Intenta de nuevo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin | Hoja de Vida</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a3a35 0%, #2c1e1a 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 380px;
            text-align: center;
        }
        .login-container i.icon-header {
            font-size: 60px;
            color: #4a3a35;
            margin-bottom: 15px;
        }
        .login-container h2 {
            margin: 0 0 25px 0;
            color: #333;
            font-size: 1.6rem;
            font-weight: 700;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #4a3a35;
            outline: none;
            box-shadow: 0 0 8px rgba(74, 58, 53, 0.2);
        }
        button {
            background: #4a3a35;
            color: #fff;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }
        button:hover {
            background: #634f47;
        }
        .footer-note {
            margin-top: 25px;
            font-size: 0.8rem;
            color: #999;
        }
    </style>
</head>
<body>

<div class="login-container">
    <i class="fas fa-user-circle icon-header"></i>
    <h2>Iniciar Sesión</h2>
    
    <form method="POST">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Usuario</label>
            <input type="text" name="usuario" placeholder="Tu nombre de usuario" required>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Contraseña</label>
            <input type="password" name="password" placeholder="Tu contraseña" required>
        </div>
        
        <button type="submit">Entrar al Panel</button>
    </form>
    
    <div class="footer-note">
        &copy; <?php echo date('Y'); ?> Darwin Mero - Administrador
    </div>
</div>

</body>
</html>
