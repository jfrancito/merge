    <div class="panel panel-default panel-contrast">
      <div class="panel-heading"  style="background: <?php if(count($transferencia)>0): ?> <?php if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA'): ?> #cc0000 <?php else: ?> #1d3a6d <?php endif; ?>;color: #fff; <?php endif; ?>"
      >TRANSFERENCIA
      </div>
      <div class="panel-body panel-body-contrast">

          <?php if(count($transferencia)<=0): ?>
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN TRANSFERENCIA</p>
              </div>
          <?php else: ?>
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Transferencia</b> : <?php echo e($transferencia->COD_ORDEN); ?></p>
                  <p style="margin:0px;"><b>Estado Transferencia</b> : 
                    <?php if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA'): ?>
                      NO RECEPCIONADO
                    <?php else: ?>
                      <?php echo e($transferencia->TXT_CATEGORIA_ESTADO_ORDEN); ?> <b>
                        <?php if(count($transferencia_doc)>0): ?>
                          (<?php echo e(date_format(date_create($transferencia_doc->FEC_USUARIO_CREA_AUD), 'd-m-Y h:i:s')); ?>)
                        <?php endif; ?>
                      </b>
                    <?php endif; ?>
                  </p>
              </div>
          <?php endif; ?>
      </div>
    </div>