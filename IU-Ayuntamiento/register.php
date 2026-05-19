<?php
require_once 'includes/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $telefono = trim($_POST['telefono']);

    if ($nombre === '' || $apellidos === '' || $email === '' || $password === '' || $telefono === '') {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no tiene un formato válido.";
    }

    if (empty($errores)) {
        $sql_comprobar = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($sql_comprobar);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $errores[] = "Ya existe un usuario registrado con ese correo.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql_insertar = "
                INSERT INTO usuarios (rol_id, nombre, apellidos, email, password, telefono)
                VALUES (1, ?, ?, ?, ?, ?)
            ";

            $stmt = $conexion->prepare($sql_insertar);
            $stmt->bind_param("sssss", $nombre, $apellidos, $email, $password_hash, $telefono);

            if ($stmt->execute()) {
                header("Location: login.php?registro=ok");
                exit();
            } else {
                $errores[] = "Error al registrar el usuario.";
            }
        }
    }
}

include 'includes/header.php';
?>

<h2>Registro de usuario</h2>

<p>
    Crea una cuenta para poder reportar incidencias urbanas y consultar el estado de tus avisos.
</p>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errores as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="register.php" method="post">

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Registrarse</button>

</form>

<?php include 'includes/footer.php'; ?>