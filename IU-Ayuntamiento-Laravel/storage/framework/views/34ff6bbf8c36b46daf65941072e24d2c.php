<?php $__env->startSection('title', 'Incidencias'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="mb-4">Listado Público de Incidencias</h2>

    <div class="row row-cols-1 g-4">
        <?php $__empty_1 = true; $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><?php echo e($incidencia->titulo); ?></h5>

                                <p class="card-text text-muted mb-1">
                                    📍 <?php echo e($incidencia->direccion); ?>

                                </p>

                                <?php if($incidencia->barrio): ?>
                                    <p class="card-text text-muted mb-1">
                                        <strong>Barrio:</strong> <?php echo e($incidencia->barrio->nombre); ?>

                                    </p>
                                <?php endif; ?>

                                <?php if($incidencia->codigo_postal): ?>
                                    <p class="card-text text-muted mb-1">
                                        <strong>Código postal:</strong> <?php echo e($incidencia->codigo_postal); ?>

                                    </p>
                                <?php endif; ?>

                                <p class="card-text mt-2">
                                    <?php echo e($incidencia->descripcion); ?>

                                </p>

                                <p class="card-text">
                                    <strong>Categoría:</strong> <?php echo e($incidencia->tipo->nombre); ?>

                                </p>

                                <?php if($incidencia->fecha_incidencia): ?>
                                    <p class="card-text">
                                        <strong>Fecha de la incidencia:</strong>
                                        <?php echo e(\Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('d/m/Y')); ?>

                                    </p>
                                <?php endif; ?>

                                <a href="<?php echo e(route('incidencias.show', $incidencia)); ?>" class="btn btn-outline-primary btn-sm">
                                    Ver detalle
                                </a>
                            </div>

                            <span class="badge bg-warning text-dark">
                                <?php echo e($incidencia->estado->nombre); ?>

                            </span>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No hay incidencias registradas.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aitor\OneDrive\Escritorio\IU-Ayuntamiento-Laravel\IU-Ayuntamiento-Laravel\resources\views/incidencias/index.blade.php ENDPATH**/ ?>