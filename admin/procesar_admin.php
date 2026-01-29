<?php
include '../config/conexion.php';

include '../config/config_cloudinary.php'; 

use Cloudinary\Api\Upload\UploadApi; // Importamos la herramienta de subida

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
    $i = (int)$_POST['f_inicio']; $f = (int)$_POST['f_fin'];
    if ($f >= $i || $_POST['f_fin'] == "") {
        $e = $_POST['empresa']; $c = $_POST['cargo']; $d = $_POST['desc'];
        mysqli_query($conexion, "INSERT INTO experiencia_laboral (idperfil, empresa, cargo, f_inicio, f_fin, descripcion) VALUES (1, '$e', '$c', '$i', '$f', '$d')");
    }
}

if ($acc == 'nuevo_curso') {
    $i = (int)$_POST['f_inicio']; $f = (int)$_POST['f_fin'];
    if ($f >= $i) {
        $n = $_POST['nombre']; 
        $r = subir($_FILES['archivo']); // Ahora $r será un link de Cloudinary
        mysqli_query($conexion, "INSERT INTO cursos (idperfil, nombre_curso, f_inicio, f_fin, archivo_url) VALUES (1, '$n', '$i', '$f', '$r')");
    }
}

if ($acc == 'nuevo_reconocimiento') {
    $t = $_POST['titulo']; $inst = $_POST['inst'];
    $r = subir($_FILES['archivo']); 
    mysqli_query($conexion, "INSERT INTO reconocimientos (idperfil, titulo, institucion, archivo_url) VALUES (1, '$t', '$inst', '$r')");
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
    $n = $_POST['nombre']; $c = $_POST['correo']; $t = $_POST['telefono']; $d = $_POST['perfil_desc'];
    $foto = subir($_FILES['foto']); 
    $sql = "UPDATE datos_personales SET nombre='$n', correo='$c', telefono='$t', perfil_descripcion='$d'";
    if($foto) $sql .= ", foto_perfil='$foto'";
    mysqli_query($conexion, $sql . " WHERE idperfil=1");
}

header("Location: panel.php");
?>
