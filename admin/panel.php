<?php 
include '../config/conexion.php'; 
$res_p = mysqli_query($conexion, "SELECT * FROM datos_personales WHERE idperfil=1");
$d = mysqli_fetch_assoc($res_p);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo Darwin - Profesional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 1100px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .full { grid-column: span 2; }
        input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { background: #4a3a35; color: white; border: none; padding: 12px; cursor: pointer; width: 100%; border-radius: 6px; font-weight: bold; transition: 0.3s; }
        button:hover { background: #634f47; }
        label { font-weight: bold; font-size: 0.85rem; color: #555; display: block; margin-top: 5px; }
        .btn-salir { float: right; background: #e74c3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-size: 0.9rem; margin-top: -50px; }
        .btn-salir:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div style="max-width: 1100px; margin: auto; position: relative;">
        <h1 style="text-align:center; color:#4a3a35;">Panel de Control Total</h1>
        <a href="logout.php" class="btn-salir"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>

        <div class="card">
    <h2><i class="fas fa-user-circle"></i> Mi Perfil</h2>
    <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="datos_personales">
        
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
            <input type="text" name="nombre" value="<?php echo $d['nombre']; ?>" placeholder="Nombre">
            <input type="email" name="correo" value="<?php echo $d['correo']; ?>" placeholder="Correo">
            <input type="text" name="telefono" value="<?php echo $d['telefono']; ?>" placeholder="Teléfono">
        </div>

        <!-- NUEVOS CAMPOS -->
        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-top:10px;">
            <input type="date" name="fecha_nacimiento" value="<?php echo $d['fecha_nacimiento']; ?>" placeholder="Fecha de Nacimiento">
            <input type="text" name="estado_civil" value="<?php echo $d['estado_civil']; ?>" placeholder="Estado Civil">
            <input type="text" name="nacionalidad" value="<?php echo $d['nacionalidad']; ?>" placeholder="Nacionalidad">
            <input type="text" name="lugar_nacimiento" value="<?php echo $d['lugar_nacimiento']; ?>" placeholder="Lugar de Nacimiento">
            <input type="text" name="numero_cedula" value="<?php echo $d['numero_cedula']; ?>" placeholder="Número de Cédula">
            <input type="text" name="direccion" value="<?php echo $d['direccion']; ?>" placeholder="Dirección">
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
                    
                    <label>Mes/Año Inicio:</label>
                    <input type="month" name="f_inicio" required>
                    
                    <label>Mes/Año Fin (Vacío = Actualidad):</label>
                    <input type="month" name="f_fin">
                    
                    <textarea name="desc" placeholder="¿Qué hiciste allí?"></textarea>
                    <button type="submit">Guardar Experiencia</button>
                </form>
            </div>

            <div class="card">
                <h2><i class="fas fa-graduation-cap"></i> Nuevo Curso</h2>
                <form action="procesar_admin.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accion" value="nuevo_curso">
                    <input type="text" name="nombre" placeholder="Nombre del Curso" required>
                    
                    <label>Mes/Año Inicio:</label>
                    <input type="month" name="f_inicio" required>
                    
                    <label>Mes/Año Fin:</label>
                    <input type="month" name="f_fin" required>
                    
                    <label>Archivo Certificado (PDF):</label>
                    <input type="file" name="archivo" required>
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
    // Validación mejorada para evitar viajes en el tiempo con formato mes/año
    document.querySelectorAll('form').forEach(form => {
        const inputInicio = form.querySelector('input[name="f_inicio"]');
        const inputFin = form.querySelector('input[name="f_fin"]');

        if (inputInicio && inputFin) {
            // Actualizar el mínimo permitido del segundo input dinámicamente
            inputInicio.addEventListener('change', () => {
                inputFin.min = inputInicio.value;
            });

            form.onsubmit = function(e) {
                if (inputInicio.value && inputFin.value && inputFin.value < inputInicio.value) {
                    alert("¡Error temporal! La fecha de finalización no puede ser anterior a la de inicio.");
                    e.preventDefault();
                    return false;
                }
            }
        }
    });
    </script>
</body>
</html>
