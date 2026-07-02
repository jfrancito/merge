<table id="<?php echo e($id); ?>" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>FOLIO</th>
      <th>PERIODO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>CENTRO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
        <td><?php echo e($item->FOLIO); ?></td>
        <td><?php echo e($item->TXT_PERIODO); ?></td>
        <td><?php echo e($item->TXT_GLOSA); ?></td>
        <td><?php echo e($item->CAN_FOLIO); ?></td>
        <td><?php echo e($item->TXT_CENTRO); ?></td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-planilla-movilidad-contabilidad-revisadas/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                  Revisar Planilla Movilidad
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>