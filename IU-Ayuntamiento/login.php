<?php
require_once 'includes/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === '' || $password === '') {
        $errores[] = "Debes introducir correo y contraseña.";
    } else {
        $sql = "
            SELECT usuarios.id, usuarios.nombre, usuarios.apellidos, usuarios.email, usuarios.password, roles.nombre AS rol
            FROM usuarios
            INNER JOIN roles ON usuarios.rol_id = roles.id
            WHERE usuarios.email = ? AND usuarios.activo = 1
        ";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario'] = $usuario['nombre'] . " " . $usuario['apellidos'];
                $_SESSION['rol'] = $usuario['rol'];

                if ($_SESSION['rol'] === 'tecnico') {
                    header("Location: panel_tecnico.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            }
        } else {
            $errores[] = "No existe ningún usuario activo con ese correo.";
        }
    }
}

include 'includes/header.php';
?>

<h2>Iniciar sesión</h2>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
    <div class="alert alert-success">
        Registro completado correctamente. Ya puedes iniciar sesión.
    </div>
<?php endif; ?>

<?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errores as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="login.php" method="post">

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico:</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Entrar</button>

</form>

<p class="mt-3">
    ¿No tienes cuenta?
    <a href="register.php">Regístrate aquí</a>
</p>

<?php include 'includes/footer.php'; ?>