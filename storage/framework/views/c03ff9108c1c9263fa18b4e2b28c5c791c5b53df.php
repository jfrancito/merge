<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>FOLIO</th>
      <th>BANCO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>ESTADO</th>
      <th>USUARIO CREA</th>
      <th>FECHA PAGO</th>
      <th>OPCION</th>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->FOLIO); ?>"
        class='dobleclickpc seleccionar'
        >
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->OPERACION); ?></td>
        <td><?php echo e($item->FOLIO); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
        <td><?php echo e($item->TXT_GLOSA); ?></td>
        <td><?php echo e($item->CAN_FOLIO); ?></td>
        <?php echo $__env->make('entregadocumento.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td><?php echo e($item->nombre); ?></td>
        <td><?php echo e(date_format(date_create($item->FEC_PAGO), 'd-m-Y')); ?></td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
                <li>
                  <a href="<?php echo e(url('/descargar-folio-excel-detraccion/'.$item->FOLIO)); ?>">
                    Descargar Resumen
                  </a>  
                </li>
                <li>
                  <a href="<?php echo e(url('/descargar-folio-excel-detraccion-macro/'.$item->FOLIO)); ?>">
                    Macro Banco de la Nacion
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


<?php if(isset($mensaje)): ?>
  <script type="text/javascript">
    alertajax("<?php echo e($mensaje); ?>");
  </script> 
<?php endif; ?>