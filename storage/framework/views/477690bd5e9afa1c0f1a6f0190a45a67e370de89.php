<table id="<?php echo e($id); ?>" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CONSTANCIA</th>
      <th>FECHA CADUCIDAD</th>
      <th>RUC</th>
      <th>PROVEEDOR</th>
      <th>NUMERO OPERACION</th>
      <th>OBSERVACION</th>
      <th>ESTADO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $lrentacuartacategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_CONSTANCIA), 'd-m-Y')); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_CADUCIDAD), 'd-m-Y')); ?></td>   
        <td><?php echo e($item->RUC); ?></td>
        <td><?php echo e($item->RAZON_SOCIAL); ?></td>
        <td><?php echo e($item->NUMERO_OPERACION); ?></td>
        <td><?php echo e($item->OBSERVACION); ?></td>
        <?php echo $__env->make('cuartacategoria.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-renta-cuarta-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                  Revisar Renta Cuarta
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>