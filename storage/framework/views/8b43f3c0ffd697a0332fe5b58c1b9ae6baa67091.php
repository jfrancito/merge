<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>IND ITEMS</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->COD_ORDEN); ?>">
        <td><b>ORDER DE COMPRA</b></td>
        <td><?php echo e($item->COD_ORDEN); ?></td>
        <td><?php echo e($item->FEC_ORDEN); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>
        <td><?php echo e($item->CAN_TOTAL); ?></td>
        <td><?php echo e($item->COD_USUARIO_CREA_AUD); ?></td>
        <td >  
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="<?php echo e($item->COD_ORDEN); ?> input_check_pe_ln check<?php echo e($item->COD_ORDEN); ?>" 
                    id="check<?php echo e($item->COD_ORDEN); ?>" 
                    data_producto = "<?php echo e($item->COD_ORDEN); ?>" 
                    <?php if($item->TXT_CONFORMIDAD != ''): ?> checked = 'checked' <?php endif; ?>>

            <label  for="check<?php echo e($item->COD_ORDEN); ?>"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="check<?php echo e($item->COD_ORDEN); ?>"
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