<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>FOLIO</th>
      <th>PERIODO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>ESTADO</th>
      <th>USUARIO CREA</th>
      <th>FECHA EMISION</th>
      <th>OPCION</th>
  </thead>
  <tbody>

    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
        class="<?php if($item->COD_CATEGORIA_ESTADO == 'ETM0000000000011'): ?> dobleclickpc seleccionar <?php endif; ?> "
        >
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
        <td><?php echo e($item->FOLIO); ?></td>
        <td><?php echo e($item->TXT_PERIODO); ?></td>
        <td><?php echo e($item->TXT_GLOSA); ?></td>
        <td><?php echo e($item->CAN_FOLIO); ?></td>
        <?php echo $__env->make('entregadocumento.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td><?php echo e($item->nombre); ?></td>
        <td><?php echo e(date_format(date_create($item->FEC_EMISION), 'd-m-Y')); ?></td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/pdf-planilla-movilidad-consolidada/'.$item->ID_DOCUMENTO)); ?>" target="_blank">
                  Imprimir Consolidado
                </a>  
              </li>

              <li>
                <a  href="#" 
                    data_requerimiento_opcion_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
                    class="<?php if($item->COD_CATEGORIA_ESTADO == 'ETM0000000000011'): ?> clickpc <?php endif; ?> "
                 >
                  SUBIR EL CONSOLIDADO
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