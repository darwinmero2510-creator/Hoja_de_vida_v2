<?php
include 'config/conexion.php';

// FUNCIÓN PARA QUE LAS FECHAS SE VEAN COMO "ENERO 2024"
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
        /* ESTO FUERZA EL DISEÑO RECTANGULAR DE LADO A LADO */
        html, body { margin: 0; padding: 0; width: 100%; height: 100%; overflow-x: hidden; }
        .hoja-vida { display: flex; width: 100vw; min-height: 100vh; }
        
        /* Barra café pegada a la izquierda */
        .col-izq { width: 320px; background-color: #4b3621; color: white; padding: 40px 20px; flex-shrink: 0; box-sizing: border-box; }
        
        /* Contenido crema ocupando el resto */
        .col-der { flex-grow: 1; background-color: #f4ece2; padding: 40px; box-sizing: border-box; }
        
        .foto-circular { width: 160px; height: 160px; border-radius: 50%; border: 4px solid #f4ece2; margin: 0 auto 20px; background-size: cover; background-position: center; }
        .caja-blanca { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        .titulo-seccion { font-weight: 600; color: #4b3621; margin-bottom: 15px; border-bottom: 2px solid #e6d5c3; padding-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .fila-doble { display: flex; gap: 20px; }
        .mitad { flex: 1; }
        .nombre-sidebar { font-size: 1.6rem; text-align: center; margin: 20px 0; }
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

                <hr style="opacity: 0.2; margin: 40px 0;">
                <p style="font-size: 0.8rem; text-align: center; opacity: 0.8;">Hoja de vida realizada con esfuerzo, sudor y casi lagrimas</p>
            </div>
        </aside>

        <main class="col-der">
            
            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-briefcase"></i> Experiencia Laboral</div>
                <?php 
                $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");
                while($exp = mysqli_fetch_assoc($res_exp)): ?>
                    <div style="margin-bottom: 15px;">
                        <strong><?php echo $exp['cargo']; ?></strong> | <?php echo $exp['empresa']; ?>
                        <p style="margin: 2px 0; font-size: 0.85rem; color: #8b5e3c; font-weight: 600;">
                            <?php echo obtenerFechaFormateada($exp['f_inicio']); ?> - <?php echo obtenerFechaFormateada($exp['f_fin']); ?>
                        </p>
                        <p style="margin: 5px 0; font-size: 0.95rem; color: #555;"><?php echo $exp['descripcion']; ?></p>
                    </div>
                <?php endwhile; ?>
            </section>

            <div class="fila-doble">
                <section class="caja-blanca mitad">
                    <div class="titulo-seccion"><i class="fas fa-graduation-cap"></i> Cursos</div>
                    <?php 
                    $res_cur = mysqli_query($conexion, "SELECT * FROM cursos ORDER BY idcurso DESC");
                    while($c = mysqli_fetch_assoc($res_cur)): ?>
                        <div style="margin-bottom: 10px; border-left: 3px solid #e6d5c3; padding-left: 10px;">
                            <strong style="font-size: 0.9rem; display: block;"><?php echo $c['nombre_curso']; ?></strong>
                            <small style="color: #666;"><?php echo $c['institucion']; ?></small>
                        </div>
                    <?php endwhile; ?>
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
