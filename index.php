<?php include 'config/conexion.php'; 
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $d['nombre']; ?> - CV</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #4a3a35; --secondary: #dcbfae; --bg: #f4e1d2; }
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: var(--bg); display: flex; }
        .sidebar { width: 300px; background: var(--primary); color: white; height: 100vh; padding: 30px; position: fixed; box-sizing: border-box; }
        .foto-perfil { width: 150px; height: 150px; border-radius: 50%; border: 4px solid var(--secondary); margin: 0 auto 20px; overflow: hidden; }
        .foto-perfil img { width: 100%; height: 100%; object-fit: cover; }
        .main-content { margin-left: 300px; padding: 40px; width: 100%; box-sizing: border-box; }
        .section { background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h3 { color: var(--primary); border-bottom: 2px solid var(--secondary); padding-bottom: 5px; margin-top: 0; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #fff; }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="foto-perfil"><img src="<?php echo $d['foto_perfil'] ?: 'public/yo.jpg'; ?>"></div>
    <h2 style="text-align:center;"><?php echo $d['nombre']; ?></h2>
    <p><i class="fas fa-envelope"></i> <?php echo $d['correo']; ?></p>
    <p><i class="fas fa-phone"></i> <?php echo $d['telefono']; ?></p>
    <hr style="border-color: var(--secondary);">
    <p style="font-size: 0.9rem;"><?php echo $d['perfil_descripcion']; ?></p>
</div>

<div class="main-content">
    <div class="section">
        <h3><i class="fas fa-briefcase"></i> Experiencia Laboral</h3>
        <?php $exps = mysqli_query($conexion, "SELECT * FROM experiencia_laboral ORDER BY fecha_inicio DESC");
        while($e = mysqli_fetch_assoc($exps)){ ?>
            <div>
                <strong><?php echo $e['cargo']; ?></strong> en <b><?php echo $e['empresa']; ?></b><br>
                <small><?php echo $e['fecha_inicio']; ?> - <?php echo $e['fecha_fin'] ?: 'Presente'; ?></small>
                <p><?php echo $e['descripcion']; ?></p><hr>
            </div>
        <?php } ?>
    </div>

    <div class="grid">
        <div class="section">
            <h3><i class="fas fa-graduation-cap"></i> Cursos</h3>
            <?php $curs = mysqli_query($conexion, "SELECT * FROM cursos");
            while($c = mysqli_fetch_assoc($curs)){ ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span><b><?php echo $c['nombre_curso']; ?></b><br><small><?php echo $c['fecha_inicio']; ?> - <?php echo $c['fecha_fin']; ?></small></span>
                    <a href="<?php echo $c['archivo_url']; ?>" target="_blank" style="color:var(--primary);"><i class="fas fa-file-pdf fa-lg"></i></a>
                </div>
            <?php } ?>
        </div>
        <div class="section">
            <h3><i class="fas fa-award"></i> Reconocimientos</h3>
            <?php $recs = mysqli_query($conexion, "SELECT * FROM reconocimientos");
            while($r = mysqli_fetch_assoc($recs)){ ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span><b><?php echo $r['titulo']; ?></b><br><small><?php echo $r['institucion']; ?></small></span>
                    <a href="<?php echo $r['archivo_url']; ?>" target="_blank" style="color:var(--primary);"><i class="fas fa-certificate fa-lg"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="section">
        <h3><i class="fas fa-laptop-code"></i> Productos Laborales y Académicos</h3>
        <div class="grid">
            <?php $prods = mysqli_query($conexion, "SELECT * FROM productos");
            while($p = mysqli_fetch_assoc($prods)){ ?>
                <div class="card">
                    <small style="background:var(--secondary); padding:2px 5px; border-radius:4px;"><?php echo $p['tipo']; ?></small>
                    <h4><?php echo $p['nombre_producto']; ?></h4>
                    <p><?php echo $p['descripcion']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="section">
        <h3><i class="fas fa-shopping-cart"></i> Venta de Garaje</h3>
        <div class="grid">
            <?php $vnt = mysqli_query($conexion, "SELECT * FROM venta_garaje");
            while($v = mysqli_fetch_assoc($vnt)){ ?>
                <div class="card"><img src="<?php echo $v['foto_url']; ?>"><h4><?php echo $v['articulo']; ?></h4><b style="color:green;">$<?php echo $v['precio']; ?></b></div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>