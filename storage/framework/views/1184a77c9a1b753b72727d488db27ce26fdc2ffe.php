<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th class="ocultar">ID</th>
      <th>PLANILLA MOVILIDAD</th> 
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $planillamovilidad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="ocultar">
          <?php echo e($index+1); ?>

        </td>

        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>ID : </b> <?php echo e($item->ID_DOCUMENTO); ?></span>
          <span style="display: block;"><b>DOCUMENTO : </b> <?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></span>
          <span style="display: block;"><b>TOTAL : </b> <?php echo e($item->TOTAL); ?></span>
          <span style="display: block;"><b>FECHA EMISION : <?php echo e(date_format(date_create($item->FECHA_EMI), 'd/m/Y')); ?></b></span>
          <span style="display: block;"><b>FECHA CREACION : <?php echo e(date_format(date_create($item->FECHA_CREA), 'd/m/Y')); ?></b></span>
          <span style="display: block;"><b>PERIODO : </b> <?php echo e($item->TXT_PERIODO); ?></span>
          <span style="display: block;"><b>TRABAJADOR : </b> <?php echo e($item->TXT_TRABAJADOR); ?></span>
          <span style="display: block;"><b>CENTRO : </b> <?php echo e($item->TXT_CENTRO); ?></span>
          <span><b>ESTADO : </b> <?php echo $__env->make('planillamovilidad.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></span>

          <a href="<?php echo e(url('/modificar-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" 
            style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>

          <?php if($item->COD_ESTADO != 'ETM0000000000001'): ?>
            <a href="<?php echo e(url('/pdf-planilla-movilidad/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" 
              style="color:#cb2027;font-size: 35px;position: absolute; top: 10px;right: 20px;"
             target="_blank"><i class="mdi mdi-collection-pdf"></i>
            </a>
          <?php endif; ?>

          <?php if($item->COD_ESTADO == 'ETM0000000000001'): ?>
            <form method="POST" id='forextornar' action="<?php echo e(url('/extonar-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

                  <button type= 'button' style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-pm">EXTORNAR</button>
            </form>
          <?php endif; ?>


        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>
