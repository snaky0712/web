<?php
session_start(); 

include 'conexion.php';  

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

if (isset($_POST['accion']) && $_POST['accion'] == 'añadir') {
    $producto_id = $_POST['producto_id'];  
    $id_usuario = $_SESSION['id_usuario'];  

    $stmt = $conexion->prepare("SELECT cantidad FROM relacion WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':id_producto', $producto_id);
    $stmt->execute();
    $producto_en_carrito = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto_en_carrito) {
        $nueva_cantidad = $producto_en_carrito['cantidad'] + 1;
        $stmt = $conexion->prepare("UPDATE relacion SET cantidad = :cantidad WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
        $stmt->bindParam(':cantidad', $nueva_cantidad);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_producto', $producto_id);
        $stmt->execute();
    } else {
        $stmt = $conexion->prepare("INSERT INTO relacion (id_usuario, id_producto, cantidad) VALUES (:id_usuario, :id_producto, 1)");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_producto', $producto_id);
        $stmt->execute();
    }

    header("Location: carrito.php");
    exit(); 
} else {
    echo "<p>Error al añadir el producto al carrito.</p>";
}
?>
