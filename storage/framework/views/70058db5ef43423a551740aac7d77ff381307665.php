<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CLIENTERR</th>
      <th>SUMARR</th>
      <th>TIPORR</th>
      <th>CLIENTE OTROS</th>
      <th>SUMA OTROS</th>
      <th>TIPO OTROS</th>
      <th>DIFERENCIA</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $diferencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr data_cliente = "<?php echo e($item->CLIENTERR); ?>"
          class='dobleclickpc seleccionar'
          style="cursor: pointer;">
        <td><?php echo e($item->CLIENTERR); ?></td>
        <td><?php echo e($item->SUMARR); ?></td>
        <td><?php echo e($item->TIPORR); ?></td>
        <td><?php echo e($item->CLIENTEO); ?></td>
        <td><?php echo e($item->SUMAO); ?></td>
        <td><?php echo e($item->TIPOO); ?></td>
        <td><?php echo e($item->diferencia); ?></td>      

      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>


<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CLIENTERR</th>
      <th>SUMARR</th>
      <th>TIPORR</th>
      <th>CLIENTE OTROS</th>
      <th>SUMA OTROS</th>
      <th>TIPO OTROS</th>

    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $solo_uno; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr data_cliente = "<?php echo e($item->CLIENTERR); ?>"
          class='dobleclickpc seleccionar'
          style="cursor: pointer;">
        <td><?php echo e($item->CLIENTERR); ?></td>
        <td><?php echo e($item->SUMARR); ?></td>
        <td><?php echo e($item->TIPORR); ?></td>
        <td><?php echo e($item->CLIENTEO); ?></td>
        <td><?php echo e($item->SUMAO); ?></td>
        <td><?php echo e($item->TIPOO); ?></td>
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