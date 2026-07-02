<table id="<?php echo e($id); ?>" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID</th>
      <th>FECHA EMISION</th>
      <th>FECHA CREACION</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th>TRABAJADOR</th>
      <th>CENTRO</th>
      <th>MONEDA</th>
      <th>ESTADO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index+1); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_EMI), 'd/m/Y')); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_CREA), 'd/m/Y')); ?></td>
        <td><?php echo e($item->TXT_PERIODO); ?></td>
        <td><?php echo e($item->TOTAL); ?></td>
        <td><?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?></td>
        <td><?php echo e($item->TXT_CENTRO); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        <td><?php echo $__env->make('planillamovilidad.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-liquidacion-gasto-jefe-historial/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                  Revisar Liquidacion
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>