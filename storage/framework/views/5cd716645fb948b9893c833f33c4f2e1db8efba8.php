<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>FECHA EMISION</th>
      <th>TIPO DOC</th>
      <th>SERIE</th>
      <th>NRO</th>
      <th>RUC PROVEEDOR</th>
      <th>RZ PROVEEDOR</th>
      <th>TOTAL</th>      
    </tr>
  </thead>
  <tbody>
      <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td class=''><?php echo e($index + 1); ?></td>
            <td class=''><?php echo e($item['fecEmision']); ?></td>
            <td class=''><?php echo e($item['codTipoCDP']); ?></td>
            <td class=''><?php echo e($item['numSerieCDP']); ?></td>
            <td class=''><?php echo e($item['numCDP']); ?></td>
            <td class=''><?php echo e($item['numDocIdentidadProveedor']); ?></td>
            <td class=''><?php echo e($item['nomRazonSocialProveedor']); ?></td>
            <td class=''><?php echo e($item['mtoTotalCp']); ?></td>
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