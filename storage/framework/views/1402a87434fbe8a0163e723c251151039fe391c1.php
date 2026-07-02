<table id="table1" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO / CONTRATO</th>
      <th>PROVEEDOR / SEDE</th>
      <th>PRODUCTO / COSECHA</th>
      <th>PRODUCCIÓN</th>
      <th>FINANZAS</th>
      <th>ESTADO</th>
      <th class="text-center">ACCIÓN</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $lcontratoacopio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id="<?php echo e($item->ID_DOCUMENTO); ?>">
        <td class="text-center"><?php echo e($index + 1); ?></td>
        <td class="cell-detail">
          <span><b>ID:</b> <?php echo e($item->ID_DOCUMENTO); ?></span>
          <span class="cell-detail-description"><b>NRO:</b> <?php echo e($item->NRO_CONTRATO); ?></span>
          <span class="cell-detail-description"><b>REGISTRO:</b> <?php echo e(date_format(date_create($item->FECHA_CONTRATO), 'd-m-Y')); ?></span>
        </td>
        <td class="cell-detail">
          <span><b>PROVEEDOR:</b> <?php echo e($item->TXT_PROVEEDOR); ?></span>
          <span><b>APROBO CONTRATO:</b> <?php echo e($item->TXT_USUARIO_CON_APRUEBA); ?></span>
          <span class="cell-detail-description"><b>SEDE:</b> <?php echo e($item->TXT_CENTRO); ?></span>
        </td>
        <td class="cell-detail">
          <span><b>VARIEDAD:</b> <?php echo e($item->TXT_VARIEDAD); ?></span>
          <span class="cell-detail-description"><b>COSECHA:</b> <?php echo e(date_format(date_create($item->FECHA_COSECHA), 'd-m-Y')); ?></span>
        </td>
        <td class="cell-detail">
          <span><b>HECTÁREAS:</b> <?php echo e(number_format($item->HECTAREAS, 2, '.', ',')); ?></span>
          <span class="cell-detail-description"><b>TOTAL KG:</b> <?php echo e(number_format($item->TOTAL_KG, 2, '.', ',')); ?></span>
          <span class="cell-detail-description"><b>P. REF:</b> <?php echo e(number_format($item->PRECIO_REFERENCIA, 4, '.', ',')); ?></span>
        </td>
        <td class="cell-detail">
          <span><b>PROYECCIÓN:</b> <?php echo e(number_format($item->PROYECCION, 2, '.', ',')); ?></span>
          <span class="cell-detail-description text-primary-dark text-bold"><b>HABILITAR:</b> <?php echo e(number_format($item->IMPORTE_HABILITAR, 2, '.', ',')); ?></span>
        </td>
        <?php echo $__env->make('cuartacategoria.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/gestion-revisar-acopio-contrato/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                  Revisar Acopio Contrato
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


      $("#nso_f").dataTable({
          dom: 'Bfrtip',
          buttons: [
              'csv', 'excel', 'pdf'
          ],
          "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
          columnDefs:[{
              targets: "_all",
              sortable: false
          }]
      });



    });
  </script> 
<?php endif; ?>

