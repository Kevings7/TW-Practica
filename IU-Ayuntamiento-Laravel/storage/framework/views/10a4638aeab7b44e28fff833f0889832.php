<?php $__env->startSection('title', 'Panel técnico'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="mb-4">Panel técnico</h2>

    <?php if($incidencias->isEmpty()): ?>
        <p>No hay incidencias registradas.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Dirección</th>
                        <th>Barrio</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Estado actual</th>
                        <th>Cambiar estado</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('incidencias.show', $incidencia)); ?>">
                                    <?php echo e($incidencia->titulo); ?>

                                </a>
                            </td>

                            <td>
                                <?php echo e($incidencia->direccion); ?>


                                <?php if($incidencia->codigo_postal): ?>
                                    <br>
                                    <small class="text-muted">
                                        CP: <?php echo e($incidencia->codigo_postal); ?>

                                    </small>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($incidencia->barrio): ?>
                                    <?php echo e($incidencia->barrio->nombre); ?>

                                <?php else: ?>
                                    <span class="text-muted">Sin barrio</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php echo e($incidencia->tipo->nombre); ?>

                            </td>

                            <td>
                                <?php echo e($incidencia->usuario->name); ?> <?php echo e($incidencia->usuario->apellidos); ?>

                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    <?php echo e($incidencia->estado->nombre); ?>

                                </span>
                            </td>

                            <td>
                                <form action="<?php echo e(route('tecnico.estado', $incidencia)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>

                                    <div class="d-flex gap-2">
                                        <select name="estado_incidencia_id" class="form-select form-select-sm" required>
                                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($estado->id); ?>"
                                                    <?php if($incidencia->estado_incidencia_id == $estado->id): echo 'selected'; endif; ?>
                                                >
                                                    <?php echo e($estado->nombre); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aitor\OneDrive\Escritorio\IU-Ayuntamiento-Laravel\IU-Ayuntamiento-Laravel\resources\views/tecnico/panel.blade.php ENDPATH**/ ?>