<?php
session_start(); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $id_usuario = $_SESSION['id_usuario'];

    $stmt = $conexion->prepare("DELETE FROM relacion WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: carrito.php?mensaje=producto_eliminado");
        exit();
    } else {
        echo "Error al eliminar el producto del carrito.";
    }
} else {
    header("Location: carrito.php?mensaje=error");
    exit();
}
?>
