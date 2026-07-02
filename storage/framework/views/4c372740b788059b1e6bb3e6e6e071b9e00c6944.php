<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ORDEN COMPRA</th>
      <th>FACTURA</th>
      <th>ESTADO</th>
      <th></th>

      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <?php  
        $cantidadi_reparados    =   $funcion->funciones->cantidad_reparados($item->ID_DOCUMENTO);
       ?>


      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : <?php echo e($item->COD_ORDEN); ?> </b> </span>
          <span><b>FECHA  : <?php echo e($item->FEC_ORDEN); ?></b></span>
          <span><b>PROVEEDOR : </b>(<?php echo e($item->RUC_PROVEEDOR); ?>) <?php echo e($item->TXT_EMPR_CLIENTE); ?> </span>
          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL); ?></span>
          <span><b>LINEA : </b> <?php echo e($item->DOCUMENTO_ITEM); ?></span>
          <?php echo $__env->make('comprobante.ajax.areparable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <span><b>TIPO ARCHIVO : </b> <?php echo e($item->MODO_REPARABLE); ?></span>
          <span><b>CANTIDAD ARCHIVO : </b> <?php echo e($cantidadi_reparados); ?></span>
          <span><b>TIPO ARCHIVO HIBRIDO: </b> <?php echo e($item->MODO_REPARABLE_HIBRIDO); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
        </td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td>  
          <?php if($item->MODO_REPARABLE == 'ARCHIVO_VIRTUAL' && $cantidadi_reparados ==1): ?>
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="<?php echo e($item->ID_DOCUMENTO); ?> input_check_pe_re check<?php echo e($item->ID_DOCUMENTO); ?>" 
                    id="<?php echo e($item->ID_DOCUMENTO); ?>">
            <label  for="<?php echo e($item->ID_DOCUMENTO); ?>"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="<?php echo e($item->ID_DOCUMENTO); ?>"
            ></label>
          </div>
          <?php endif; ?>
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/reparable-comprobante-uc/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10)))); ?>">Reparable</a>  
              </li>
            </ul>
          </div>
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