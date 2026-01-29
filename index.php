<?php
include 'config/conexion.php';

// 1. FUNCIÓN MÁGICA PARA EL "10": Convierte 2025-01 en "Enero 2025"
function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    
    $mesesEspañol = [
        "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril",
        "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto",
        "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"
    ];

    $partes = explode("-", $fecha); // Divide el año y el mes
    if(count($partes) < 2) return $fecha; // Por si acaso hay un dato viejo tipo "2024"

    $anio = $partes[0];
    $mes = $partes[1];

    return $mesesEspañol[$mes] . " " . $anio;
}

// Consultas a la base de datos
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CV Darwin - Portafolio</title>
    </head>
<body>

    <section id="experiencia">
        <h2><i class="fas fa-briefcase"></i> Experiencia Laboral</h2>
        <?php 
        $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia ORDER BY f_inicio DESC");
        while($exp = mysqli_fetch_assoc($res_exp)): 
        ?>
            <div class="item">
                <h3><?php echo $exp['cargo']; ?></h3>
                <h4><?php echo $exp['empresa']; ?></h4>
                <p class="periodo">
                    <i class="far fa-calendar-alt"></i> 
                    <?php echo obtenerFechaFormateada($exp['f_inicio']); ?> 
                    - 
                    <?php echo obtenerFechaFormateada($exp['f_fin']); ?>
                </p>
                <p><?php echo $exp['descripcion']; ?></p>
            </div>
        <?php endwhile; ?>
    </section>

    <section id="formacion">
        <h2><i class="fas fa-graduation-cap"></i> Formación y Cursos</h2>
        <?php 
        $res_cur = mysqli_query($conexion, "SELECT * FROM cursos ORDER BY f_inicio DESC");
        while($cur = mysqli_fetch_assoc($res_cur)): 
        ?>
            <div class="item">
                <h3><?php echo $cur['nombre']; ?></h3>
                <p class="periodo">
                    <?php echo obtenerFechaFormateada($cur['f_inicio']); ?> a 
                    <?php echo obtenerFechaFormateada($cur['f_fin']); ?>
                </p>
                <?php if(!empty($cur['archivo_url'])): ?>
                    <a href="<?php echo $cur['archivo_url']; ?>" target="_blank">Ver Certificado</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </section>

    </body>
</html>
