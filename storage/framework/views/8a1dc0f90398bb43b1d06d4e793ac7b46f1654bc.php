    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Usuario</th>      
              <th>Tipo</th>
              <th>Mensaje</th>

            </tr>
          </thead>
          <tbody>

              <?php $__currentLoopData = $documentohistorial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <tr>
                  <td><?php echo e(date_format(date_create($item->FECHA), 'd-m-Y H:i:s')); ?></td>
                  <td><?php echo e($item->USUARIO_NOMBRE); ?></td>
                  <td><b><?php echo e($item->TIPO); ?></</b></td>
                  <td><?php echo e($item->MENSAJE); ?></td>

                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </tbody>
        </table>

      </div>
    </div>