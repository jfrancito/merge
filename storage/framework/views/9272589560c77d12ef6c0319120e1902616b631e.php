<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>PLANILLA</th>
      <th>PERIODO</th>

      <th>CODIGO</th>
      <th>FECHA EMISION</th>
      <th>TRABAJADOR</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr 
        data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
        class="toptable" 
        >
        <td><?php echo e($index +1); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e($item->TXT_PERIODO); ?></td>

        <td><?php echo e($item->CODIGO); ?></td>
        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
        <td><?php echo e($item->FECHA_EMI); ?></td>
        <td><?php echo e($item->TXT_TRABAJADOR); ?></td>
        <td><?php echo e($item->TOTAL); ?></td>
        <td>
          <div class="text-center be-checkbox be-checkbox-sm has-primary">
            <input  type="checkbox"
              class="<?php echo e($item->ID_DOCUMENTO); ?> input_asignar selectfolio"
              id="<?php echo e($item->ID_DOCUMENTO); ?>"
              <?php if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO): ?> checked <?php endif; ?>>

            <label  for="<?php echo e($item->ID_DOCUMENTO); ?>"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"                    
                  name="<?php echo e($item->ID_DOCUMENTO); ?>"
            ></label>
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