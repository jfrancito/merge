<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>

      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->id); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
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
          <?php echo $__env->make('comprobante.ajax.areparable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                <a href="<?php echo e(url('/reparable-comprobante-uc-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">Reparable</a>  
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