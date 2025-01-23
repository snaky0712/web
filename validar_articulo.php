<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_producto = $_POST['nombre_producto'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];
    $caracteristicas = $_POST['caracteristicas'];
    $cantidad = $_POST['cantidad'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);

        $imagen_nueva = uniqid() . '.' . $imagen_extension;

        $ruta_imagen = 'imagenes/' . $imagen_nueva;

        if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
            $stmt = $conexion->query("SELECT MAX(id) AS max_id FROM productos");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nuevo_id = $row['max_id'] + 1;

            $stmt = $conexion->prepare("INSERT INTO productos (id, nombre_producto, tipo, precio, caracteristicas, url_imagen, cantidad) 
                                        VALUES (:id, :nombre_producto, :tipo, :precio, :caracteristicas, :url_imagen, :cantidad)");

            $stmt->bindParam(':id', $nuevo_id);
            $stmt->bindParam(':nombre_producto', $nombre_producto);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':caracteristicas', $caracteristicas);
            $stmt->bindParam(':url_imagen', $ruta_imagen);
            $stmt->bindParam(':cantidad', $cantidad);

            if ($stmt->execute()) {
                header("Location: index1.php");
                exit();
            } else {
                echo "Error al registrar el producto.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha cargado la imagen correctamente.";
    }
}
?>
