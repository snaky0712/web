<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: usuarios.php?mensaje=Usuario eliminado correctamente");
        exit;
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    header("Location: usuarios.php?mensaje=ID de usuario no proporcionado");
    exit;
}
?>
