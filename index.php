<?php
include 'config/conexion.php';

function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    $mesesEspañol = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"];
    $partes = explode("-", $fecha);
    return (count($partes) >= 2) ? $mesesEspañol[$partes[1]] . " " . $partes[0] : $fecha;
}

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
        /* SCROLL ACTIVO PARA VER TODO */
        html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; background-color: #f4ece2; }
        .hoja-vida { display: flex; width: 100vw; min-height: 100vh; }
        .col-izq { width: 320px; background-color: #4b3621; color: white; padding: 40px 20px; flex-shrink: 0; position: sticky; top: 0; height: 100vh; }
        .col-der { flex-grow: 1; padding: 40px; overflow-y: auto; }
        .foto-circular { width: 160px; height: 160px; border-radius: 50%; border: 4px solid #f4ece2; margin: 0 auto 20px; background-size: cover; background-position: center; }
        .caja-blanca { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        .titulo-seccion { font-weight: 600; color: #4b3621; margin-bottom: 15px; border-bottom: 2px solid #e6d5c3; padding-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .fila-doble { display: flex; gap: 20px; }
        .mitad { flex: 1; }
        .badge { background: #e6d5c3; color: #4b3621; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body>

    <div class="hoja-vida">
        <aside class="col-izq">
            <div class="foto-circular" style="background-image: url('<?php echo $d['foto_perfil']; ?>');"></div>
            <h1 style="text-align:center; font-size: 1.5rem;"><?php echo $d['nombres'] . " " . $d['apellidos']; ?></h1>
            <div style="font-size: 0.9rem; margin-top: 20px;">
                <p><i class="fas fa-envelope"></i> <?php echo $d['correo']; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $d['telefono']; ?></p>
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
                        <p style="color: #8b5e3c; font-size: 0.85rem; font-weight: 600; margin: 2px 0;">
                            <?php echo obtenerFechaFormateada($exp['f_inicio']); ?> - <?php echo obtenerFechaFormateada($exp['f_fin']); ?>
                        </p>
                        <p style="font-size: 0.9rem; color: #555;"><?php echo $exp['descripcion']; ?></p>
                    </div>
                <?php endwhile; ?>
            </section>

            <div class="fila-doble">
                <section class="caja-blanca mitad">
                    <div class="titulo-seccion"><i class="fas fa-graduation-cap"></i> Cursos</div>
                    <?php 
                    $res_cur = mysqli_query($conexion, "SELECT * FROM cursos");
                    while($c = mysqli_fetch_assoc($res_cur)): ?>
                        <div style="margin-bottom: 12px;">
                            <strong style="display:block; font-size: 0.95rem;"><?php echo $c['nombre_curso']; ?></strong>
                            <small style="color: #8b5e3c; font-weight: bold;"><?php echo obtenerFechaFormateada($c['fecha']); ?></small> | 
                            <small><?php echo $c['institucion']; ?></small>
                            <?php if(!empty($c['archivo'])): ?>
                                <br><a href="admin/<?php echo $c['archivo']; ?>" target="_blank" style="font-size: 0.8rem; color: #4b3621;"><i class="fas fa-file-pdf"></i> Ver Certificado</a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </section>

                <section class="caja-blanca mitad">
                    <div class="titulo-seccion"><i class="fas fa-award"></i> Reconocimientos</div>
                    <?php 
                    $res_rec = mysqli_query($conexion, "SELECT * FROM reconocimientos");
                    while($r = mysqli_fetch_assoc($res_rec)): ?>
                        <div style="margin-bottom: 10px;">
                            <strong><?php echo $r['titulo']; ?></strong>
                            <p style="margin:0; font-size: 0.85rem; color: #666;"><?php echo $r['institucion']; ?></p>
                            <?php if(!empty($r['archivo'])): ?>
                                <a href="admin/<?php echo $r['archivo']; ?>" target="_blank" style="font-size: 0.8rem; color: #4b3621;"><i class="fas fa-certificate"></i> Ver Archivo</a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </section>
            </div>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-laptop-code"></i> Productos Laborales y Académicos</div>
                <?php 
                $res_prod = mysqli_query($conexion, "SELECT * FROM productos");
                while($p = mysqli_fetch_assoc($res_prod)): ?>
                    <div style="margin-bottom: 15px;">
                        <strong><?php echo $p['nombre_producto']; ?></strong> 
                        <span class="badge"><?php echo $p['tipo']; ?></span> <p style="font-size: 0.9rem; margin-top: 5px;"><?php echo $p['descripcion']; ?></p>
                        <?php if(!empty($p['archivo'])): ?>
                            <a href="admin/<?php echo $p['archivo']; ?>" target="_blank" style="font-size: 0.8rem; color: #4b3621;"><i class="fas fa-external-link-alt"></i> Ver Proyecto</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </section>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-shopping-cart"></i> Venta de Garaje</div>
                <?php 
                // AJUSTE: Usamos @ para evitar que el error fatal rompa la página si la tabla aún tiene problemas de nombre
                $res_ven = @mysqli_query($conexion, "SELECT * FROM venta"); 
                if($res_ven):
                    while($v = mysqli_fetch_assoc($res_ven)): ?>
                        <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                            <span><?php echo $v['nombre_objeto']; ?></span>
                            <strong style="color: #4b3621;">$<?php echo $v['precio']; ?></strong>
                        </div>
                    <?php endwhile; 
                else: ?>
                    <p style="font-size: 0.8rem; color: #999;">Cargando información de ventas...</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
