<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th></th>
      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
          data_linea = "<?php echo e($item->DOCUMENTO_ITEM); ?>"
          data_orden_compra = "<?php echo e($item->ID_DOCUMENTO); ?>"
          data_proveedor = "<?php echo e($item->RZ_PROVEEDOR); ?>"
          data_serie = "<?php echo e($item->SERIE); ?>"
          data_numero = "<?php echo e($item->NUMERO); ?>"
          data_total = "<?php echo e($item->TOTAL_VENTA_ORIG); ?>"
          class='dobleclickpcestiba seleccionar'
        >

        <td><?php echo e($index+1); ?></td>
        <td>  
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="<?php echo e($item->ID_DOCUMENTO); ?> input_check_pe_ln check<?php echo e($item->ID_DOCUMENTO); ?>" 
                    id="<?php echo e($item->ID_DOCUMENTO); ?>">
            <label  for="<?php echo e($item->ID_DOCUMENTO); ?>"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="<?php echo e($item->ID_DOCUMENTO); ?>"
            ></label>
          </div>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>PROVEEDOR : </b><?php echo e($item->RZ_PROVEEDOR); ?> </span>
          
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO); ?></span>
          <span><b>FOLIO : </b> <?php echo e($item->FOLIO); ?></span>
          <span><b>H. OBSERVACION : </b> <?php echo e($item->TXT_OBSERVADO); ?></span>
          <span><b>H. REPARABLE : </b> <?php echo e($item->TXT_REPARABLE); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
          <span><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
          <span><b>ADMINISTRACION : </b> <?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
        </td>
        <?php echo $__env->make('comprobante.ajax.estadosfe', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
<!--             <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/aprobar-comprobante-administracion-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9)))); ?>">
                  Aprobar Comprobante
                </a>  
              </li>
            </ul> -->
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