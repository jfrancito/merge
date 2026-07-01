<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ORDEN COMPRA ANTICIPO</th>
      <th>FACTURA</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->id); ?>">
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
          <span><b>CODIGO : <?php echo e($item->COD_ORDEN); ?> </b> </span>
          <span><b>FECHA  : <?php echo e($item->FEC_ORDEN); ?></b></span>
          <span><b>PROVEEDOR : </b>(<?php echo e($item->RUC_PROVEEDOR); ?>) <?php echo e($item->TXT_EMPR_CLIENTE); ?> </span>
          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL); ?></span>
          <span><b>LINEA : </b> <?php echo e($item->DOCUMENTO_ITEM); ?></span>
          <span><b>ORSERVACION : </b>               
              <?php if($item->ind_observacion == 1): ?> 
                  <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
              <?php else: ?>
                <?php if($item->ind_observacion == 0): ?> 
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                <?php else: ?>
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                <?php endif; ?>
              <?php endif; ?>
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
        </td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/observacion-comprobante-uc-estiba-oca/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">Observacion</a>  
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