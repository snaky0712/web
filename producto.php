<?php
include('conexion.php');

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($product_id <= 0) {
    echo "<p>Producto no encontrado.</p>";
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($product['nombre_producto']); ?></title>
        <link rel="stylesheet" href="1.css"> 
        </head>
    <body>
        <header>
            <div class="contenedor-encabezado">
            <form action="buscar.php" method="GET" class="buscador">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            </form>                <a href="iniciar_sesion.php" class="iniciar-sesion">
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

        <div class="producto-mostrar">
            <div class="imagen-producto-mostrar">
                <img src="imagenes/<?php echo $product['url_imagen']; ?>" alt="<?php echo htmlspecialchars($product['nombre_producto']); ?>" />
            </div>

            <div class="info-producto-mostrar">
                <h1 class="titulo-producto-mostrar"><?php echo htmlspecialchars($product['nombre_producto']); ?></h1>
                <p class="caracteristicas-producto-mostrar"><strong>Características:</strong> <?php echo nl2br(htmlspecialchars($product['caracteristicas'])); ?></p>

                <p class="precio-producto-mostrar"><strong>Precio:</strong> $<?php echo number_format($product['precio'], 2); ?></p>

                <form action="añadir.php" method="POST" class="botones-mostrar">
    <input type="hidden" name="producto_id" value="<?php echo $product['id']; ?>">

    <button type="submit" name="accion" value="añadir" class="carrito-btn-pagar">Añadir al carrito</button>
    <button type="submit" name="accion" value="comprar" class="carrito-btn-pagar">Comprar ahora</button>
</form>



            </div>
        </div>

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
    <?php
} else {
    echo "<p>Producto no encontrado.</p>";
}
?>
