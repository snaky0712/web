<?php
session_start();  // Inicia la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

// Obtener el ID del usuario
$id_usuario = $_SESSION['id_usuario'];

// Actualizar cantidad si se envía un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $nueva_cantidad = intval($_POST['cantidad']);
    
    // Verificar que la cantidad sea válida
    if ($nueva_cantidad > 0) {
        $stmt = $conexion->prepare("UPDATE relacion SET cantidad = :cantidad WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
        $stmt->bindParam(':cantidad', $nueva_cantidad);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':id_producto', $producto_id);
        $stmt->execute();
    }
}

// Obtener los productos del carrito
$stmt = $conexion->prepare("SELECT productos.id, productos.nombre_producto, productos.precio, productos.url_imagen, relacion.cantidad 
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
    <title>Carrito</title>
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

    <section class="carrito-container">
    <h2 class="carrito-titulo">Carrito de Compras</h2>

    <?php if (count($productos) > 0): ?>
        <table class="carrito-tabla">
            <tr class="carrito-fila-titulo">
                <th class="carrito-columna-imagen"></th>
                <th class="carrito-columna-nombre">Producto</th>
                <th class="carrito-columna-precio">Precio</th>
                <th class="carrito-columna-cantidad">Cantidad</th>
                <th class="carrito-columna-subtotal">Subtotal</th>
                <th class="carrito-columna-accion">Acción</th>
            </tr>

            <?php
            $total = 0;
            foreach ($productos as $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
                ?>
                <tr class="carrito-fila">
                    <td class="carrito-celda-imagen">
                        <img src="<?php echo htmlspecialchars($producto['url_imagen']); ?>" alt="Imagen del Producto" class="carrito-imagen">
                    </td>
                    <td class="carrito-celda-nombre"><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td class="carrito-celda-precio">$<?php echo number_format($producto['precio'], 2); ?></td>
                    <td class="carrito-celda-cantidad">
                        <form method="POST" action="carrito.php">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" min="1" class="carrito-input-cantidad">
                            <button type="submit" name="actualizar_cantidad" class="carrito-btn-actualizar">Actualizar</button>
                        </form>
                    </td>
                    <td class="carrito-celda-subtotal">$<?php echo number_format($subtotal, 2); ?></td>
                    <td class="carrito-celda-accion">
                        <a href="eliminar_carrito.php?id=<?php echo $producto['id']; ?>" class="carrito-eliminar">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
            ?>

            <tr class="carrito-fila-total">
                <td colspan="4" class="carrito-columna-total">Total</td>
                <td colspan="2" class="carrito-columna-total-precio">
                    <strong>$<?php echo number_format($total, 2); ?></strong>
                </td>
            </tr>
        </table>
        <a href="pago.php" class="carrito-btn-pagar">Comprar</a>
        <?php else: ?>

    <?php endif; ?>
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
