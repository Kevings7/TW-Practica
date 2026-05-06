<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Incidencias - Ayuntamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .autor-p { font-weight: bold; color: #555; }
        body { display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1; }
    </style>
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
                    if (isset($_COOKIE['usuario'])) {
                        echo "<span class='navbar-text me-3'>" . $_COOKIE['usuario'] . " </span>";
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