<?php
include 'config/conexion.php';

function obtenerFechaFormateada($fecha) {
    if (empty($fecha)) return "Actualidad";
    $mesesEspañol = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre"];
    $partes = explode("-", $fecha);
    return (count($partes) >= 2) ? $mesesEspañol[$partes[1]] . " " . $partes[0] : $fecha;
}

// Obtenemos tus datos personales (incluyendo la descripción editable del admin)
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
        html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; background-color: #f4ece2; font-family: 'Poppins', sans-serif; }
        .hoja-vida { display: flex; width: 100vw; min-height: 100vh; }
        .col-izq { width: 320px; background-color: #4b3621; color: white; padding: 40px 20px; flex-shrink: 0; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .col-der { flex-grow: 1; padding: 40px; overflow-y: auto; height: 100vh; box-sizing: border-box; }
        .foto-circular { width: 160px; height: 160px; border-radius: 50%; border: 4px solid #f4ece2; margin: 0 auto 20px; background-size: cover; background-position: center; }
        .caja-blanca { background: white; border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        .titulo-seccion { font-weight: 600; color: #4b3621; margin-bottom: 15px; border-bottom: 2px solid #e6d5c3; padding-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .fila-doble { display: flex; gap: 20px; }
        .mitad { flex: 1; }
        .badge { background: #e6d5c3; color: #4b3621; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; margin-left: 10px; }
        .img-producto { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background: #eee; }
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
            
            <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
                <h3 style="font-size: 1rem; margin-bottom: 10px;"><i class="fas fa-user"></i> Sobre Mí</h3>
                <p style="font-size: 0.85rem; line-height: 1.5; opacity: 0.9;">
                    <?php echo !empty($d['descripcion_perfil']) ? $d['descripcion_perfil'] : 'Bienvenido a mi perfil profesional.'; ?>
                </p>
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
                            <strong style="display:block;"><?php echo $c['nombre_curso']; ?></strong>
                            <small><?php echo obtenerFechaFormateada($c['fecha']); ?></small>
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
                        </div>
                    <?php endwhile; ?>
                </section>
            </div>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-laptop-code"></i> Productos Laborales y Académicos</div>
                <?php 
                $res_prod = mysqli_query($conexion, "SELECT * FROM productos");
                if($res_prod):
                    while($p = mysqli_fetch_assoc($res_prod)): ?>
                        <div style="margin-bottom: 15px;">
                            <strong><?php echo $p['nombre_producto']; ?></strong> 
                            <span class="badge"><?php echo $p['tipo']; ?></span>
                            <p style="font-size: 0.9rem; margin-top: 5px;"><?php echo $p['descripcion']; ?></p>
                        </div>
                    <?php endwhile;
                endif; ?>
            </section>

            <section class="caja-blanca">
                <div class="titulo-seccion"><i class="fas fa-shopping-cart"></i> Venta de Garaje</div>
                <?php 
                $res_ven = mysqli_query($conexion, "SELECT * FROM venta_garaje"); 
                if($res_ven):
                    while($v = mysqli_fetch_assoc($res_ven)): 
                        $nombre = $v['nombre'] ?? $v['nombre_objeto'] ?? 'Producto';
                        $foto = !empty($v['imagen']) ? $v['imagen'] : (!empty($v['foto']) ? $v['foto'] : '');
                ?>
                        <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f9f9f9; padding-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <?php if(!empty($foto)): ?>
                                    <img src="admin/<?php echo $foto; ?>" class="img-producto">
                                <?php else: ?>
                                    <div class="img-producto" style="display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-camera" style="color: #ccc;"></i>
                                    </div>
                                <?php endif; ?>
                                <span style="font-weight: 600; color: #4b3621;"><?php echo $nombre; ?></span>
                            </div>
                            <strong style="color: #4b3621; font-size: 1.1rem;">$<?php echo $v['precio']; ?></strong>
                        </div>
                    <?php endwhile; 
                endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
