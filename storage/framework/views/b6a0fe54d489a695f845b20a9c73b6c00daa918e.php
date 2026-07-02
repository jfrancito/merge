<table id="table1" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CONSTANCIA</th>
      <th>FECHA CADUCIDAD</th>
      <th>RUC</th>

      <th>PROVEEDOR</th>
      <th>NUMERO OPERACION</th>
      <th>OBSERVACION</th>
      <th>ESTADO</th>
      <th>OPCION</th>

    </tr>
  </thead>
  <tbody>

    <?php $__currentLoopData = $lrentacuartacategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
        >
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_CONSTANCIA), 'd-m-Y')); ?></td>
        <td><?php echo e(date_format(date_create($item->FECHA_CADUCIDAD), 'd-m-Y')); ?></td>   
        <td><?php echo e($item->RUC); ?></td>
        <td><?php echo e($item->RAZON_SOCIAL); ?></td>
        <td><?php echo e($item->NUMERO_OPERACION); ?></td>
        <td><?php echo e($item->OBSERVACION); ?></td>
        <?php echo $__env->make('cuartacategoria.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/descargar-documento-cuarta-categoria/'.$item->ID_DOCUMENTO)); ?>">
                  Descargar 4ta Categoria
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

