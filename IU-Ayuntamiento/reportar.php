<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=necesita_login");
    exit();
}

require_once 'includes/conexion.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_SESSION['usuario_id'];
    $tipo_id = $_POST['tipo_id'];
    $barrio_id = $_POST['barrio_id'];
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $direccion = trim($_POST['direccion']);
    $codigo_postal = trim($_POST['codigo_postal']);
    $fecha_incidencia = $_POST['fecha_incidencia'];

    // Valores por defecto
    $estado_id = 1;      // Pendiente
    $prioridad_id = 2;   // Media

    if ($titulo === '' || $descripcion === '' || $direccion === '' || $codigo_postal === '' || $fecha_incidencia === '') {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!preg_match('/^[0-9]{5}$/', $codigo_postal)) {
        $errores[] = "El código postal debe tener 5 números.";
    }

    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $errores[] = "Debes subir una imagen válida.";
    }

    if (empty($errores)) {
        $nombre_original = $_FILES['imagen']['name'];
        $tipo_mime = $_FILES['imagen']['type'];
        $tamano = $_FILES['imagen']['size'];
        $ruta_temporal = $_FILES['imagen']['tmp_name'];

        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($tipo_mime, $tipos_permitidos)) {
            $errores[] = "La imagen debe ser JPG, PNG o WEBP.";
        }

        if ($tamano > 2 * 1024 * 1024) {
            $errores[] = "La imagen no puede superar los 2 MB.";
        }
    }

    if (empty($errores)) {

        $sql = "
            INSERT INTO incidencias (
                usuario_id, tipo_id, estado_id, prioridad_id, barrio_id,
                titulo, descripcion, direccion, codigo_postal,
                fecha_incidencia, visible_publicamente
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "iiiiisssss",
            $usuario_id,
            $tipo_id,
            $estado_id,
            $prioridad_id,
            $barrio_id,
            $titulo,
            $descripcion,
            $direccion,
            $codigo_postal,
            $fecha_incidencia
        );

        if ($stmt->execute()) {
            $incidencia_id = $conexion->insert_id;

            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nombre_guardado = "incidencia_" . $incidencia_id . "_" . time() . "." . $extension;
            $ruta_destino = "uploads/incidencias/" . $nombre_guardado;

            if (move_uploaded_file($ruta_temporal, $ruta_destino)) {

                $sql_imagen = "
                    INSERT INTO imagenes_incidencia (
                        incidencia_id, ruta, nombre_original, tipo_mime, tamano, es_principal
                    )
                    VALUES (?, ?, ?, ?, ?, 1)
                ";

                $stmt_img = $conexion->prepare($sql_imagen);
                $stmt_img->bind_param(
                    "isssi",
                    $incidencia_id,
                    $ruta_destino,
                    $nombre_original,
                    $tipo_mime,
                    $tamano
                );

                $stmt_img->execute();

                $sql_historial = "
                    INSERT INTO historial_estados (
                        incidencia_id, estado_anterior_id, estado_nuevo_id, usuario_id, comentario
                    )
                    VALUES (?, NULL, ?, ?, 'Incidencia registrada por el ciudadano.')
                ";

                $stmt_historial = $conexion->prepare($sql_historial);
                $stmt_historial->bind_param("iii", $incidencia_id, $estado_id, $usuario_id);
                $stmt_historial->execute();

                header("Location: incidencias.php?creada=ok");
                exit();

            } else {
                $errores[] = "La incidencia se ha creado, pero no se pudo guardar la imagen.";
            }

        } else {
            $errores[] = "Error al guardar la incidencia.";
        }
    }
}

$sql_tipos = "SELECT id, nombre FROM tipos_incidencia WHERE activo = 1 ORDER BY nombre";
$resultado_tipos = $conexion->query($sql_tipos);

$sql_barrios = "SELECT id, nombre FROM barrios ORDER BY nombre";
$resultado_barrios = $conexion->query($sql_barrios);

include 'includes/header.php';
?>

<h2 class="mb-4">Reportar una incidencia</h2>

<p>
    Utiliza este formulario para comunicar al Ayuntamiento una incidencia urbana.
    Todos los campos son obligatorios.
</p>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errores as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="reportar.php" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="titulo" class="form-label">Título de la incidencia</label>
        <input type="text" id="titulo" name="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label for="tipo_id" class="form-label">Tipo de incidencia</label>
        <select id="tipo_id" name="tipo_id" class="form-select" required>
            <option value="">Seleccione un tipo</option>

            <?php while ($tipo = $resultado_tipos->fetch_assoc()): ?>
                <option value="<?php echo $tipo['id']; ?>">
                    <?php echo htmlspecialchars($tipo['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>
    </div>

    <div class="mb-3">
        <label for="barrio_id" class="form-label">Barrio o zona</label>
        <select id="barrio_id" name="barrio_id" class="form-select" required>
            <option value="">Seleccione un barrio</option>

            <?php while ($barrio = $resultado_barrios->fetch_assoc()): ?>
                <option value="<?php echo $barrio['id']; ?>">
                    <?php echo htmlspecialchars($barrio['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>
    </div>

    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" id="direccion" name="direccion" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="codigo_postal" class="form-label">Código postal</label>
        <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" pattern="[0-9]{5}" required>
    </div>

    <div class="mb-3">
        <label for="fecha_incidencia" class="form-label">Fecha de la incidencia</label>
        <input type="date" id="fecha_incidencia" name="fecha_incidencia" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="imagen" class="form-label">Fotografía de la incidencia</label>
        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/jpeg,image/png,image/webp" required>
    </div>

    <button type="submit" class="btn btn-primary">Enviar incidencia</button>

</form>

<?php include 'includes/footer.php'; ?>