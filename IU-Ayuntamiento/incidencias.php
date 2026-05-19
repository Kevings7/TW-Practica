<?php
include 'includes/header.php';
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
        b.nombre AS barrio
    FROM incidencias i
    INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
    INNER JOIN estados_incidencia e ON i.estado_id = e.id
    INNER JOIN prioridades p ON i.prioridad_id = p.id
    LEFT JOIN barrios b ON i.barrio_id = b.id
    WHERE i.visible_publicamente = 1
    ORDER BY i.created_at DESC
";

$resultado = $conexion->query($sql);
?>

<h2 class="mb-4">Consultar incidencias</h2>

<p>
    En esta sección se muestran las incidencias urbanas registradas por la ciudadanía
    y su estado actual de resolución.
</p>

<?php if ($resultado && $resultado->num_rows > 0): ?>

    <div class="row row-cols-1 g-4">

        <?php while ($fila = $resultado->fetch_assoc()): ?>

            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($fila['titulo']); ?>
                            </h5>

                            <span class="badge bg-secondary">
                                <?php echo htmlspecialchars($fila['estado']); ?>
                            </span>
                        </div>

                        <p class="card-text">
                            <?php echo htmlspecialchars($fila['descripcion']); ?>
                        </p>

                        <p class="text-muted mb-1">
                            <strong>Tipo:</strong>
                            <?php echo htmlspecialchars($fila['tipo']); ?>
                        </p>

                        <p class="text-muted mb-1">
                            <strong>Prioridad:</strong>
                            <?php echo htmlspecialchars($fila['prioridad']); ?>
                        </p>

                        <p class="text-muted mb-1">
                            <strong>Barrio:</strong>
                            <?php echo htmlspecialchars($fila['barrio']); ?>
                        </p>

                        <p class="text-muted mb-1">
                            <strong>Dirección:</strong>
                            <?php echo htmlspecialchars($fila['direccion']); ?>
                        </p>

                        <p class="text-muted">
                            <strong>Fecha:</strong>
                            <?php echo htmlspecialchars($fila['fecha_incidencia']); ?>
                        </p>

                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    </div>

<?php else: ?>

    <div class="alert alert-info">
        Todavía no hay incidencias registradas.
    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
