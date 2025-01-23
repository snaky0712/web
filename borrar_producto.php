<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Eliminar producto de la base de datos
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = :id");
    $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirigir a la página del inventario con un mensaje de éxito
        header("Location: inventario.php?mensaje=Producto eliminado con éxito");
        exit();
    } else {
        // Redirigir a la página del inventario con un mensaje de error
        header("Location: inventario.php?mensaje=Error al eliminar el producto");
        exit();
    }
} else {
    // Si no se recibe el ID, redirigir al inventario
    header("Location: inventario.php");
    exit();
}
