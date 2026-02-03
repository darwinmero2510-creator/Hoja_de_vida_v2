<?php
include 'config/conexion.php';

$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);

function e($txt){
    return htmlspecialchars($txt ?? '', ENT_QUOTES, 'UTF-8');
}

/* 🔹 FUNCIÓN PARA MOSTRAR MES Y AÑO (REEMPLAZA strftime) */
function mesAnio($fecha) {
    if (empty($fecha)) return '';

    try {
        $dt = new DateTime($fecha);
    } catch (Exception $e) {
        return '';
    }

    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
        4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
        7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
        10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    return $meses[(int)$dt->format('m')] . ' ' . $dt->format('Y');
}
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
        html, body { margin:0; padding:0; width:100%; min-height:100%; background:#f4ece2; font-family:'Poppins',sans-serif;}
        .hoja-vida { display:flex; width:100vw; min-height:100vh;}
        .col-izq { width:320px; background:#4b3621; color:white; padding:40px 20px; position:sticky; top:0; height:100vh; overflow-y:auto;}
        .col-der { flex-grow:1; padding:40px; overflow-y:auto; height:100vh; box-sizing:border-box;}
        .foto-circular { width:160px; height:160px; border-radius:50%; border:4px solid #f4ece2; margin:0 auto 20px; background-size:cover; background-position:center;}
        .caja-blanca { background:white; border-radius:12px; padding:25px; margin-bottom:25px; box-shadow:0 4px 10px rgba(0,0,0,0.08);}
        .titulo-seccion { font-weight:600; color:#4b3621; margin-bottom:15px; border-bottom:2px solid #e6d5c3; padding-bottom:8px; display:flex; align-items:center; gap:10px;}
        .fila-doble { display:flex; gap:20px;}
        .mitad { flex:1;}
        .badge { background:#e6d5c3; color:#4b3621; padding:2px 8px; border-radius:4px; font-size:.75rem; font-weight:bold; margin-left:10px;}
        .img-producto { width:60px; height:60px; object-fit:cover; border-radius:8px; background:#eee;}
        .btn-pdf { color:#d9534f; font-size:1.1rem;}
    </style>
</head>

<body>

<div class="hoja-vida">

    <!-- ================= IZQUIERDA ================= -->
    <aside class="col-izq">

    <div class="foto-circular"
         style="background-image:url('<?php echo e($d['foto_perfil']); ?>');">
    </div>

    <h1 style="text-align:center;font-size:1.5rem;">
        <?php echo e($d['nombre']); ?>
    </h1>

    <p><i class="fas fa-envelope"></i> <?php echo e($d['correo']); ?></p>
    <p><i class="fas fa-phone"></i> <?php echo e($d['telefono']); ?></p>

    <!-- NUEVOS CAMPOS -->
    <p><i class="fas fa-birthday-cake"></i> <?php echo e($d['fecha_nacimiento']); ?></p>
    <p><i class="fas fa-user-friends"></i> <?php echo e($d['estado_civil']); ?></p>
    <p><i class="fas fa-flag"></i> <?php echo e($d['nacionalidad']); ?></p>
    <p><i class="fas fa-venus-mars"></i> <?php echo e($d['sexo']); ?></p>
    <p><i class="fas fa-map-marker-alt"></i> <?php echo e($d['lugar_nacimiento']); ?></p>
    <p><i class="fas fa-id-card"></i> <?php echo e($d['numero_cedula']); ?></p>
    <p><i class="fas fa-home"></i> <?php echo e($d['direccion']); ?></p>

    <h3>Sobre mí</h3>
    <p><?php echo e($d['perfil_descripcion']); ?></p>

</aside>
>


    <!-- ================= DERECHA ================= -->
    <main class="col-der">

        <!-- EXPERIENCIA -->
        <section class="caja-blanca">
    <div class="titulo-seccion"><i class="fas fa-briefcase"></i> Experiencia</div>

    <?php
    $res_exp = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY f_inicio DESC");

    // Array de meses en español
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    while($exp = mysqli_fetch_assoc($res_exp)):

        // Formatear fecha de inicio
        $fecha_inicio = strtotime($exp['f_inicio']);
        $inicio = $meses[(int)date('m', $fecha_inicio)] . ' ' . date('Y', $fecha_inicio);

        // Formatear fecha de fin
        if (empty($exp['f_fin'])) {
            $fin = 'Actualidad';
        } else {
            $fecha_fin = strtotime($exp['f_fin']);
            $fin = $meses[(int)date('m', $fecha_fin)] . ' ' . date('Y', $fecha_fin);
        }
    ?>
        <div>
            <strong><?php echo e($exp['cargo']); ?></strong> | <?php echo e($exp['empresa']); ?>
            <p><?php echo e($inicio); ?> - <?php echo e($fin); ?></p>
            <p><?php echo e($exp['descripcion']); ?></p>
            <?php if (!empty($exp['certificado'])): ?>
        <a href="<?php echo $exp['certificado']; ?>" target="_blank" class="btn-certificado">
            Ver certificado
        </a>
    <?php endif; ?>
        </div>
    <?php endwhile; ?>
</section>



        <!-- CURSOS + RECONOCIMIENTOS -->
        <div class="fila-doble">

            <section class="caja-blanca mitad">
    <div class="titulo-seccion">Cursos</div>

    <?php
    $res_cur = mysqli_query(
        $conexion,
        "SELECT * FROM cursos ORDER BY f_inicio DESC"
    );

    while ($c = mysqli_fetch_assoc($res_cur)):
        // nombre correcto del campo según tu BD
        $archivo = trim($c['archivo_url'] ?? '');
    ?>
        <div class="item-curso">
            <strong><?php echo e($c['nombre_curso']); ?></strong>

            <div class="fechas">
                <?php if (!empty($c['f_inicio'])): ?>
                    <span>
                        📅 <?php echo e(mesAnio($c['f_inicio'])); ?>
                    </span>
                <?php endif; ?>

                <span>
                    –
                    <?php
                    if (!empty($c['f_fin'])) {
                        echo e(mesAnio($c['f_fin']));
                    } else {
                        echo 'Actualidad';
                    }
                    ?>
                </span>
            </div>

            <?php if (!empty($archivo)): ?>
                <div>
                    <a href="<?php echo e($archivo); ?>"
                       target="_blank"
                       class="btn-pdf">
                        📄 Ver certificado
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</section>
            
           <section class="caja-blanca mitad">
    <div class="titulo-seccion">Reconocimientos</div>

    <?php
    $res_rec = mysqli_query(
        $conexion,
        "SELECT * FROM reconocimientos ORDER BY fecha_reconocimiento DESC"
    );

    // Meses en español
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    while ($r = mysqli_fetch_assoc($res_rec)):
        $archivo = trim($r['archivo_url'] ?? '');

        // Formatear fecha si existe
        $fecha = null;
        if (!empty($r['fecha_reconocimiento'])) {
            $ts = strtotime($r['fecha_reconocimiento']);
            $fecha = $meses[(int)date('m', $ts)] . ' ' . date('Y', $ts);
        }
    ?>
        <div class="item-reconocimiento">
            <strong><?php echo e($r['titulo']); ?></strong>

            <?php if (!empty($r['institucion'])): ?>
                <div class="institucion">
                    🏛 <?php echo e($r['institucion']); ?>
                </div>
            <?php endif; ?>

            <?php if ($fecha): ?>
                <div class="fecha">
                    📅 <?php echo e($fecha); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($r['descripcion_reconocimiento'])): ?>
                <p>
                    <?php echo e($r['descripcion_reconocimiento']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($archivo)): ?>
                <div>
                    <a href="<?php echo e($archivo); ?>"
                       target="_blank"
                       class="btn-pdf">
                        📄 Ver certificado
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</section>
        </div>

       <div class="fila-doble">

    <!-- PRODUCTOS LABORALES -->
    <section class="caja-blanca mitad">
        <div class="titulo-seccion">Productos Laborales</div>

        <?php
        $res_prod_lab = mysqli_query(
            $conexion,
            "SELECT * FROM productos WHERE tipo = 'Laboral'"
        );

        while ($p = mysqli_fetch_assoc($res_prod_lab)):
        ?>
            <div class="item-producto">
                <strong><?php echo e($p['nombre_producto']); ?></strong>

                <?php if (!empty($p['descripcion'])): ?>
                    <div class="desc-prod">
                        <?php echo e($p['descripcion']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- PRODUCTOS ACADÉMICOS -->
    <section class="caja-blanca mitad">
        <div class="titulo-seccion">Productos Académicos</div>

        <?php
        $res_prod_aca = mysqli_query(
            $conexion,
            "SELECT * FROM productos WHERE tipo = 'Académico'"
        );

        while ($p = mysqli_fetch_assoc($res_prod_aca)):
        ?>
            <div class="item-producto">
                <strong><?php echo e($p['nombre_producto']); ?></strong>

                <?php if (!empty($p['descripcion'])): ?>
                    <div class="desc-prod">
                        <?php echo e($p['descripcion']); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </section>

</div>



        <!-- VENTA DE GARAJE -->
        <section class="caja-blanca">
    <div class="titulo-seccion">Venta de Garaje</div>

    <?php
    $res_ven = mysqli_query($conexion, "SELECT * FROM venta_garaje");

    while($v = mysqli_fetch_assoc($res_ven)):
        $nombre = $v['articulo'] ?? 'Producto';
        $foto   = $v['foto_url'] ?? '';
        $precio = number_format((float)$v['precio'], 2);
    ?>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">

            <div style="display:flex;gap:10px;align-items:center;">
                <?php if($foto): ?>
                    <img src="<?php echo htmlspecialchars($foto); ?>" class="img-producto">
                <?php endif; ?>
                <?php echo htmlspecialchars($nombre); ?>
            </div>

            <strong>$<?php echo $precio; ?></strong>
        </div>

    <?php endwhile; ?>
</section>
<!-- Botón Descargar PDF -->
        <div style="text-align:center; margin: 30px 0;">
            <button id="btnDescargarPDF" class="btn-pdf">
                Descargar PDF
            </button>
        </div>
    </div>
</div>

<!-- Librería html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- Script para descargar PDF -->
<script>
document.getElementById("btnDescargarPDF").addEventListener("click", function() {
    var elemento = document.querySelector(".hoja-vida");
    var opciones = {
        margin: 0.5,
        filename: 'Hoja_de_Vida_Darwin.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opciones).from(elemento).save();
});
</script>
        <div class="btn-admin-container">
    <a href="https://hoja-de-vida-v2-1.onrender.com/admin/login.php" target="_blank">
        <button class="btn-admin">Panel de Administrador</button>
    </a>
</div>
    </main>
</div>

</body>
</html>
