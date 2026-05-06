<?php
//Verificamos si ya existe la cookie para no repetir el proceso
if (isset($_COOKIE['usuario'])) {
    header('Location: index.php');
    exit();
}

//Solo procesamos si la petición viene por POST (al pulsar el botón del formulario)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    //Validación de seguridad: el nombre es obligatorio
    if (empty($_POST['name'])) {
        header("Location: contacto.php?error=vacio");
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
        
        header("Location: contacto.php?" . $parametros_url);
        exit();
    }

    // Preparamos el nombre completo para la sesión
    $fullname = trim($name . " " . $surname);

    // Creamos la cookie "usuario" que dura 1 hora
    // Esto hará que en el header.php aparezca el nombre del usuario
    setcookie("usuario", $fullname, time() + 3600, "/"); 

    // Redirigimos al inicio una vez identificado
    header("Location: index.php");
    exit();

} else {
    // Si alguien intenta entrar a register.php directamente por la URL, lo mandamos al inicio
    header("Location: index.php");
    exit();
}
?>