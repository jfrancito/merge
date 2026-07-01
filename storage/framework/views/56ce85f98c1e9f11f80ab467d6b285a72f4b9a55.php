<table id="tdpm" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th class="ocultar">ID</th> 
      <th>LIQUIDACION GASTO</th> 
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listacabecera; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="ocultar"><?php echo e($index + 1); ?></td>
        <td class="cell-detail" style="position: relative;">
          <span style="display: block;"><b>ID : </b> <?php echo e($item->ID_DOCUMENTO); ?></span>
          <span style="display: block;"><b>CODIGO : </b> <?php echo e($item->CODIGO); ?></span>
          <span style="display: block;"><b>ARENDIR : (MERGE)</b> <?php echo e($item->ARENDIR_ID); ?></span>
          <span style="display: block;"><b>SERIE ARENDRI (OSIRIS): </b> <?php echo e($item->TXT_SERIE); ?></span>
          <span style="display: block;"><b>NUMERO ARENDIR (OSIRIS): </b> <?php echo e($item->TXT_NUMERO); ?></span>


          <span style="display: block;"><b>TIPO ARENDIR : </b> <?php echo e($item->ARENDIR); ?></span>
          <span style="display: block;"><b>TRABAJADOR : </b> <?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?></span>
          <span style="display: block;"><b>FECHA EMISION : <?php echo e(date_format(date_create($item->FECHA_EMI), 'd/m/Y')); ?></b></span>
          <span style="display: block;"><b>FECHA CREACION : <?php echo e(date_format(date_create($item->FECHA_CREA), 'd/m/Y')); ?></b></span>
          <span style="display: block;"><b>PERIODO : </b> <?php echo e($item->TXT_PERIODO); ?></span>
          <span style="display: block;"><b>CENTRO : </b> <?php echo e($item->TXT_CENTRO); ?></span>
          <span style="display: block;"><b>AUTORIZA : </b> <?php echo e($item->TXT_USUARIO_AUTORIZA); ?></span>
          <span style="display: block;"><b>TOTAL : </b> <?php echo e($item->TOTAL); ?> </span>
          <span><b>ESTADO : </b> <?php echo $__env->make('planillamovilidad.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></span>
          <span><b>OBSERVACION : </b> 
              <?php if($item->IND_OBSERVACION == '0'): ?> 
                  <span class="badge badge-defaults" style="display: inline-block;">SIN OBSERVACION</span>
              <?php else: ?>
                  <span class="badge badge-danger" style="display: inline-block;"><?php echo e($item->TXT_OBSERVACION); ?></span>
              <?php endif; ?>
          </span>
          <a href="<?php echo e(url('/detalle-comprobante-lg-validado/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-primary btn-sm">SEGUIMIENTO</a>
          <a href="<?php echo e(url('/modificar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)).'/0')); ?>" style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-success btn-sm">MODIFICAR</a>
        
          <?php if($item->COD_ESTADO == 'ETM0000000000001'): ?>
            <form method="POST" id='forextornar<?php echo e($item->ID_DOCUMENTO); ?>' action="<?php echo e(url('/extonar-liquidacion-gastos/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

                  <button type= 'button' style="margin-top: 5px;float: right;" class="btn btn-rounded btn-space btn-danger btn-sm btn-extonar-lg" data_extorno="<?php echo e($item->ID_DOCUMENTO); ?>">EXTORNAR</button>
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
