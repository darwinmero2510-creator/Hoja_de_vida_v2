<?php
include 'config/conexion.php';

// Función para fechas elegantes
function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    $mesesEspañol = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"];
    $partes = explode("-", $fecha);
    return (count($partes) >= 2) ? $mesesEspañol[$partes[1]] . " " . $partes[0] : $fecha;
}

// Datos Personales - Ajustado a tus columnas reales
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Darwin - Portafolio</title>
    <link rel="stylesheet" href="public/estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="hoja-vida">
        <aside class="col-izq">
            <div class="foto-circular" style="background-image: url('<?php echo $d['foto_perfil']; ?>');"></div>
            
            <div class="info-perfil-izq">
                <h1 class="nombre-destacado"><?php echo $d['nombres']; ?><br><?php echo $d['apellidos']; ?></h1>
                
                <div class="datos-contacto">
                    <p><i class="fas fa-envelope"></i> <?php echo $d['correo']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $d['telefono']; ?></p>
                </div>

                <hr class="linea-decorativa">
                <p class="frase-footer">Hoja de vida realizada con esfuerzo, sudor y casi lagrimas</p>
            </div>
        </aside>

        <main class="col-der">
            
            <section class="seccion-cv">
                <div class="titulo-caja"><i class="fas fa-briefcase"></i> Experiencia Laboral</div>
                <div class="contenido-caja">
                    <?php 
                    $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");
                    if(mysqli_num_rows($res_exp) > 0):
                        while($exp = mysqli_fetch_assoc($res_exp)): ?>
                            <div class="item">
                                <strong><?php echo $exp['cargo']; ?></strong> | <?php echo $exp['empresa']; ?>
                                <p><?php echo $exp['descripcion']; ?></p>
                            </div>
                        <?php endwhile; 
                    else: echo "<p class='espera'>Esperando información...</p>"; endif; ?>
                </div>
            </section>

            <div class="fila-flexible">
                <section class="seccion-cv mitad">
                    <div class="titulo-caja"><i class="fas fa-graduation-cap"></i> Cursos</div>
                    <div class="contenido-caja">
                        <p class='espera'>Esperando información...</p>
                    </div>
                </section>

                <section class="seccion-cv mitad">
                    <div class="titulo-caja"><i class="fas fa-award"></i> Reconocimientos</div>
                    <div class="contenido-caja">
                        <p class='espera'>Esperando información...</p>
                    </div>
                </section>
            </div>

            <section class="seccion-cv">
                <div class="titulo-caja"><i class="fas fa-laptop-code"></i> Productos Laborales y Académicos</div>
                <div class="contenido-caja">
                    <p class='espera'>Esperando información...</p>
                </div>
            </section>

            <section class="seccion-cv">
                <div class="titulo-caja"><i class="fas fa-store"></i> Venta de Garaje</div>
                <div class="contenido-caja">
                    <p class='espera'>Esperando información...</p>
                </div>
            </section>

        </main>
    </div>

</body>
</html>
