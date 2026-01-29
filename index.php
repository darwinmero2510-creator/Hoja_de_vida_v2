<?php
include 'config/conexion.php';

// Función para fechas
function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    $mesesEspañol = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"];
    $partes = explode("-", $fecha);
    return (count($partes) >= 2) ? $mesesEspañol[$partes[1]] . " " . $partes[0] : $fecha;
}

// Datos Personales
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CV Darwin - Portafolio</title>
    <link rel="stylesheet" href="public/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Ajuste de emergencia para PC: fuerza el ancho total */
        body { margin: 0; padding: 0; }
        .hoja-vida-full { display: flex; width: 100vw; min-height: 100vh; }
        .col-izq { width: 300px; flex-shrink: 0; }
        .col-der { flex-grow: 1; }
    </style>
</head>
<body class="body-cv">

    <div class="hoja-vida">
        
        <aside class="col-izq">
            <div class="foto-perfil-container">
                <div class="foto-circular" style="background-image: url('<?php echo $d['foto_perfil']; ?>');"></div>
            </div>
            
            <div class="bloque-datos-izq">
                <h1 class="nombre-sidebar"><?php echo $d['nombres']; ?><br><?php echo $d['apellidos']; ?></h1>
                
                <div class="contacto-sidebar">
                    <p><i class="fas fa-envelope"></i> <?php echo $d['correo']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $d['telefono']; ?></p>
                </div>

                <hr class="separador">
                <p class="frase-footer">Hoja de vida realizada con esfuerzo, sudor y casi lagrimas</p>
            </div>
        </aside>

        <main class="col-der">
            
            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-briefcase"></i> Experiencia Laboral</div>
                <?php 
                $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");
                while($exp = mysqli_fetch_assoc($res_exp)): ?>
                    <div class="item-contenido">
                        <strong><?php echo $exp['cargo']; ?></strong> | <?php echo $exp['empresa']; ?>
                        <p><?php echo $exp['descripcion']; ?></p>
                    </div>
                <?php endwhile; ?>
            </section>

            <div class="fila-doble">
                <section class="caja-blanca mitad">
                    <div class="titulo-seccion"><i class="fas fa-graduation-cap"></i> Cursos</div>
                </section>

                <section class="caja-blanca mitad">
                    <div class="titulo-seccion"><i class="fas fa-award"></i> Reconocimientos</div>
                </section>
            </div>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-laptop-code"></i> Productos Laborales y Académicos</div>
            </section>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-shopping-cart"></i> Venta de Garaje</div>
            </section>

        </main>
    </div>

</body>
</html>
