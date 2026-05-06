<?php
session_start();
// Borra las variables de sesión
session_unset();
// Destruye toda la sesión
session_destroy();

// Redirigimos al usuario a la página de inicio
header("Location: index.php");
exit();
?>