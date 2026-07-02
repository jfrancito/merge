    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ANTICIPO ASOCIADOS
      </div>
      <div class="panel-body panel-body-contrast">

        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Lote</th>
              <th>Detraccion</th>
              <th>Retencion</th>
              <th>Monto</th>      
              <th>Fecha</th>       
            </tr>
          </thead>
          <tbody>
             <?php $__currentLoopData = $lista_anticipo_merge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <tr>
                  <td><?php echo e($item->ID_DOCUMENTO); ?></td>
                  <td><?php echo e(number_format($item->MONTO_DETRACCION_RED, 2, '.', ',')); ?></td>
                  <td><?php echo e(number_format($item->MONTO_ANTICIPO_DESC, 2, '.', ',')); ?></td>
                  <td><?php echo e(number_format($item->TOTAL_VENTA_ORIG, 2, '.', ',')); ?></td>
                  <td><?php echo e($item->fecha_uc); ?></td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>

      </div>
    </div>