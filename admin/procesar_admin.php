<?php
include '../config/conexion.php';
$acc = $_POST['accion'] ?? null;

function subir($f, $p) {
    if(!isset($f['name']) || $f['name'] == "") return null;
    $n = $p . "_" . time() . "_" . str_replace(' ', '_', $f['name']);
    move_uploaded_file($f['tmp_name'], "../public/" . $n);
    return "public/" . $n;
}

if ($acc == 'nueva_experiencia') {
    $i = (int)$_POST['f_inicio']; $f = (int)$_POST['f_fin'];
    if ($f >= $i || $_POST['f_fin'] == "") {
        $e = $_POST['empresa']; $c = $_POST['cargo']; $d = $_POST['desc'];
        mysqli_query($conexion, "INSERT INTO experiencia_laboral (idperfil, empresa, cargo, fecha_inicio, fecha_fin, descripcion) VALUES (1, '$e', '$c', '$i', '$f', '$d')");
    }
}

if ($acc == 'nuevo_curso') {
    $i = (int)$_POST['f_inicio']; $f = (int)$_POST['f_fin'];
    if ($f >= $i) {
        $n = $_POST['nombre']; $r = subir($_FILES['archivo'], "cur");
        mysqli_query($conexion, "INSERT INTO cursos (idperfil, nombre_curso, fecha_inicio, fecha_fin, archivo_url) VALUES (1, '$n', '$i', '$f', '$r')");
    }
}

if ($acc == 'nuevo_reconocimiento') {
    $t = $_POST['titulo']; $inst = $_POST['inst'];
    $r = subir($_FILES['archivo'], "rec");
    mysqli_query($conexion, "INSERT INTO reconocimientos (idperfil, titulo, institucion, archivo_url) VALUES (1, '$t', '$inst', '$r')");
}

if ($acc == 'nuevo_producto') {
    $t = $_POST['tipo']; $n = $_POST['nombre']; $d = $_POST['desc'];
    mysqli_query($conexion, "INSERT INTO productos (idperfil, tipo, nombre_producto, descripcion) VALUES (1, '$t', '$n', '$d')");
}

if ($acc == 'nueva_venta') {
    $a = $_POST['articulo']; $p = $_POST['precio'];
    $r = subir($_FILES['foto'], "vnt");
    mysqli_query($conexion, "INSERT INTO venta_garaje (articulo, precio, foto_url) VALUES ('$a', '$p', '$r')");
}

if ($acc == 'datos_personales') {
    $n = $_POST['nombre']; $c = $_POST['correo']; $t = $_POST['telefono']; $d = $_POST['perfil_desc'];
    $foto = subir($_FILES['foto'], "p");
    $sql = "UPDATE datos_personales SET nombre='$n', correo='$c', telefono='$t', perfil_descripcion='$d'";
    if($foto) $sql .= ", foto_perfil='$foto'";
    mysqli_query($conexion, $sql . " WHERE idperfil=1");
}

header("Location: panel.php");
?>