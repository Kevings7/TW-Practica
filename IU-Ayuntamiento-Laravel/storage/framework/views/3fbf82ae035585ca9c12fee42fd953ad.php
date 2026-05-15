<?php $__env->startSection('title', 'Reportar incidencia'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="mb-4">Reportar nueva incidencia</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Hay errores en el formulario.</strong>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('incidencias.store')); ?>" method="POST" enctype="multipart/form-data" class="card card-body shadow-sm">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título de la incidencia</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo e(old('titulo')); ?>" required>
            <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required><?php echo e(old('descripcion')); ?></textarea>
            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="tipo_incidencia_id" class="form-label">Tipo de incidencia</label>
            <select name="tipo_incidencia_id" id="tipo_incidencia_id" class="form-select" required>
                <option value="">Seleccione un tipo</option>

                <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tipo->id); ?>" <?php if(old('tipo_incidencia_id') == $tipo->id): echo 'selected'; endif; ?>>
                        <?php echo e($tipo->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['tipo_incidencia_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="barrio_id" class="form-label">Barrio o zona</label>
            <select name="barrio_id" id="barrio_id" class="form-select" required>
                <option value="">Seleccione un barrio</option>

                <?php $__currentLoopData = $barrios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barrio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($barrio->id); ?>" <?php if(old('barrio_id') == $barrio->id): echo 'selected'; endif; ?>>
                        <?php echo e($barrio->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['barrio_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo e(old('direccion')); ?>" required>
            <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="codigo_postal" class="form-label">Código postal</label>
            <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" value="<?php echo e(old('codigo_postal')); ?>" pattern="[0-9]{5}" required>
            <?php $__errorArgs = ['codigo_postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="fecha_incidencia" class="form-label">Fecha de la incidencia</label>
            <input type="date" name="fecha_incidencia" id="fecha_incidencia" class="form-control" value="<?php echo e(old('fecha_incidencia')); ?>" required>
            <?php $__errorArgs = ['fecha_incidencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Fotografía de la incidencia</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/jpeg,image/png,image/webp" required>
            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn btn-primary">
            Enviar incidencia
        </button>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aitor\OneDrive\Escritorio\IU-Ayuntamiento-Laravel\IU-Ayuntamiento-Laravel\resources\views/incidencias/create.blade.php ENDPATH**/ ?>