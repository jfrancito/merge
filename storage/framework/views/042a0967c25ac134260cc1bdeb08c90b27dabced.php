    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE INGRESO
      </div>
      <div class="panel-body panel-body-contrast">
          <?php if(count($ordeningreso)<=0): ?>
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN ORDEN DE INGRESO</p>
              </div>
          <?php else: ?>
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Orden Ingreso</b> : <?php echo e($ordeningreso->COD_ORDEN); ?></p>
                  <p style="margin:0px;"><b>Estado Orden Ingreso</b> : <?php echo e($ordeningreso->TXT_CATEGORIA_ESTADO_ORDEN); ?>

                     <span class="mdi mdi-eye mdidetoi" data_doc='<?php echo e($ordeningreso->COD_ORDEN); ?>'></span>
                  </p>


              </div>
          <?php endif; ?>
      </div>
    </div>