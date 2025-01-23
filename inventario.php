<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

$stmt = $conexion->prepare("SELECT * FROM productos ORDER BY nombre_producto ASC"); 
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>
<nav>
        <a href="index1.php">Cuenta de Administrador</a>

    </nav>

    <div class="contenedor-inventario">
        <h2 class="inventario-titulo">Inventario de Productos</h2>

        <?php
        if (count($productos) > 0) {
            echo "<table class='inventario-tabla'>";
            echo "<thead><tr><th>ID</th><th>Nombre Producto</th><th>Tipo</th><th>Precio</th><th>Imagen</th><th>Cantidad</th><th>Acciones</th></tr></thead>";
            echo "<tbody>";
            foreach ($productos as $producto) {
                echo "<tr class='inventario-fila'>";
                echo "<td class='inventario-columna'>" . $producto['id'] . "</td>";
                echo "<td class='inventario-columna'>" . htmlspecialchars($producto['nombre_producto']) . "</td>";
                echo "<td class='inventario-columna'>" . htmlspecialchars($producto['tipo']) . "</td>";
                echo "<td class='inventario-columna'>$" . number_format($producto['precio'], 2) . "</td>";
                echo "<td class='inventario-columna'><img src='" . htmlspecialchars($producto['url_imagen']) . "' alt='" . htmlspecialchars($producto['nombre_producto']) . "' class='inventario-imagen'></td>";
                echo "<td class='inventario-columna'>" . $producto['cantidad'] . "</td>";
                echo "<td class='inventario-columna'>
                        <a href='editar_producto.php?id=" . $producto['id'] . "' class='inventario-enlace'>Editar</a> | 
                        <a href='borrar_producto.php?id=" . $producto['id'] . "' class='inventario-enlace' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Borrar</a>
                      </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='inventario-mensaje'>No tienes productos en el inventario.</p>";
        }
        ?>
    </div>
</body>
</html>
