<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">

    <aside class="col-md-3 mb-4">
        <div class="list-group shadow-sm">
            <h5 class="list-group-item list-group-item-dark mb-0">Categorías</h5>
            <a href="<?php echo e(route('incidencias.index')); ?>" class="list-group-item list-group-item-action">📍 Todas</a>

            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('incidencias.index')); ?>" class="list-group-item list-group-item-action">
                    <?php echo e($categoria->nombre); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </aside>

    <section class="col-md-9">
    <div class="jumbotron-custom">
        <h2>Servicio de Atención Ciudadana</h2>
        <p>Colabora con el Ayuntamiento para mantener una Granada limpia, segura y cuidada.</p>
    </div>

        <h2 class="mb-4">Estado de Incidencias Recientes</h2>
        <div class="row row-cols-1 g-4">
            <?php $__empty_1 = true; $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><?php echo e($incidencia->titulo); ?></h5>
                                <span class="badge bg-warning text-dark"><?php echo e($incidencia->estado->nombre); ?></span>
                            </div>

                            <p class="card-text text-muted">📍 <?php echo e($incidencia->direccion); ?></p>
                            <p class="card-text">
                                <strong>Categoría:</strong> <?php echo e($incidencia->tipo->nombre); ?>

                            </p>

                            <a href="<?php echo e(route('incidencias.show', $incidencia)); ?>" class="btn btn-outline-primary btn-sm">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No hay incidencias registradas.</p>
            <?php endif; ?>
        </div>
    </section>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aitor\OneDrive\Escritorio\IU-Ayuntamiento-Laravel\IU-Ayuntamiento-Laravel\resources\views/home.blade.php ENDPATH**/ ?>