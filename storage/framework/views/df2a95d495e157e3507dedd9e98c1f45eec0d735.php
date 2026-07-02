<table id="<?php echo e($id); ?>" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>CODIGO</th>
      <th>CUENTA</th>
      <th>FECHA EMISION</th>

      <th>PERIODO</th>
      <th>TOTAL</th>
      <th>TRABAJADOR</th>
      <th>CENTRO</th>
      <th>AUTORIZA</th>
      <th>MONEDA</th>

      <th>TIPO VALE</th>
      <th>VALE</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index+1); ?></td>
        <td><?php echo e($item->CODIGO); ?></td>
        <td><?php echo e($item->TXT_CUENTA); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_EMI), 'd/m/Y')); ?></td>
        <td><?php echo e($item->TXT_PERIODO); ?></td>
        <td><?php echo e($item->TOTAL); ?></td>
        <td><?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?></td>
        <td><?php echo e($item->TXT_CENTRO); ?></td>
        <td><?php echo e($item->TXT_USUARIO_AUTORIZA); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        
        <td><?php echo e($item->ARENDIR); ?></td>
        <td><?php echo e($item->ARENDIR_ID); ?></td>
        
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-liquidacion-gasto-administracion/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                  Revisar Liquidacion
                </a>  
              </li>

              <li>
                <a href="<?php echo e(url('/liquidacion-viaje-pdf/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" Target="_blank">
                  Liquidacion de viaje PDF
                </a>  
              </li>

            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>