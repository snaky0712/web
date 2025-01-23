<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Electrónica</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>

    <nav>
        <a href="index1.php">Cuenta de Administrador</a>

    </nav>




<div class="menu-opciones">
    <h3>Opciones</h3>
    <ul>
        <li>
            <span class="icono">🏠</span>
            <a href="crear_cuenta_admin.php">Dar de alta administradores</a>
        </li>
        <li>
            <span class="icono">🏠</span>
            <a href="inventario.php">Inventario</a>
        </li>
        <li>
            <span class="icono">📦</span>
            <a href="usuarios.php">Usuarios</a>
        </li>
        <li>
            <span class="icono">⚙️</span>
            <a href="alta_articulo.php">Dar de alta articulo</a>
        </li>
    </ul>
    <div class="divider"></div>
    <ul>
        <li>
            <span class="icono">🔒</span>
            <a href="index.php">Cerrar sesión</a>
        </li>
    </ul>
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
