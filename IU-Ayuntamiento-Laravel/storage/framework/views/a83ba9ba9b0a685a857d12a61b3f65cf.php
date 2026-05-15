<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Gestión de Incidencias - Ayuntamiento'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/estilos.css')); ?>">
</head>
<body>

<header class="container py-4">
    <h1 class="text-center">Gestión de Incidencias Urbanas</h1>

    <nav class="navbar navbar-expand-md bg-body-tertiary border-top border-bottom">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">Vista Pública</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('incidencias.index')); ?>">Incidencias</a>
                </li>

                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('incidencias.create')); ?>">Reportar Incidencia</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('incidencias.mine')); ?>">Mis incidencias</a>
                    </li>

                    <?php if(auth()->user()->esTecnico()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('tecnico.panel')); ?>">Panel Técnico</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('contacto')); ?>">Contacto</a>
                </li>
            </ul>

            <div class="navbar-nav ms-auto align-items-center">
                <?php if(auth()->guard()->guest()): ?>
                    <span class="navbar-text me-3">Usuario no identificado</span>
                    <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                    <a class="nav-link" href="<?php echo e(route('register')); ?>">Registro</a>
                <?php else: ?>
                    <span class="navbar-text me-3">
                        <?php echo e(auth()->user()->name); ?> - <?php echo e(auth()->user()->role->nombre); ?>

                    </span>

                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-outline-danger btn-sm" type="submit">Cerrar sesión</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<main class="container my-4">
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="container text-center py-4 border-top">
    <p>&copy; 2026 - Grupo 6</p>
    <p>
        <a href="<?php echo e(route('contacto')); ?>">Contacto</a>
        |
        <a href="<?php echo e(asset('como_se_hizo.pdf')); ?>" target="_blank">como_se_hizo.pdf</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html><?php /**PATH C:\Users\aitor\OneDrive\Escritorio\IU-Ayuntamiento-Laravel\IU-Ayuntamiento-Laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>