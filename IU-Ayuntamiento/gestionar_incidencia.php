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

if (!isset($_GET['id'])) {
    header("Location: panel_tecnico.php");
    exit();
}

$incidencia_id = (int) $_GET['id'];
$tecnico_id = $_SESSION['usuario_id'];
$errores = [];

/*
Primero obtenemos la incidencia actual.
*/
$sql_incidencia = "
    SELECT 
        i.id,
        i.titulo,
        i.descripcion,
        i.direccion,
        i.estado_id,
        i.usuario_id,
        e.nombre AS estado_actual,
        t.nombre AS tipo,
        b.nombre AS barrio
    FROM incidencias i
    INNER JOIN estados_incidencia e ON i.estado_id = e.id
    INNER JOIN tipos_incidencia t ON i.tipo_id = t.id
    LEFT JOIN barrios b ON i.barrio_id = b.id
    WHERE i.id = ?
";

$stmt = $conexion->prepare($sql_incidencia);
$stmt->bind_param("i", $incidencia_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: panel_tecnico.php");
    exit();
}

$incidencia = $resultado->fetch_assoc();

/*
Si el técnico ha enviado el formulario, actualizamos el estado.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado_nuevo_id = (int) $_POST['estado_id'];
    $comentario = trim($_POST['comentario']);

    if ($estado_nuevo_id <= 0) {
        $errores[] = "Debes seleccionar un estado.";
    }

    if ($comentario === '') {
        $errores[] = "Debes escribir un comentario.";
    }

    if (empty($errores)) {

        $estado_anterior_id = $incidencia['estado_id'];

        /*
        Obtenemos el nombre del nuevo estado.
        */
        $sql_estado = "SELECT nombre FROM estados_incidencia WHERE id = ?";
        $stmt_estado = $conexion->prepare($sql_estado);
        $stmt_estado->bind_param("i", $estado_nuevo_id);
        $stmt_estado->execute();
        $resultado_estado = $stmt_estado->get_result();

        if ($resultado_estado->num_rows === 0) {
            $errores[] = "El estado seleccionado no existe.";
        } else {
            $estado_nuevo = $resultado_estado->fetch_assoc();
            $nombre_estado_nuevo = $estado_nuevo['nombre'];

            /*
            Si el nuevo estado es Solucionado, guardamos fecha de resolución.
            Si no, dejamos fecha_resolucion como NULL.
            */
            if ($nombre_estado_nuevo === 'Solucionado') {
                $sql_update = "
                    UPDATE incidencias
                    SET estado_id = ?, fecha_resolucion = CURDATE()
                    WHERE id = ?
                ";
            } else {
                $sql_update = "
                    UPDATE incidencias
                    SET estado_id = ?, fecha_resolucion = NULL
                    WHERE id = ?
                ";
            }

            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("ii", $estado_nuevo_id, $incidencia_id);

            if ($stmt_update->execute()) {

                /*
                Guardamos el cambio en el historial.
                */
                $sql_historial = "
                    INSERT INTO historial_estados (
                        incidencia_id,
                        estado_anterior_id,
                        estado_nuevo_id,
                        usuario_id,
                        comentario
                    )
                    VALUES (?, ?, ?, ?, ?)
                ";

                $stmt_historial = $conexion->prepare($sql_historial);
                $stmt_historial->bind_param(
                    "iiiis",
                    $incidencia_id,
                    $estado_anterior_id,
                    $estado_nuevo_id,
                    $tecnico_id,
                    $comentario
                );

                $stmt_historial->execute();

                /*
                Creamos una notificación para el ciudadano que creó la incidencia.
                */
                $titulo_notificacion = "Cambio de estado de incidencia";
                $mensaje_notificacion = "Tu incidencia \"" . $incidencia['titulo'] . "\" ha cambiado al estado: " . $nombre_estado_nuevo . ".";

                $sql_notificacion = "
                    INSERT INTO notificaciones (
                        usuario_id,
                        incidencia_id,
                        titulo,
                        mensaje,
                        leida
                    )
                    VALUES (?, ?, ?, ?, 0)
                ";

                $stmt_notificacion = $conexion->prepare($sql_notificacion);
                $stmt_notificacion->bind_param(
                    "iiss",
                    $incidencia['usuario_id'],
                    $incidencia_id,
                    $titulo_notificacion,
                    $mensaje_notificacion
                );

                $stmt_notificacion->execute();

                header("Location: panel_tecnico.php?estado=actualizado");
                exit();

            } else {
                $errores[] = "No se pudo actualizar el estado.";
            }
        }
    }
}

/*
Cargamos todos los estados disponibles para el select.
*/
$sql_estados = "
    SELECT id, nombre
    FROM estados_incidencia
    ORDER BY orden
";

$resultado_estados = $conexion->query($sql_estados);

include 'includes/header.php';
?>

<div class="container my-4">

    <h2 class="mb-4">Gestionar incidencia</h2>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errores as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">
                <?php echo htmlspecialchars($incidencia['titulo']); ?>
            </h5>

            <p>
                <strong>Descripción:</strong>
                <?php echo htmlspecialchars($incidencia['descripcion']); ?>
            </p>

            <p>
                <strong>Tipo:</strong>
                <?php echo htmlspecialchars($incidencia['tipo']); ?>
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
                <strong>Estado actual:</strong>
                <?php echo htmlspecialchars($incidencia['estado_actual']); ?>
            </p>
        </div>
    </div>

    <form action="gestionar_incidencia.php?id=<?php echo $incidencia_id; ?>" method="post">

        <div class="mb-3">
            <label for="estado_id" class="form-label">Nuevo estado</label>

            <select id="estado_id" name="estado_id" class="form-select" required">
                <option value="">Seleccione un estado</option>

                <?php while ($estado = $resultado_estados->fetch_assoc()): ?>
                    <option value="<?php echo $estado['id']; ?>"
                        <?php if ((int)$estado['id'] === (int)$incidencia['estado_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($estado['nombre']); ?>
                    </option>
                <?php endwhile; ?>

            </select>
        </div>

        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario del técnico</label>

            <textarea id="comentario"
                      name="comentario"
                      class="form-control"
                      rows="4"
                      required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar cambios
        </button>

        <a href="panel_tecnico.php" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

<?php include 'includes/footer.php'; ?>
