<?php
include 'config/conexion.php';

// Función para fechas profesionales (Enero 2025)
function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    $mesesEspañol = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"];
    $partes = explode("-", $fecha);
    return (count($partes) >= 2) ? $mesesEspañol[$partes[1]] . " " . $partes[0] : $fecha;
}

// Datos del Perfil (Asegúrate que coincidan con tu tabla datos_personales)
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CV Darwin - Portafolio</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="hoja-vida">
        
        <aside class="col-izq">
            <div class="foto-circular" style="background-image: url('<?php echo $d['foto_url']; ?>'); background-size: cover;"></div>
            
            <div class="bloque">
                <div class="titulo-caja">Perfil</div>
                <p class="descripcion"><?php echo $d['descripcion_perfil']; ?></p>
            </div>

            <div class="bloque">
                <div class="titulo-caja">Habilidades</div>
                <?php 
                $res_h = mysqli_query($conexion, "SELECT * FROM habilidades");
                while($h = mysqli_fetch_assoc($res_h)): ?>
                    <div class="habilidad-item">
                        <span><?php echo $h['habilidad']; ?></span>
                        <div class="barra-fondo"><div class="barra-progreso" style="width: <?php echo $h['nivel']; ?>%;"></div></div>
                    </div>
                <?php endwhile; ?>
            </div>
        </aside>

        <main class="col-der">
            <header class="encabezado-nombre">
                <h1><?php echo $d['nombre']; ?><br><?php echo $d['apellido']; ?></h1>
                <div class="info-contacto">
                    <span><i class="fas fa-envelope"></i> <?php echo $d['email']; ?></span>
                    <span><i class="fas fa-phone"></i> <?php echo $d['telefono']; ?></span>
                </div>
            </header>

            <section>
                <div class="titulo-linea">Experiencia Laboral</div>
                <?php 
                // Usamos la tabla experiencia_laboral y columnas f_inicio/f_fin
                $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");
                while($exp = mysqli_fetch_assoc($res_exp)): ?>
                    <div class="item-experiencia">
                        <strong><?php echo $exp['cargo']; ?></strong> | <?php echo $exp['empresa']; ?>
                        <div class="periodo"><?php echo obtenerFechaFormateada($exp['f_inicio']); ?> - <?php echo obtenerFechaFormateada($exp['f_fin']); ?></div>
                        <p class="desc-exp"><?php echo $exp['descripcion']; ?></p>
                    </div>
                <?php endwhile; ?>
            </section>

            <section>
                <div class="titulo-linea">Formación y Cursos</div>
                <?php 
                // Corregido: 'nombre_curso' e 'institucion'
                $res_cur = mysqli_query($conexion, "SELECT * FROM cursos ORDER BY f_inicio DESC");
                while($cur = mysqli_fetch_assoc($res_cur)): ?>
                    <div class="item-educacion">
                        <strong><?php echo $cur['nombre_curso']; ?></strong>
                        <div class="periodo"><?php echo $cur['institucion']; ?> | <?php echo obtenerFechaFormateada($cur['f_inicio']); ?></div>
                        <?php if(!empty($cur['archivo_url'])): ?>
                            <a href="<?php echo $cur['archivo_url']; ?>" target="_blank" style="color: var(--cafe-oscuro);">
                                <i class="fas fa-file-pdf"></i> Ver Certificado
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </section>
        </main>
    </div>

</body>
</html>
