<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>NRO OC</th>
      <th>PROVEEDOR</th>
      <th>COMPROBANTE ASOCIADO</th>
      <th>FECHA VENCIMIENTO DOC</th>
      <th>FECHA APROBACION ADMIN</th>
      <th>TIPO</th>
      <th>SUBIO VOUCHER</th>
      <th>ORDEN INGRESO</th>
      <th>OBLIGACION</th>
      <th>DESCUENTO</th>
      <th>TOTAL DESCUENTO</th>
      <th>IMPORTE</th>
      <th>NETO A PAGAR</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->COD_DOCUMENTO_CTBLE); ?></td>
        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
        <td><?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?></td>
        <td><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></td>
        <td><?php echo e($item->IND_MATERIAL_SERVICIO); ?></td>
        <td>
            <?php if($item->COD_ESTADO_VOUCHER == 'ETM0000000000008'): ?>
              SI
            <?php else: ?>
              NO
            <?php endif; ?>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo e($item->CAN_TOTAL); ?></td>
        <td><b><?php echo e($item->CAN_TOTAL); ?></b></td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>


