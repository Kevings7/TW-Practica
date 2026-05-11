<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] !== 'tecnico') {
    header("Location: index.php");
    exit();
}

require_once 'includes/conexion.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=necesita_login");
    exit();
}

if ($_SESSION['rol'] !== 'tecnico') {
    header("Location: index.php");
    exit();
}

require_once 'includes/conexion.php';

$sql = "
    SELECT 
        i.id,
        i.titulo,
        i.descripcion,
        i.direccion,
        i.fecha_incidencia,
        t.nombre AS tipo,
        e.nombre AS estado,
        p.nombre AS prioridad,
        b.nombre AS barrio,
        u.nombre AS nombre_usuario,
        u.apellidos AS apellidos_usuario
    FROM incidencias i
    INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
    INNER JOIN estados_incidencia e ON i.estado_id = e.id
    INNER JOIN prioridades p ON i.prioridad_id = p.id
    LEFT JOIN barrios b ON i.barrio_id = b.id
    INNER JOIN usuarios u ON i.usuario_id = u.id
    ORDER BY i.created_at DESC
";

$resultado = $conexion->query($sql);

include 'includes/header.php';
?>

<div class="container my-4">

    <h2 class="mb-4">Panel del Ayuntamiento</h2>

    <p class="text-muted">
        Desde este panel el personal técnico puede consultar las incidencias registradas por la ciudadanía.
    </p>

    <?php if ($resultado && $resultado->num_rows > 0): ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Barrio</th>
                        <th>Dirección</th>
                        <th>Ciudadano</th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th>Gestionar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($incidencia = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($incidencia['titulo']); ?></td>

                            <td><?php echo htmlspecialchars($incidencia['tipo']); ?></td>

                            <td>
                                <span class="badge bg-secondary">
                                    <?php echo htmlspecialchars($incidencia['estado']); ?>
                                </span>
                            </td>

                            <td><?php echo htmlspecialchars($incidencia['prioridad']); ?></td>

                            <td><?php echo htmlspecialchars($incidencia['barrio']); ?></td>

                            <td><?php echo htmlspecialchars($incidencia['direccion']); ?></td>

                            <td>
                                <?php 
                                echo htmlspecialchars(
                                    $incidencia['nombre_usuario'] . ' ' . $incidencia['apellidos_usuario']
                                ); 
                                ?>
                            </td>

                            <td>
                                <?php echo date('d/m/Y', strtotime($incidencia['fecha_incidencia'])); ?>
                            </td>

                            <td>
                                <a href="detalle.php?id=<?php echo $incidencia['id']; ?>" 
                                   class="btn btn-outline-primary btn-sm">
                                    Ver
                                </a>
                            </td>
                            <td>
                                <a href="gestionar_incidencia.php?id=<?php echo $incidencia['id']; ?>" 
                                class="btn btn-warning btn-sm">
                                    Gestionar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>

        <div class="alert alert-info">
            Todavía no hay incidencias registradas.
        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
