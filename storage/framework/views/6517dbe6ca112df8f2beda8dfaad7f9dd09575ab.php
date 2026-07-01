<div class="form-group">
  <label class="col-sm-3 control-label">Cliente:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Orden:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($ordencompra->COD_ORDEN); ?>">
  </div>
</div>



<div class="form-group">
  <label class="col-sm-3 control-label">Archivos Faltantes:</label>
  <div class="col-sm-6">

    <?php $__currentLoopData = $documentoscompra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(!in_array($item->COD_CATEGORIA, $totalarchivos)): ?>
        <div class="be-checkbox">
          <input id="<?php echo e($item->COD_CATEGORIA); ?>" value="<?php echo e($item->COD_CATEGORIA); ?>"  type="checkbox" name="archivoob[]" >
          <label for="<?php echo e($item->COD_CATEGORIA); ?>"><?php echo e($item->NOM_CATEGORIA); ?> (<?php echo e($item->COD_CTBLE); ?>) 
            <?php if(in_array($item->COD_CATEGORIA, $totalarchivos)): ?> <span class="label label-success">registrado</span> 
            <?php endif; ?> 
          </label>
        </div>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </div>
</div>

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="<?php echo e(url('/gestion-de-orden-compra/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnobservar">Guardar</button>
    </p>
  </div>
</div>