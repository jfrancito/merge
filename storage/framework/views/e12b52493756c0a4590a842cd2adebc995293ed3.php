<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>DETALLE DE PLANILLA MOVILIDAD</th> 
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $tdetplanillamovilidad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>FECHA GASTO : <?php echo e(date_format(date_create($item->FECHA_GASTO), 'd/m/Y')); ?></b></span>
          <span style="display: block;"><b>MOTIVO : </b> <?php echo e($item->TXT_MOTIVO); ?></span>
          <span style="display: block;"><b>LUGAR PARTIDA : </b> <?php echo e($item->TXT_LUGARPARTIDA); ?> - <?php echo e($item->TXT_DEPARTAMENTO_PARTIDA); ?> - <?php echo e($item->TXT_PROVINCIA_PARTIDA); ?> - <?php echo e($item->TXT_DISTRITO_PARTIDA); ?></span>
          <span style="display: block;"><b>LUGAR DE LLEGADA : </b> <?php echo e($item->TXT_LUGARLLEGADA); ?> - <?php echo e($item->TXT_DEPARTAMENTO_LLEGADA); ?> - <?php echo e($item->TXT_PROVINCIA_LLEGADA); ?> - <?php echo e($item->TXT_DISTRITO_LLEGADA); ?></span>
          <span style="display: block;"><b>TOTAL : </b > <b style="font-size: 20px;"><?php echo e(number_format($item->TOTAL, 2, '.', ',')); ?></b></span>
          <button type="button" data_iddocumento = "<?php echo e($item->ID_DOCUMENTO); ?>" data_item = "<?php echo e($item->ITEM); ?>" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm modificardetallepm">MODIFICAR</button>
        </td>
      </tr>                 
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>


