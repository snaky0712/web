<?php
include 'conexion.php';

$sql = "SELECT id, nombre_usuario, email, rol, fecha_registro FROM usuarios";
$resultado = $conexion->query($sql);

$usuarios = [];
if ($resultado) {
    $usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="1.css"> 
    </head>
<body>

<nav>
    <a href="index1.php">Administrador</a>
</nav>

<div class="contenedor-usuarios">
    <h2 class="comprado-titulo">Gestión de Usuarios</h2> 
    
    <?php if (count($usuarios) > 0): ?>
        <div class="comprado-tabla-contenedor"> 
            <table class="comprado-tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                            <td>
    <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn-editar">Editar</a>
    <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
</td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
    <?php else: ?>
        <p>No hay usuarios disponibles para mostrar.</p>
    <?php endif; ?>
</div>

</body>
</html>
