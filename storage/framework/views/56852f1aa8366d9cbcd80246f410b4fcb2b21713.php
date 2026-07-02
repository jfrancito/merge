<?php if(count($empresa_relacionada)>0): ?> 
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE SALIDA
      </div>
      <div class="panel-body panel-body-contrast">
          <?php if(count($ordensalida)<=0): ?>
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN ORDEN DE SALIDA</p>
              </div>
          <?php else: ?>
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Orden Ingreso</b> : <?php echo e($ordensalida->COD_ORDEN); ?></p>
                  <p style="margin:0px;"><b>Estado Orden Ingreso</b> : <?php echo e($ordensalida->TXT_CATEGORIA_ESTADO_ORDEN); ?>

                     <span class="mdi mdi-eye mdidetoi" data_doc='<?php echo e($ordensalida->COD_ORDEN); ?>'></span>
                  </p>


              </div>
          <?php endif; ?>
      </div>
    </div>
<?php endif; ?>
