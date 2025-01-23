<?php
include 'conexion.php';
$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $rol = 'admin'; 

    $nombre_usuario = filter_var(strtolower($nombre_usuario), FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $contrasena = filter_var($contrasena, FILTER_SANITIZE_STRING);

    $validar_usuario = $conexion->prepare('SELECT * FROM Usuarios WHERE nombre_usuario = :NOMBRE_USUARIO OR email = :EMAIL LIMIT 1');
    $validar_usuario->execute(array(':NOMBRE_USUARIO' => $nombre_usuario, ':EMAIL' => $email));
    $resultado = $validar_usuario->fetch();

    if ($resultado !== false) {
        if ($resultado['nombre_usuario'] === $nombre_usuario) {
            $errores .= '<li>El nombre de usuario ya está registrado</li>';
        }
        if ($resultado['email'] === $email) {
            $errores .= '<li>El correo electrónico ya está registrado</li>';
        }
    }

    if (!empty($errores)) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Error en la Creación de Cuenta</title>
   
        </head>
        <body>
            <div class="error-message">
                <p><?php echo $errores; ?></p>
                <button onclick="window.location.href='crear_cuenta.php'">Volver a Intentar</button>
            </div>
        </body>
        </html>
        <?php
    } else {
        $guardar = $conexion->prepare('INSERT INTO Usuarios (nombre_usuario, email, contrasena, rol, fecha_registro) VALUES (:NOMBRE_USUARIO, :EMAIL, :CONTRASENA, :ROL, NOW())');
        $guardar->execute(array(
            ':NOMBRE_USUARIO' => $nombre_usuario,
            ':EMAIL' => $email,
            ':CONTRASENA' => password_hash($contrasena, PASSWORD_DEFAULT),
            ':ROL' => $rol
        ));

        echo "<script>
            sessionStorage.setItem('nombre_usuario', '$nombre_usuario');
            window.location.href = 'registrado.php';
        </script>";
        exit();
    }
}
?>
