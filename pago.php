<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['id_usuario'];
$stmt = $conexion->prepare("SELECT productos.nombre_producto, productos.precio, relacion.cantidad
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
    <title>Formulario de Pago</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>
    <header>
        <div class="contenedor-encabezado">
        <form action="buscar.php" method="GET" class="buscador">
            <input type="text" name="query" placeholder="Buscar productos..." required>
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

    <section class="formulario-pago">
        <h2>Formulario de Pago</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($productos as $producto) {
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="2"><strong>Total:</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form method="POST" action="procesar_pago.php">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="direccion">Dirección de Envío:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="tarjeta">Número de Tarjeta:</label>
            <input type="text" id="tarjeta" name="tarjeta" maxlength="16" required>

            <label for="expiracion">Fecha de Expiración:</label>
            <input type="month" id="expiracion" name="expiracion" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" required>

            <button type="submit" class="btn-confirmar">Confirmar Compra</button>
        </form>
    </section>

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
