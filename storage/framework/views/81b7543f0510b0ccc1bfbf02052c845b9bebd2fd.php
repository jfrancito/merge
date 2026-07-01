<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>

      <th>CONTRATO</th>
      <th>FACTURA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index+1); ?></td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : <?php echo e($item->COD_DOCUMENTO_CTBLE); ?> </b> </span>
          <span><b>FECHA  : <?php echo e($item->FEC_EMISION); ?></b></span>
          <span><b>PROVEEDOR : </b> <?php echo e($item->TXT_EMPR_EMISOR); ?></span>
          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL); ?></span>
          <span><b>DOCUMENTO : </b> <?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></span>

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
          <span><b>CENTRO : </b> <?php echo e($item->NOM_CENTRO); ?></span>

        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
          <span><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
          <span><b>ADMINISTRACION : </b> <?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>

        </td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/detalle-comprobante-oc-validado-contrato-historial/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9)))); ?>">
                    Detalle de Registro
                </a>
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

