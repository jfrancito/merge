    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO

        <div class="tools eliminiar_observacion select" style="cursor: pointer;padding-left: 12px;"> 

          <a class="tools select" href="<?php echo e(url('/extornar-obs-contrato/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9)))); ?>">
            <span class="label label-danger">Extornar Ult. Obs.</span>
          </a>

          
        </div>

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