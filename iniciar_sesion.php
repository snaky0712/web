<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tienda en Línea</title>
    <link rel="stylesheet" href="1.css"> 
    <style>
 body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #ff4d4d, #cc0000); /* Tonos de rojo */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: #ffffff;
}

.form-container {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 25px;
    padding: 40px;
    width: 100%;
    max-width: 350px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.form-container h1 {
    font-size: 32px;
    color: #cc0000; /* Rojo oscuro */
    margin-bottom: 20px;
    font-weight: 700;
}

.form-container input[type="text"],
.form-container input[type="password"] {
    width: 100%;
    padding: 15px;
    margin: 15px 0;
    border: none;
    border-radius: 50px;
    background-color: #ffe6e6; /* Fondo rojo claro */
    font-size: 16px;
    box-sizing: border-box;
    transition: 0.3s ease;
}

.form-container input[type="text"]:focus,
.form-container input[type="password"]:focus {
    background-color: #ffd6d6; /* Rojo más claro al enfocar */
    box-shadow: 0 0 10px rgba(255, 77, 77, 0.7); /* Sombra roja */
}

.form-container input[type="submit"] {
    background-color: #cc0000; /* Rojo oscuro */
    color: #ffffff;
    padding: 15px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 18px;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.form-container input[type="submit"]:hover {
    background-color: #ff4d4d; /* Rojo más claro al pasar el mouse */
    transform: scale(1.05);
}

.form-container p {
    margin-top: 15px;
    color: #555555;
    font-size: 14px;
}

.form-container p a {
    color: #cc0000; /* Rojo oscuro */
    text-decoration: none;
    font-weight: 500;
    transition: 0.2s ease;
}

.form-container p a:hover {
    text-decoration: underline;
    color: #ff4d4d; /* Rojo más claro */
}

    </style>
</head>
<body>

<div class="form-container">
    <h1>Iniciar Sesión</h1>
    <form action="validar_iniciar_sesion.php" method="POST">
        <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <p>¿No tienes una cuenta? <a href="crear_cuenta.php">Crea una aquí</a></p>
</div>

</body>
</html>
