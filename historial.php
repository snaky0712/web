<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("SELECT * FROM historial_compras WHERE id_usuario = :id_usuario ORDER BY fecha_compra DESC");
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
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

    <main>
        <h2 class="historial-titulo">Historial de Compras</h2>

        <?php
        if (count($historial) > 0) {
            foreach ($historial as $compra) {
                $productos = json_decode($compra['productos'], true);
                echo "<div class='historial-contenedor'>";
                echo "<h3 class='historial-subtitulo'>Compra realizada el " . $compra['fecha_compra'] . "</h3>";
                echo "<table class='historial-tabla'>";
                echo "<tr class='historial-fila'><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>";
                foreach ($productos as $producto) {
                    echo "<tr class='historial-fila'>";
                    echo "<td class='historial-producto'>" . htmlspecialchars($producto['nombre']) . "</td>";
                    echo "<td class='historial-cantidad'>" . $producto['cantidad'] . "</td>";
                    echo "<td class='historial-precio'>$" . number_format($producto['precio'], 2) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p class='historial-total'><strong>Total:</strong> $" . number_format($compra['total'], 2) . "</p>";
                echo "<p class='historial-detalle'><strong>Forma de pago:</strong> " . htmlspecialchars($compra['forma_pago']) . "</p>";
                echo "<p class='historial-detalle'><strong>Últimos dígitos de la tarjeta:</strong> " . $compra['tarjeta_ultimos_digitos'] . "</p>";
                echo "<p class='historial-detalle'><strong>Dirección:</strong> " . htmlspecialchars($compra['direccion']) . "</p>";
                echo "<p class='historial-detalle'><strong>Días de entrega:</strong> " . $compra['dias_entrega'] . " días</p>";
                echo "</div>";
            }
        } else {
            echo "<p class='historial-sin-compras'>No tienes compras registradas.</p>";
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
