<div class="table-responsive">
  <table id="<?php echo e($id); ?>"
         class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla"
         style="width:100%">
    <thead>
      <tr>
        <th>ITEM</th>
        <th>NRO PLANILLA</th>
        <th>FECHA EMISION PLANILLA</th>
        <th>TRABAJADOR</th>
        <th>AREA</th>
        <th>CARGO</th>
        <th>CORREO TRABAJADOR</th>
        <th>JEFE NOMBRE</th>
        <th>JEFE CORREO</th>
        <th>PERIODO</th>
        <th>TOTAL</th>
        <th>NRO FOLIO</th>
        <th>ID LIQUIDACION</th>
        <th>ESTADO LIQUIDACION</th>
        <th>ESTADO CONSOLIDADO</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><?php echo e($index + 1); ?></td>
          <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
          <td><?php echo e($item->FECHA_EMI); ?></td>
          <td><?php echo e($item->TXT_TRABAJADOR); ?></td>
          <td><?php echo e($item->TXT_AREA); ?></td>
          <td><?php echo e($item->cadcargo); ?></td>
          <td><?php echo e($item->emailcorp); ?></td>
          <td><?php echo e($item->TXT_USUARIO_AUTORIZA); ?></td>
          <td><?php echo e($item->email_jefe); ?></td>
          <td><?php echo e($item->TXT_PERIODO); ?></td>
          <td><?php echo e($item->TOTAL); ?></td>
          <td><?php echo e($item->SERIEFOLIO); ?> - <?php echo e($item->NUMEROFOLIO); ?></td>
          <td><?php echo e($item->ID_DOCUMENTO); ?></td>
          <td><?php echo e($item->TXT_ESTADO); ?></td>
          <td><?php echo e($item->TXT_ESTADO_CONSOLIDADO); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</div>
