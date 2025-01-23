<?php
// Incluir el archivo de conexión
include('conexion.php');

// Verificar si se ha enviado una búsqueda
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Saneamiento de la entrada para evitar inyecciones SQL
    $query = htmlspecialchars($query);

    // Consulta SQL para buscar productos cuyo nombre coincida con la búsqueda
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE nombre_producto LIKE :query");
    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar productos</title>
    <link rel="stylesheet" href="diseñoo.css"> 
    </head>
<body>
    <header>
        <div class="contenedor-encabezado">
        <form action="buscar.php" method="GET" class="buscador">
            <input type="text" name="query" placeholder="Buscar productos..." required>
            </form>
            </form>
            <a href="iniciar_sesion.php" class="iniciar-sesion">
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

    <section class="productos2">
        <?php
        // Mostrar los productos encontrados
        if (isset($productos) && count($productos) > 0) {
            foreach ($productos as $producto) {
                ?>
                <div>
                    <img src="imagenes/<?php echo htmlspecialchars($producto['url_imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" onclick="window.location.href='producto.php?id=<?php echo $producto['id']; ?>'" style="cursor: pointer;">
                    <p class="nombre-producto"><?php echo htmlspecialchars($producto['nombre_producto']); ?></p>
                    <p class="precio-producto">$<?php echo number_format($producto['precio'], 2); ?></p>
                </div>
                <?php
            }
        } else {
            echo '<p>No se encontraron productos que coincidan con la búsqueda.</p>';
        }
        ?>
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
