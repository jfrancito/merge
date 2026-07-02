<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE AGRUPADO
  </div>
  <div class="panel-body panel-body-contrast">

        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>CODIGO PRODUCTO</th>
              <th>PRODUCTO</th>      
              <th>CANTIDAD</th>       
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                $sumaTotal = 0;
             ?>

          <?php $__currentLoopData = $productosagru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $sumaTotal += $item->TOTAL;
                 ?>

              <tr>
                <td><?php echo e($item->COD_PRODUCTO); ?></td>
                <td><?php echo e($item->TXT_PRODUCTO); ?></td>
                <td><?php echo e($item->CANTIDAD); ?></td>                    
                <td><?php echo e($item->TOTAL); ?></td>
              </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr style="font-weight: bold; background-color: #f5f5f5;">
                <td></td>
                <td></td>
                <td></td>
                <td><b><?php echo e(number_format($sumaTotal, 2)); ?></b></td>
            </tr>

          </tbody>
        </table>
  </div>
</div>