<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

<div class="icon iconoentregable">
  <span class="mdi mdi-floppy mdisave" 
        data_iddocumento='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->ID_DOCUMENTO); ?><?php endif; ?>' 
        data_folio='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->FOLIO); ?><?php endif; ?>' 
        data_glosa='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->TXT_GLOSA); ?><?php endif; ?>'
        data_cantidad='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->CAN_FOLIO); ?><?php endif; ?>'
        data_periodo='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->TXT_PERIODO); ?><?php endif; ?>'
>
  </span>
</div>
  <table  class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
    <thead>
      <tr>
        <th>DETALLE</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      <?php  $monto_total =  0;  ?>
      <?php $__currentLoopData = $lfedocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="cell-detail sorting_1" style="position: relative;">
            <span><b>ID: </b> <?php echo e($item->ID_DOCUMENTO); ?>  </span>
            <span><b>DOCUMENTO: </b> <?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </span>
            <span><b>PROVEEDOR: </b> <?php echo e($item->TXT_TRABAJADOR); ?>  </span>
          </td>
          <td class="cell-detail sorting_1" style="position: relative;">
            <b style="font-size: 18px;"><?php echo e($item->TOTAL); ?> </b>
          </td>
          <?php  $monto_total =  $monto_total +  $item->TOTAL;  ?>
        </tr>                    
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
      <tfoot>
          <tr>
            <td></td>
            <td><b style="font-size: 18px;"><?php echo e(number_format($monto_total, 4, '.', ',')); ?></b></td>
          </tr>                    
      </tfoot>

  </table>
</div>