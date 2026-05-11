<?php
require_once 'includes/conexion.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

$sql = "
    SELECT 
        i.id,
        i.titulo,
        i.descripcion,
        i.direccion,
        i.codigo_postal,
        i.fecha_incidencia,
        i.fecha_resolucion,
        t.nombre AS tipo,
        e.nombre AS estado,
        p.nombre AS prioridad,
        b.nombre AS barrio,
        u.nombre AS usuario_nombre,
        u.apellidos AS usuario_apellidos,
        img.ruta AS imagen
    FROM incidencias i
    INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
    INNER JOIN estados_incidencia e ON i.estado_id = e.id
    INNER JOIN prioridades p ON i.prioridad_id = p.id
    LEFT JOIN barrios b ON i.barrio_id = b.id
    INNER JOIN usuarios u ON i.usuario_id = u.id
    LEFT JOIN imagenes_incidencia img 
        ON img.incidencia_id = i.id AND img.es_principal = 1
    WHERE i.id = ?
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$incidencia = $resultado->fetch_assoc();

include 'includes/header.php';
?>

<div class="container my-4">

    <h2 class="mb-4"><?php echo htmlspecialchars($incidencia['titulo']); ?></h2>

    <div class="card shadow-sm">

        <?php if (!empty($incidencia['imagen'])): ?>
            <img src="<?php echo htmlspecialchars($incidencia['imagen']); ?>"
                 class="card-img-top"
                 alt="Imagen de la incidencia">
        <?php endif; ?>

        <div class="card-body">

            <p>
                <strong>Descripción:</strong>
                <?php echo htmlspecialchars($incidencia['descripcion']); ?>
            </p>

            <p>
                <strong>Tipo:</strong>
                <?php echo htmlspecialchars($incidencia['tipo']); ?>
            </p>

            <p>
                <strong>Estado:</strong>
                <?php echo htmlspecialchars($incidencia['estado']); ?>
            </p>

            <p>
                <strong>Prioridad:</strong>
                <?php echo htmlspecialchars($incidencia['prioridad']); ?>
            </p>

            <p>
                <strong>Barrio:</strong>
                <?php echo htmlspecialchars($incidencia['barrio']); ?>
            </p>

            <p>
                <strong>Dirección:</strong>
                <?php echo htmlspecialchars($incidencia['direccion']); ?>
            </p>

            <p>
                <strong>Código postal:</strong>
                <?php echo htmlspecialchars($incidencia['codigo_postal']); ?>
            </p>

            <p>
                <strong>Fecha de la incidencia:</strong>
                <?php echo date('d/m/Y', strtotime($incidencia['fecha_incidencia'])); ?>
            </p>

            <?php if (!empty($incidencia['fecha_resolucion'])): ?>
                <p>
                    <strong>Fecha de resolución:</strong>
                    <?php echo date('d/m/Y', strtotime($incidencia['fecha_resolucion'])); ?>
                </p>
            <?php endif; ?>

            <p>
                <strong>Registrada por:</strong>
                <?php echo htmlspecialchars($incidencia['usuario_nombre'] . ' ' . $incidencia['usuario_apellidos']); ?>
            </p>

            <a href="index.php" class="btn btn-secondary">Volver al inicio</a>

        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
