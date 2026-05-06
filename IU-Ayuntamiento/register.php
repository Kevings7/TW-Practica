<?php
session_start();
//Comprobamos si el usuario ya está identificado usando $_SESSION
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

//Solo procesamos si la petición viene por POST (al pulsar el botón del formulario)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    //Validación de seguridad: el nombre es obligatorio
    if (empty($_POST['name'])) {
        header("Location: login.php?error=vacio");
        exit();
    }

    // Recogemos los datos del formulario
    $name = $_POST['name'];
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';

    // Validación del Checkbox (Requisito de tu ejemplo)[cite: 1]
    // Si no han marcado la casilla de politica devolvemos los datos a contacto.php
    if (!isset($_POST['novedades'])) {
        $parametros_url = http_build_query([
            'error' => 'falta_checkbox',
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'comentario' => $comentario
        ]);
        
        header("Location: login.php?" . $parametros_url);
        exit();
    }

    // Preparamos el nombre completo para la sesión
    $fullname = trim($name . " " . $surname);

    // Guardamos los datos en $_SESSION en lugar de usar cookies
    $_SESSION['usuario'] = $fullname;
    
    // Definimos el rol del usuario. En este caso simulamos que entra un usuario normal
    $_SESSION['rol'] = 'ciudadano';

    // Redirigimos al inicio una vez identificado
    header("Location: index.php");
    exit();

} else {
    // Si alguien intenta entrar a register.php directamente por la URL, lo mandamos al inicio
    header("Location: index.php");
    exit();
}
?>