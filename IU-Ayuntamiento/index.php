<?php
require_once 'includes/conexion.php';

$tipo_seleccionado = 0;

if (isset($_GET['tipo_id'])) {
    $tipo_seleccionado = (int) $_GET['tipo_id'];
}

/*
Consulta para cargar los tipos de incidencia en el menú lateral.
*/
$sql_tipos = "
    SELECT id, nombre
    FROM tipos_incidencia
    WHERE activo = 1
    ORDER BY nombre
";

$resultado_tipos = $conexion->query($sql_tipos);

/*
Consulta para cargar las incidencias recientes.
Se relaciona incidencias con tipo, estado, prioridad, barrio e imagen principal.
*/
if ($tipo_seleccionado > 0) {
    $sql_incidencias = "
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
            img.ruta AS imagen
        FROM incidencias i
        INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
        INNER JOIN estados_incidencia e ON i.estado_id = e.id
        INNER JOIN prioridades p ON i.prioridad_id = p.id
        LEFT JOIN barrios b ON i.barrio_id = b.id
        LEFT JOIN imagenes_incidencia img 
            ON img.incidencia_id = i.id AND img.es_principal = 1
        WHERE i.visible_publicamente = 1
        AND i.tipo_id = ?
        ORDER BY i.created_at DESC
        LIMIT 6
    ";

    $stmt = $conexion->prepare($sql_incidencias);
    $stmt->bind_param("i", $tipo_seleccionado);
    $stmt->execute();
    $resultado_incidencias = $stmt->get_result();

} else {
    $sql_incidencias = "
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
            img.ruta AS imagen
        FROM incidencias i
        INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
        INNER JOIN estados_incidencia e ON i.estado_id = e.id
        INNER JOIN prioridades p ON i.prioridad_id = p.id
        LEFT JOIN barrios b ON i.barrio_id = b.id
        LEFT JOIN imagenes_incidencia img 
            ON img.incidencia_id = i.id AND img.es_principal = 1
        WHERE i.visible_publicamente = 1
        ORDER BY i.created_at DESC
        LIMIT 6
    ";

    $resultado_incidencias = $conexion->query($sql_incidencias);
}

/*
Función para elegir el color de la etiqueta según el estado.
*/
function clase_estado($estado) {
    if ($estado === 'Pendiente') {
        return 'bg-secondary';
    } elseif ($estado === 'Validada') {
        return 'bg-info text-dark';
    } elseif ($estado === 'En proceso') {
        return 'bg-warning text-dark';
    } elseif ($estado === 'Solucionado') {
        return 'bg-success';
    } elseif ($estado === 'Rechazada') {
        return 'bg-danger';
    }

    return 'bg-secondary';
}

/*
Función para elegir el borde de la tarjeta según el estado.
*/
function clase_borde($estado) {
    if ($estado === 'Pendiente') {
        return 'border-secondary';
    } elseif ($estado === 'Validada') {
        return 'border-info';
    } elseif ($estado === 'En proceso') {
        return 'border-warning';
    } elseif ($estado === 'Solucionado') {
        return 'border-success';
    } elseif ($estado === 'Rechazada') {
        return 'border-danger';
    }

    return 'border-secondary';
}
?>

<?php include('includes/header.php'); ?>

<div class="container my-4">
    <div class="row">

        <!-- MENÚ LATERAL -->
        <aside class="col-md-3 mb-4">
            <div class="list-group shadow-sm">
                <h5 class="list-group-item list-group-item-dark mb-0">Categorías</h5>

                <a href="index.php"
                   class="list-group-item list-group-item-action <?php echo ($tipo_seleccionado === 0) ? 'active' : ''; ?>">
                    📍 Todas
                </a>

                <?php if ($resultado_tipos && $resultado_tipos->num_rows > 0): ?>
                    <?php while ($tipo = $resultado_tipos->fetch_assoc()): ?>
                        <a href="index.php?tipo_id=<?php echo $tipo['id']; ?>"
                           class="list-group-item list-group-item-action <?php echo ($tipo_seleccionado === (int)$tipo['id']) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($tipo['nombre']); ?>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </aside>

        <!-- ZONA CENTRAL DE CONTENIDO -->
        <main class="col-md-9">
            <h2 class="mb-4">Estado de Incidencias Recientes</h2>

            <p class="text-muted">
                Consulta las últimas incidencias urbanas registradas por la ciudadanía y su estado actual.
            </p>

            <?php if (isset($_GET['creada']) && $_GET['creada'] === 'ok'): ?>
                <div class="alert alert-success">
                    La incidencia se ha registrado correctamente.
                </div>
            <?php endif; ?>

            <?php if ($resultado_incidencias && $resultado_incidencias->num_rows > 0): ?>

                <div class="row row-cols-1 g-4">

                    <?php while ($incidencia = $resultado_incidencias->fetch_assoc()): ?>

                        <div class="col">
                            <div class="card h-100 shadow-sm <?php echo clase_borde($incidencia['estado']); ?>">

                                <?php if (!empty($incidencia['imagen'])): ?>
                                    <img src="<?php echo htmlspecialchars($incidencia['imagen']); ?>"
                                         class="card-img-top"
                                         alt="Imagen de la incidencia">
                                <?php endif; ?>

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title">
                                            <?php echo htmlspecialchars($incidencia['titulo']); ?>
                                        </h5>

                                        <span class="badge <?php echo clase_estado($incidencia['estado']); ?>">
                                            <?php echo htmlspecialchars($incidencia['estado']); ?>
                                        </span>
                                    </div>

                                    <p class="card-text">
                                        <?php echo htmlspecialchars($incidencia['descripcion']); ?>
                                    </p>

                                    <p class="card-text text-muted mb-1">
                                        <strong>Tipo:</strong>
                                        <?php echo htmlspecialchars($incidencia['tipo']); ?>
                                    </p>

                                    <p class="card-text text-muted mb-1">
                                        <strong>Prioridad:</strong>
                                        <?php echo htmlspecialchars($incidencia['prioridad']); ?>
                                    </p>

                                    <?php if (!empty($incidencia['barrio'])): ?>
                                        <p class="card-text text-muted mb-1">
                                            <strong>Barrio:</strong>
                                            <?php echo htmlspecialchars($incidencia['barrio']); ?>
                                        </p>
                                    <?php endif; ?>

                                    <p class="card-text text-muted mb-1">
                                        📍 <?php echo htmlspecialchars($incidencia['direccion']); ?>
                                    </p>

                                    <p class="card-text text-muted">
                                        <strong>Fecha:</strong>
                                        <?php echo date('d/m/Y', strtotime($incidencia['fecha_incidencia'])); ?>
                                    </p>

                                    <a href="detalle.php?id=<?php echo $incidencia['id']; ?>"
                                       class="btn btn-outline-primary btn-sm">
                                        Ver detalle
                                    </a>

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

        </main>

    </div>
</div>

<?php include('includes/footer.php'); ?>