<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Incidencias - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="container py-4">
        <h1 class="text-center">Gestión de Incidencias Urbanas</h1>
        
        <nav class="navbar navbar-expand-md bg-body-tertiary border-top border-bottom">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Vista Pública</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportar.php">Reportar Incidencia</a></li>
                </ul>

                <div class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo "<span class='navbar-text me-3'> Hola, <strong>" . htmlspecialchars($_SESSION['usuario']) . "</strong> (" . htmlspecialchars($_SESSION['rol']) . ")</span>";
                        echo "<a class='btn btn-outline-danger btn-sm' href='logout.php'>Cerrar Sesión</a>";
                    } else {
                        echo "<a class='btn btn-outline-primary btn-sm' href='login.php'>Inicia Sesión</a>";
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">