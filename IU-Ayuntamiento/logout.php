<?php
// Para borrar la cookie ponemos la fecha la hora de antes
setcookie("usuario", "", time() - 3600, "/");

// Redirigimos al usuario a la página de inicio
header("Location: index.php");
exit();
?>