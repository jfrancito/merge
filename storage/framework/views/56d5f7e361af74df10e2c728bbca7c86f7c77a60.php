<div class="col-md-12">
  <div class="panel panel-contrast">
    <!-- <div class="panel-heading panel-heading-contrast"><b>ORDEN COMPRA</b></div> -->
    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PENDIENTES
            <span class="panel-subtitle" style="color: #fff;">Documentos por aprobar</span>
            <div class="chart-legend">
              <a href="<?php echo e(url($url)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Aprobar</a>
            </div>
            <span class="count-das"><?php echo e($count_x_aprobar); ?></span>
          </div>
        </div>
      </div>
      <?php if($trol->ind_uc == 1): ?>
        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INTEGRACION
              <span class="panel-subtitle" style="color: #fff;">Documentos por integrar</span>
              <div class="chart-legend">
                <a href="<?php echo e(url($url_gestion)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir a Integrar</a>
              </div>
              <span class="count-das"><?php echo e($count_x_aprobar_gestion); ?></span>
            </div>
          </div>
        </div>


        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
              <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
              <div class="chart-legend">
                <a href="<?php echo e(url($url_obs)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
              </div>
              <span class="count-das"><?php echo e($count_observados); ?></span>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REPARABLE
              <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
              <div class="chart-legend">
                <a href="<?php echo e(url($url_rep)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Reparable</a>
              </div>
              <span class="count-das"><?php echo e($count_reparables); ?></span>
            </div>
          </div>
        </div>

      <?php endif; ?>
      <?php if($trol->ind_uc != 1): ?>


      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REPARABLE
            <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
            <div class="chart-legend">
              <a href="<?php echo e(url($url_rep)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Reparable</a>
            </div>
            <span class="count-das"><?php echo e($count_reparables); ?></span>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REVISAR REPARABLE
            <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
            <div class="chart-legend">
              <a href="<?php echo e(url($url_rep_revisar)); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Revisar Reparable</a>
            </div>
            <span class="count-das"><?php echo e($count_reparables_rev); ?></span>
          </div>
        </div>
      </div>


        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
              <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
              <div class="chart-legend">
                <a href="<?php echo e(url($url.'&tab_id=observado')); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
              </div>
              <span class="count-das"><?php echo e($count_observados); ?></span>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES LEVANTADAS
              <span class="panel-subtitle" style="color: #fff;">Documentos observados levantadas</span>
              <div class="chart-legend">
                <a href="<?php echo e(url($url.'&tab_id=observadole')); ?>" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
              </div>
              <span class="count-das"><?php echo e($count_observadosoc_le); ?></span>
            </div>
          </div>
        </div>

<!--         <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-table">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><b>POR USUARIO</b>
              <span class="panel-subtitle" style="color: #fff;">Documentos sin integrar</span>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-borderless">
                <thead>
                  <tr>
                    <th>USUARIO CONTACTO</th>
                    <th>CANTIDAD</th>
                  </tr>
                </thead>
                <tbody class="no-border-x">
                  <?php $__currentLoopData = $listaocpendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($index); ?></td>
                      <td class="text-center"> <span class="badge badge-success" style="font-size: 16px;"><?php echo e(count($item)); ?></span></td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-table">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><b>POR ESTADOS</b>
              <span class="panel-subtitle" style="color: #fff;">Documentos integrados</span>
            </div>
            <div class="panel-body">
              <table class="table table-striped table-borderless">
                <thead>
                  <tr>
                    <th>ESTADOS</th>
                    <th>CANTIDAD</th>
                  </tr>
                </thead>
                <tbody class="no-border-x">
                  <?php $__currentLoopData = $listadocestados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($item->TXT_ESTADO); ?></td>
                      <td class="text-center"> <span class="badge badge-success" style="font-size: 16px;"><?php echo e($item->CANT); ?></span></td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr>
                      <td>OBSERVADOS</td>
                      <td class="text-center"> <span class="badge badge-success"><?php echo e(count($listaobservados)); ?></span></td>
                    </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div> -->

      <?php endif; ?>




    </div>
    </div>
  </div>
</div>


