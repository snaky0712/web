<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <link rel="stylesheet" href="1.css"> 
</head>
<body>
    <header>
        <div class="contenedor-encabezado">
            <form action="buscar.php" method="GET" class="buscador">
                <input type="text" name="query" placeholder="Buscar productos..." required>
            </form>
            <a href="iniciar_sesion.php" class="iniciar-sesion">
                <img src="imagenes/usuario.png" alt="Iniciar" class="inicio-sesion">
            </a>
            <a href="carrito.php" class="carrito">
                <img src="imagenes/carrito.png" alt="Carrito" class="carrito">
            </a>            
        </div>

        <nav>
        <a href="index.php">Inicio</a>
        <a href="celulares.php">Celulares</a>
        <a href="audifonos.php">Audifonos</a>
        <a href="tablets.php">Tablets</a>
        <a href="otros.php">Otros</a>
    </nav>
    </header>

    <div class="logo">
            <img src="imagenes/logo.jpg" alt="Logo" class="logo-img">
        </div>
    <div class="contenedor">

        <div class="contenido-principal">
        <section class="productos2">
        <h2>Productos destacados</h2>

<div>
    <img src="imagenes/t1.png" alt="Samsung Galaxy Tab S6 Lite 2024" onclick="window.location.href='producto.php?id=9'" style="cursor: pointer;">
    <div class="detalles">
        <p class="nombre-producto">Samsung Galaxy Tab S6 Lite 2024</p>
        <p class="precio-producto">$8,999</p>
    </div>
</div>

<div>
    <img src="imagenes/t2.png" alt="Apple iPad 9na Gen 10.2'' Wifi 64GB Gris" onclick="window.location.href='producto.php?id=10'" style="cursor: pointer;">
    <div class="detalles">
        <p class="nombre-producto">Apple iPad 9na Gen 10.2'' Wifi 64GB</p>
        <p class="precio-producto">$7,999</p>
    </div>
</div>

<div>
    <img src="imagenes/a1.png" alt="Haylou S30 Pro Anc Audífonos Diadema Gamer Inalámbricos" onclick="window.location.href='producto.php?id=2'" style="cursor: pointer;">
    <div class="detalles">
        <p class="nombre-producto">Haylou S30 Pro Anc Audífonos Diadema Gamer</p>
        <p class="precio-producto">$1,259.82</p>
    </div>
</div>

<div>
    <img src="imagenes/a3.png" alt="Audífonos JBL Tune 520 Bt Bluetooth On Ear" onclick="window.location.href='producto.php?id=4'" style="cursor: pointer;">
    <div class="detalles">
        <p class="nombre-producto">Audífonos JBL Tune 520 Bt Bluetooth</p>
        <p class="precio-producto">$899.82</p>
    </div>
</div>


        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <ul class="footer-links">
                <li><a href="#politica">Política de Privacidad</a></li>
                <li><a href="#terminos">Términos de Servicio</a></li>
                <li><a href="#ayuda">Ayuda</a></li>
                <li><a href="#contacto">Contacto: +34 123 456 789</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
