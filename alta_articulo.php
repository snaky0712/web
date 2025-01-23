<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}

include('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Alta de Productos</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>


    <nav>
        <a href="index1.php">Administrador</a>
    </nav>

    <section class="formulario-alta-producto">
        <h2>Alta de Producto</h2>
        <form method="POST" action="validar_Articulo.php" enctype="multipart/form-data">
            <label for="nombre_producto" class="alta-nombre-producto">Nombre del Producto:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" required class="alta-input">

            <label for="tipo" class="alta-tipo-producto">Tipo de Producto:</label>
            <select id="tipo" name="tipo" required class="alta-select">
                <option value="celulares">Celular</option>
                <option value="tablets">Tablets</option>
                <option value="audifonos">Audífonos</option>
                <option value="otro">Otro</option>
            </select>

            <label for="precio" class="alta-precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required class="alta-input">

            <label for="caracteristicas" class="alta-caracteristicas">Características:</label>
            <textarea id="caracteristicas" name="caracteristicas" required class="alta-textarea"></textarea>

            <label for="imagen" class="alta-imagen">Subir Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required class="alta-input-file">

            <label for="cantidad" class="alta-cantidad">Cantidad en Inventario:</label>
            <input type="number" id="cantidad" name="cantidad" required class="alta-input">

            <button type="submit" class="alta-btn-confirmar">Confirmar Alta</button>
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
