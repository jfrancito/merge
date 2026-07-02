<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

<div class="icon iconoentregable">
  <span class="mdi mdi-floppy mdisave" 
        data_folio='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->FOLIO); ?><?php endif; ?>' 
        data_glosa='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->TXT_GLOSA); ?><?php endif; ?>'
        data_cantidad='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->CAN_FOLIO); ?><?php endif; ?>'
        data_banco='<?php if(isset($entregagle_a)): ?><?php echo e($entregagle_a->TXT_CATEGORIA_BANCO); ?><?php endif; ?>'
>
  </span>
</div>



  <?php if(count($array_retencion)>0): ?>

    <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible" style="width:95%">
      <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
      <div class="message">
        <strong>Advertencia!</strong> <?php echo e($mensaje); ?>

      </div>
    </div>

  <?php else: ?>

    <div role="alert" class="alert alert-success alert-icon alert-icon-border alert-dismissible" style="width:95%">
      <div class="icon"><span class="mdi mdi-check"></span></div>
      <div class="message">
        <strong>Bien!</strong> <?php echo e($mensaje); ?>

      </div>
    </div>

  <?php endif; ?>

  <table  class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
    <thead>
      <tr>
        <th>DETALLE</th>
        <th>PAGO</th>
      </tr>
    </thead>
    <tbody>
      <?php  $monto_total =  0;  ?>
      <?php $__currentLoopData = $lfedocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="cell-detail sorting_1" style="position: relative;">
            <span><b>ID: </b> <?php echo e($item->ID_DOCUMENTO); ?>  </span>
            <span><b>DOCUMENTO: </b> <?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </span>
            <span><b>PROVEEDOR: </b> <?php echo e($item->RZ_PROVEEDOR); ?>  </span>
          </td>
          <td class="cell-detail sorting_1" style="position: relative;">
            <b style="font-size: 18px;"><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?> </b>
            <?php 
              $encontrado = array_filter($array_retencion, function ($doc) use ($item) {
                  return $doc["ID_DOCUMENTO"] === $item->ID_DOCUMENTO;
              });
              $doc = reset($encontrado); 
             ?>
            <?php if($doc): ?>
                <p><b style="color: #fbbc05;">Retención: <?php echo e($doc["RETENCION"]); ?></b></p>
            <?php endif; ?>


          </td>
          <?php  $monto_total =  $monto_total +  $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO);  ?>
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