<?php 
include '../config/conexion.php'; 
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo Darwin - Completo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 1100px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .full { grid-column: span 2; }
        input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { background: #4a3a35; color: white; border: none; padding: 12px; cursor: pointer; width: 100%; border-radius: 6px; font-weight: bold; transition: 0.3s; }
        button:hover { background: #634f47; }
        label { font-weight: bold; font-size: 0.85rem; color: #555; }
    </style>
</head>
<body>
    <div style="max-width: 1100px; margin: auto;">
        <h1 style="text-align:center; color:#4a3a35;">Panel de Control Total</h1>

        <div class="card">
            <h2><i class="fas fa-user-circle"></i> Mi Perfil</h2>
            <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="accion" value="datos_personales">
                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <input type="text" name="nombre" value="<?php echo $d['nombre']; ?>" placeholder="Nombre">
                    <input type="email" name="correo" value="<?php echo $d['correo']; ?>" placeholder="Correo">
                    <input type="text" name="telefono" value="<?php echo $d['telefono']; ?>" placeholder="Teléfono">
                </div>
                <textarea name="perfil_desc" placeholder="Resumen profesional..."><?php echo $d['perfil_descripcion']; ?></textarea>
                <label>Foto de Perfil:</label><input type="file" name="foto">
                <button type="submit">Actualizar Perfil</button>
            </form>
        </div>

        <div class="grid">
            <div class="card">
                <h2><i class="fas fa-briefcase"></i> Nueva Experiencia</h2>
                <form action="procesar_admin.php" method="POST">
                    <input type="hidden" name="accion" value="nueva_experiencia">
                    <input type="text" name="empresa" placeholder="Empresa" required>
                    <input type="text" name="cargo" placeholder="Cargo" required>
                    <input type="number" name="f_inicio" placeholder="Año Inicio" required>
                    <input type="number" name="f_fin" placeholder="Año Fin (Vacio = Presente)">
                    <textarea name="desc" placeholder="¿Qué hiciste allí?"></textarea>
                    <button type="submit">Guardar Experiencia</button>
                </form>
            </div>

            <div class="card">
                <h2><i class="fas fa-graduation-cap"></i> Nuevo Curso</h2>
                <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="nuevo_curso">
                    <input type="text" name="nombre" placeholder="Nombre del Curso" required>
                    <input type="number" name="f_inicio" placeholder="Año Inicio" required>
                    <input type="number" name="f_fin" placeholder="Año Fin" required>
                    <label>Archivo Certificado:</label><input type="file" name="archivo" required>
                    <button type="submit">Guardar Curso</button>
                </form>
            </div>

            <div class="card">
                <h2><i class="fas fa-award"></i> Nuevo Reconocimiento</h2>
                <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="nuevo_reconocimiento">
                    <input type="text" name="titulo" placeholder="Ej: Empleado del Mes" required>
                    <input type="text" name="inst" placeholder="Institución" required>
                    <label>Documento de prueba:</label><input type="file" name="archivo" required>
                    <button type="submit" style="background:#27ae60;">Guardar Reconocimiento</button>
                </form>
            </div>

            <div class="card">
                <h2><i class="fas fa-project-diagram"></i> Nuevo Producto</h2>
                <form action="procesar_admin.php" method="POST">
                    <input type="hidden" name="accion" value="nuevo_producto">
                    <select name="tipo"><option value="Laboral">Laboral</option><option value="Académico">Académico</option></select>
                    <input type="text" name="nombre" placeholder="Nombre del Proyecto" required>
                    <textarea name="desc" placeholder="Descripción breve"></textarea>
                    <button type="submit">Publicar Producto</button>
                </form>
            </div>

            <div class="card full">
                <h2><i class="fas fa-shopping-cart"></i> Publicar en Venta de Garaje</h2>
                <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="nueva_venta">
                    <div style="display:grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px;">
                        <input type="text" name="articulo" placeholder="¿Qué vendes?" required>
                        <input type="number" step="0.01" name="precio" placeholder="Precio ($)" required>
                        <input type="file" name="foto" required>
                    </div>
                    <button type="submit" style="background:#e67e22;">Subir a la Tienda</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('form').forEach(form => {
        form.onsubmit = function(e) {
            let inicio = this.querySelector('input[name="f_inicio"]');
            let fin = this.querySelector('input[name="f_fin"]');
            if(inicio && fin && fin.value !== "" && parseInt(fin.value) < parseInt(inicio.value)) {
                alert("Error de fecha: El fin no puede ser anterior al inicio.");
                e.preventDefault();
                return false;
            }
        };
    });
    </script>
</body>
</html>