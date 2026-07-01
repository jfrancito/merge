<table id="<?php echo e($id); ?>" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla"  style="width:100% !important">
  <thead>

    <tr>
      <th></th>
      <th colspan="4" style="background: #eee; text-align:center;">DATOS DE LA FACTURA</th>
      <th colspan="4" style="background: #efe; text-align:center;">ESTIBA</th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    <tr>
      <th>ITEM</th>
      <th>FECHA EMISION</th>
      <th>PROVEEDOR</th>
      <th>NRO CPE</th>
      <th>TOTAL</th>

      <th>FECHA EMISION</th>
      <th>CODIGO</th>
      <th>COND. PAGO</th>
      <th>USUARIO CONTACTO</th>

      <th>TIEMPO AT.</th>
      <th>CAJA CHICA.</th>

      <th>REVISION</th>
    </tr>

  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">

        <td><?php echo e($index+1); ?></td>

        <td><?php echo e(date_format(date_create($item->FEC_VENTA), 'd-m-Y')); ?></td>
        <td><?php echo e($item->RZ_PROVEEDOR); ?></td>
        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
        <td><?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></td>

        <td><?php echo e(date_format(date_create($item->FEC_EMISION), 'd-m-Y')); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e($item->FORMA_PAGO); ?></td>
        <td><?php echo e($item->TXT_CONTACTO_UC); ?></td>


        <td><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></td>
        <td>              
          <?php if($item->TXT_A_TIEMPO == 'CAJA_SI'): ?> 
            <span class="badge badge-success" style="display: inline-block;"><?php echo e($item->TXT_A_TIEMPO); ?></span>
          <?php else: ?>
            <span class="badge badge-default" style="display: inline-block;"><?php echo e($item->TXT_A_TIEMPO); ?></span>
          <?php endif; ?>
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-comprobante-contabilidad-estiba-dic/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">
                  Revision Comprobante
                </a>  
              </li>

            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>