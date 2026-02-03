<?php
include '../config/conexion.php';

include '../config/config_cloudinary.php'; 

use Cloudinary\Api\Upload\UploadApi; // Importamos la herramienta de subida
function convertirMesAnio($fecha) {
    if (empty($fecha)) return null;

    // Acepta MM/YYYY o MM-YYYY
    $fecha = str_replace('/', '-', $fecha);

    if (!preg_match('/^\d{2}-\d{4}$/', $fecha)) {
        echo "<script>
            alert('Formato incorrecto. Use MM/YYYY (ej: 04/2025)');
            window.history.back();
        </script>";
        exit;
    }

    list($mes, $anio) = explode('-', $fecha);
    return $anio . '-' . $mes . '-01';
}

$acc = $_POST['accion'] ?? null;

// FUNCIÓN SUBIR CORREGIDA PARA CLOUDINARY
function subir($f) {
    // Si no hay archivo, retornamos nulo
    if(!isset($f['tmp_name']) || $f['tmp_name'] == "") return null;
    
    try {
        // Subimos el archivo temporal directamente a la nube
        $uploadApi = new UploadApi();
        $resultado = $uploadApi->upload($f['tmp_name']);
        
        // Retornamos la URL segura (https) que nos da Cloudinary
        return $resultado['secure_url']; 
    } catch (Exception $e) {
        return null; // Si algo falla, no guarda nada para no romper la BD
    }
}

if ($acc == 'nueva_experiencia') {

    $e = $_POST['empresa'];
    $c = $_POST['cargo'];
    $d = $_POST['desc'];

    $f_inicio = $_POST['f_inicio'] . '-01';

    if (!empty($_POST['f_fin'])) {
        $f_fin = $_POST['f_fin'] . '-01';
    } else {
        $f_fin = null;
    }

    /* ===========================
       CERTIFICADO (OPCIONAL)
    ============================ */
    $certificado = '';

    if (isset($_FILES['certificado']) && $_FILES['certificado']['error'] === 0) {

        $carpeta = "../certificados/";
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $nombreArchivo = time() . "_" . basename($_FILES['certificado']['name']);
        $rutaFinal = $carpeta . $nombreArchivo;

        move_uploaded_file($_FILES['certificado']['tmp_name'], $rutaFinal);

        $certificado = "certificados/" . $nombreArchivo;
    }

    /* ===========================
       VALIDACIÓN DE FECHAS
    ============================ */
    if ($f_fin === null || strtotime($f_fin) >= strtotime($f_inicio)) {

        $stmt = $conexion->prepare("
            INSERT INTO experiencia_laboral
            (idperfil, empresa, cargo, f_inicio, f_fin, descripcion, certificado)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $idperfil = 1;

        $stmt->bind_param(
            "issssss",
            $idperfil,
            $e,
            $c,
            $f_inicio,
            $f_fin,
            $d,
            $certificado
        );

        $stmt->execute();
    }
}


if ($acc == 'nuevo_curso') {

    // Convertimos YYYY-MM a fecha válida YYYY-MM-01
    $i = !empty($_POST['f_inicio']) ? $_POST['f_inicio'] . '-01' : null;
    $f = !empty($_POST['f_fin']) ? $_POST['f_fin'] . '-01' : null;

    if ($f === null || $i === null || $f >= $i) {

        $n = $_POST['nombre'];
        $r = subir($_FILES['archivo']); // link de Cloudinary

        mysqli_query(
            $conexion,
            "INSERT INTO cursos (idperfil, nombre_curso, f_inicio, f_fin, archivo_url)
             VALUES (1, '$n', '$i', '$f', '$r')"
        );
    }
}


if ($acc == 'nuevo_reconocimiento') {
    $t = $_POST['titulo']; $inst = $_POST['inst'];
    $r = subir($_FILES['archivo']); 
    $fecha_rec = !empty($_POST['fecha_reconocimiento'])
    ? convertirMesAnio($_POST['fecha_reconocimiento'])
    : null;

$desc_rec = $_POST['descripcion_reconocimiento'] ?? null;

    mysqli_query($conexion, "INSERT INTO reconocimientos (idperfil, titulo, institucion, fecha_reconocimiento, descripcion_reconocimiento, archivo_url) VALUES (1, '$t', '$inst', '$r')");
}

if ($acc == 'nuevo_producto') {
    $t = $_POST['tipo']; $n = $_POST['nombre']; $d = $_POST['desc'];
    mysqli_query($conexion, "INSERT INTO productos (idperfil, tipo, nombre_producto, descripcion) VALUES (1, '$t', '$n', '$d')");
}

if ($acc == 'nueva_venta') {
    $a = $_POST['articulo']; $p = $_POST['precio'];
    $r = subir($_FILES['foto']); 
    mysqli_query($conexion, "INSERT INTO venta_garaje (articulo, precio, foto_url) VALUES ('$a', '$p', '$r')");
}

if ($acc == 'datos_personales') {
    // Campos existentes
    $n = $_POST['nombre'];
    $c = $_POST['correo'];
    $t = $_POST['telefono'];
    $d = $_POST['perfil_desc'];

    // NUEVOS CAMPOS
    $fecha = $_POST['fecha_nacimiento'];
    $estado = $_POST['estado_civil'];
    $nacionalidad = $_POST['nacionalidad'];
    $lugar = $_POST['lugar_nacimiento'];
    $cedula = $_POST['numero_cedula'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];

    // Foto
    $foto = subir($_FILES['foto']); 

    // Consulta SQL
    $sql = "UPDATE datos_personales SET 
            nombre='$n',
            correo='$c',
            telefono='$t',
            perfil_descripcion='$d',
            fecha_nacimiento='$fecha',
            estado_civil='$estado',
            nacionalidad='$nacionalidad',
            lugar_nacimiento='$lugar',
            numero_cedula='$cedula',
            direccion='$direccion',
            sexo='$sexo'";
    
    if($foto) {
        $sql .= ", foto_perfil='$foto'";
    }

    $sql .= " WHERE idperfil=1";
    mysqli_query($conexion, $sql);
}


header("Location: panel.php");
?>
