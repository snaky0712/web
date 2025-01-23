<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("SELECT productos.id, productos.nombre_producto, productos.precio, relacion.cantidad
                            FROM productos
                            JOIN relacion ON productos.id = relacion.id_producto
                            WHERE relacion.id_usuario = :id_usuario");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Compra</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>
    <header>
        <div class="contenedor-encabezado">
        <form action="buscar.php" method="GET" class="buscador">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            <button type="submit">Buscar</button>
            </form>            <a href="iniciar_sesion.php" class="iniciar-sesion">
                <img src="imagenes/usuario.png" alt="Iniciar" class="inicio-sesion">
            </a>
            <a href="carrito.php" class="carrito">
            <img src="imagenes/carrito.png" alt="Carrito" class="carrito">
            </a>            
        </div>
    </header>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="celulares.php">Celulares</a>
        <a href="audifonos.php">Audifonos</a>
        <a href="tablets.php">Tablets</a>
        <a href="otros.php">Otros</a>
    </nav>

    <main>
        <?php
        if (count($productos) === 0) {
            echo "<p class='pago-mensaje'>No hay productos en el carrito.</p>";
            exit();
        }

        try {
            $conexion->beginTransaction();

            $total = 0;
            $productos_comprados = [];

            foreach ($productos as $producto) {
                $id_producto = $producto['id'];
                $cantidad_comprada = $producto['cantidad'];

                $stmt_check = $conexion->prepare("SELECT cantidad FROM productos WHERE id = :id_producto");
                $stmt_check->bindParam(':id_producto', $id_producto);
                $stmt_check->execute();
                $stock_disponible = $stmt_check->fetchColumn();

                if ($stock_disponible < $cantidad_comprada) {
                    throw new Exception("Stock insuficiente para el producto: " . $producto['nombre_producto']);
                }

                $stmt_update = $conexion->prepare("UPDATE productos SET cantidad = cantidad - :cantidad_comprada WHERE id = :id_producto");
                $stmt_update->bindParam(':cantidad_comprada', $cantidad_comprada);
                $stmt_update->bindParam(':id_producto', $id_producto);
                $stmt_update->execute();

                $productos_comprados[] = [
                    'nombre' => $producto['nombre_producto'],
                    'cantidad' => $cantidad_comprada,
                    'precio' => $producto['precio']
                ];

                $total += $producto['precio'] * $cantidad_comprada;
            }

            $stmt_delete = $conexion->prepare("DELETE FROM relacion WHERE id_usuario = :id_usuario");
            $stmt_delete->bindParam(':id_usuario', $id_usuario);
            $stmt_delete->execute();

            $productos_json = json_encode($productos_comprados);
            $forma_pago = 'Tarjeta de crédito';
            $tarjeta_ultimos_digitos = '1234';
            $direccion = 'Calle Ejemplo 123, Ciudad, País';
            $dias_entrega = rand(2, 5);

            $stmt_historial = $conexion->prepare("INSERT INTO historial_compras 
                (id_usuario, productos, total, forma_pago, tarjeta_ultimos_digitos, direccion, dias_entrega) 
                VALUES (:id_usuario, :productos, :total, :forma_pago, :tarjeta_ultimos_digitos, :direccion, :dias_entrega)");
            $stmt_historial->bindParam(':id_usuario', $id_usuario);
            $stmt_historial->bindParam(':productos', $productos_json);
            $stmt_historial->bindParam(':total', $total);
            $stmt_historial->bindParam(':forma_pago', $forma_pago);
            $stmt_historial->bindParam(':tarjeta_ultimos_digitos', $tarjeta_ultimos_digitos);
            $stmt_historial->bindParam(':direccion', $direccion);
            $stmt_historial->bindParam(':dias_entrega', $dias_entrega);
            $stmt_historial->execute();

            $conexion->commit();

            echo "<div class='pago-contenedor'>";
            echo "<h2 class='pago-titulo'>Resumen de tu compra</h2>";
            echo "<table class='pago-tabla'>";
            echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>";
            foreach ($productos_comprados as $producto) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                echo "<td>" . $producto['cantidad'] . "</td>";
                echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<p class='pago-total'><strong>Total:</strong> $" . number_format($total, 2) . "</p>";
            echo "<p class='pago-detalles'><strong>Forma de pago:</strong> $forma_pago</p>";
            echo "<p class='pago-detalles'><strong>Últimos dígitos de la tarjeta:</strong> $tarjeta_ultimos_digitos</p>";
            echo "<p class='pago-detalles'><strong>Dirección de entrega:</strong> $direccion</p>";
            echo "<p class='pago-detalles'><strong>Días estimados de entrega:</strong> $dias_entrega días</p>";
            echo '<div class="pago-botones">';
            echo '<a href="index.php" class="pago-boton">Volver a la tienda</a>';
            echo '<a href="historial.php" class="pago-boton">Ver historial de compras</a>';
            echo '</div>';
            echo "</div>";
        } catch (Exception $e) {
            $conexion->rollBack();
            echo "<p class='pago-error'>Error al procesar el pedido: " . $e->getMessage() . "</p>";
        }
        ?>
    </main>

    <footer class="footer">
        <div class="footer-content">

            <ul class="footer-links">
                <li><a href="#politica">Política de Privacidad</a></li>
                <li><a href="#terminos">Términos de Servicio</a></li>
                <li><a href="#ayuda">Ayuda</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
