<?php
include 'conexion.php'; 
session_start(); 

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $pass = $_POST['contrasena'];

    $nombre_usuario = filter_var($nombre_usuario, FILTER_SANITIZE_STRING);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $validar_usuario = $conexion->prepare('SELECT * FROM usuarios WHERE nombre_usuario = :NOMBRE_USUARIO LIMIT 1');
    $validar_usuario->execute(array(':NOMBRE_USUARIO' => $nombre_usuario));
    $resultado = $validar_usuario->fetch();

    if ($resultado) {
        if (password_verify($pass, $resultado['contrasena'])) { 
            $_SESSION['usuario'] = $resultado['nombre_usuario'];
            $_SESSION['id_usuario'] = $resultado['id'];

            if ($resultado['rol'] === 'admin') {
                header("Location: index1.php"); 
            } else {
                header("Location: index.php"); 
            }
            exit;
        } else {
            $errores = '<li>La contraseña es incorrecta</li>';
        }
    } else {
        $errores = '<li>El nombre de usuario no está registrado</li>';
    }

    if (!empty($errores)) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Error en el Inicio de Sesión</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f1f1f1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .error-message {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                .error-message p {
                    color: #ff0000;
                }
                button {
                    background-color: #636363;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 20px;
                    cursor: pointer;
                }
                button:hover {
                    background-color: #4b4b4b;
                }
            </style>
        </head>
        <body>
            <div class="error-message">
                <p><?php echo $errores; ?></p>
                <button onclick="window.location.href='iniciar_sesion.php'">Volver a Intentar</button>
            </div>
        </body>
        </html>
        <?php
    }
}
?>
