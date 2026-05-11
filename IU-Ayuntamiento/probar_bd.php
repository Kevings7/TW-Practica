<?php
require_once 'includes/conexion.php';

$sql = "SELECT id, nombre, distrito, codigo_postal FROM barrios";
$resultado = $conexion->query($sql);
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Prueba base de datos</title>
</head>

<body>

    <h1>Prueba de conexión con la base de datos</h1>

    <h2>Barrios registrados</h2>

    <?php if ($resultado && $resultado->num_rows > 0): ?>

        <ul>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($fila['nombre']); ?>
                    -
                    <?php echo htmlspecialchars($fila['distrito']); ?>
                    -
                    <?php echo htmlspecialchars($fila['codigo_postal']); ?>
                </li>
            <?php endwhile; ?>
        </ul>

    <?php else: ?>

        <p>No hay barrios registrados.</p>

    <?php endif; ?>

</body>

</html>
