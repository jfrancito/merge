<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CREA</th> 
      <th>SERIE</th> 
      <th>NUMERO</th> 
      <th>FECHA EMISION</th> 
      <th>PROVEEDOR</th> 
      <th>TOTAL</th> 
      <th>IND_PDF</th> 
      <th>IND_XML</th> 
      <th>IND_CDR</th> 
      <th>BUSQUEDAD</th> 
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listacabecera; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
        <td><?php echo e($item->FECHA_EMI); ?></td>
        <td><?php echo e($item->SERIE); ?></td>
        <td><?php echo e($item->NUMERO); ?></td>
        <td><?php echo e($item->FECHA_EMISIONDOC); ?></td>
        <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
        <td><?php echo e($item->TOTAL); ?></td>
        <td><?php echo e($item->IND_PDF); ?></td>
        <td><?php echo e($item->IND_XML); ?></td>
        <td><?php echo e($item->IND_CDR); ?></td>
        <td><?php echo e($item->BUSQUEDAD); ?></td>
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
