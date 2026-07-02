    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO
        <div class="tools eliminiar_observacion select" style="cursor: pointer;padding-left: 12px;"> 

          <a class="tools select" href="<?php echo e(url('/extornar-obs-oc/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>">
            <span class="label label-danger">Extornar Ult. Obs.</span>
          </a>

          
        </div>
      </div>
      <div class="panel-body panel-body-contrast">
        <div class='long-text' id="longText">
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th>SEGUIMIENTO </th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $documentohistorial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <tr>
                  <td>
                    <span class="cell-detail-description"><b>FECHA : </b> <?php echo e(date_format(date_create($item->FECHA), 'd-m-Y H:i:s')); ?></span><br>
                    <span class="cell-detail-description"><b>USUARIO : </b> <?php echo e($item->USUARIO_NOMBRE); ?></span><br>
                    <span class="cell-detail-description"><b>TIPO : </b> <?php echo e($item->TIPO); ?></span><br>
                    <span class="cell-detail-description"><b>MENSAJE : </b> <?php echo e($item->MENSAJE); ?></span>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>

      <p style="margin-top: 20px;">
        <a id="toggleButton" onclick="toggleContent()" class="read-more" style="cursor: pointer; font-size: 1.2em;">+ Ver Más</a>
      </p>
      </div>
    </div>