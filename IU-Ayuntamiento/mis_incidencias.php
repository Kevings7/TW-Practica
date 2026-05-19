<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=necesita_login");
    exit();
}

require_once 'includes/conexion.php';

$usuario_id = $_SESSION['usuario_id'];

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
        img.ruta AS imagen
    FROM incidencias i
    INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
    INNER JOIN estados_incidencia e ON i.estado_id = e.id
    INNER JOIN prioridades p ON i.prioridad_id = p.id
    LEFT JOIN barrios b ON i.barrio_id = b.id
    LEFT JOIN imagenes_incidencia img 
        ON img.incidencia_id = i.id AND img.es_principal = 1
    WHERE i.usuario_id = ?
    ORDER BY i.created_at DESC
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

include 'includes/header.php';
?>

<div class="container my-4">

    <h2 class="mb-4">Mis incidencias</h2>

    <p class="text-muted">
        Aquí puedes consultar las incidencias que has registrado y comprobar su estado actual.
    </p>

    <?php if ($resultado && $resultado->num_rows > 0): ?>

        <div class="row row-cols-1 g-4">

            <?php while ($incidencia = $resultado->fetch_assoc()): ?>

                <div class="col">
                    <div class="card shadow-sm">

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

                                <span class="badge bg-secondary">
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

                            <p class="card-text text-muted mb-1">
                                <strong>Barrio:</strong>
                                <?php echo htmlspecialchars($incidencia['barrio']); ?>
                            </p>

                            <p class="card-text text-muted mb-1">
                                <strong>Dirección:</strong>
                                <?php echo htmlspecialchars($incidencia['direccion']); ?>
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
            Todavía no has registrado ninguna incidencia.
        </div>

    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
