<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="estilos.css">
</head>

<body>
  <header class="container py-4">
    <h1 class="text-center">Mi blog</h1>
  </header>

  <nav class="navbar navbar-expand-md bg-body-tertiary border-top border-bottom">
    <div class="container">
      <a class="navbar-brand" href="index.php">Mi Blog</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav ms-auto">  <!-- Esto después hay que ir cambiándolo en función de cada cosa -->
          <li class="nav-item"><a class="nav-link" href="contacto.php">Área de Usuario</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="sobremi.php">Vista Pública</a></li> -->
        </ul>
      </div>
    </div>
  </nav>