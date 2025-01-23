<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header("Location: inventario.php?mensaje=Producto no encontrado");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre_producto = $_POST['nombre_producto'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $url_imagen = $_POST['url_imagen'];

        // Actualizar el producto en la base de datos
        $stmt = $conexion->prepare("UPDATE productos SET nombre_producto = :nombre_producto, tipo = :tipo, precio = :precio, cantidad = :cantidad, url_imagen = :url_imagen WHERE id = :id");
        $stmt->bindParam(':nombre_producto', $nombre_producto);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':url_imagen', $url_imagen);
        $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: inventario.php?mensaje=Producto actualizado con éxito");
            exit();
        } else {
            header("Location: inventario.php?mensaje=Error al actualizar el producto");
            exit();
        }
    }
} else {
    header("Location: inventario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>
    <div class="contenedor-editar">
        <h2 class="editar-titulo">Editar Producto</h2>
        <form action="editar_producto.php?id=<?php echo $producto['id']; ?>" method="POST" class="formulario-editar">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>

            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo htmlspecialchars($producto['tipo']); ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

            <button type="submit" class="btn-editar">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>
