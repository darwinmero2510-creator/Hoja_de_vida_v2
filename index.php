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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Un poquito de estilo para que se vea "bonito" de nuevo */
        body { font-family: 'Segoe UI', sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: auto; padding: 20px; }
        h2 { border-bottom: 2px solid #4a3a35; color: #4a3a35; padding-bottom: 5px; }
        .item { margin-bottom: 20px; padding: 10px; border-left: 3px solid #4a3a35; background: #fff; }
        .periodo { color: #666; font-size: 0.9rem; font-weight: bold; }
        .institucion { color: #4a3a35; font-style: italic; display: block; }
        a { color: #2980b9; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <section id="experiencia">
        <h2><i class="fas fa-briefcase"></i> Experiencia Laboral</h2>
        <?php 
        // Usamos f_inicio y f_fin que son los nombres en HeidiSQL
        $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");
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
        // Usamos f_inicio y f_fin para los cursos
        $res_cur = mysqli_query($conexion, "SELECT * FROM cursos ORDER BY f_inicio DESC");
        while($cur = mysqli_fetch_assoc($res_cur)): 
        ?>
            <div class="item">
                <h3><?php echo $cur['nombre_curso']; ?></h3>
                <span class="institucion"><?php echo $cur['institucion']; ?></span>
                
                <p class="periodo">
                    <i class="far fa-calendar-alt"></i>
                    <?php echo obtenerFechaFormateada($cur['f_inicio']); ?> a 
                    <?php echo obtenerFechaFormateada($cur['f_fin']); ?>
                </p>
                
                <?php if(!empty($cur['archivo_url'])): ?>
                    <a href="<?php echo $cur['archivo_url']; ?>" target="_blank">
                        <i class="fas fa-file-pdf"></i> Ver Certificado
                    </a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </section>

</body>
</html>
