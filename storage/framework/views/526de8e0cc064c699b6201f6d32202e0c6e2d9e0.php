    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT

        <div class="tools select" style="cursor: pointer;padding-left: 12px;"> 
          <a class="tools select" href="<?php echo e(url('/refrescar-sunat-comision/'.$idopcion.'/'.$linea.'/'.$fedocumento->ID_DOCUMENTO)); ?>">
            <span class="label label-success">Refrescar Sunat</span>
          </a>
        </div>

      </div>
      <div class="panel-body panel-body-contrast">
          <?php if(count($fedocumento)<=0): ?>
              <div class="col-sm-12">
                  <b>CARGAR XML</b>
              </div>
          <?php else: ?>
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Respuesta Sunat</b> : <?php echo e($fedocumento->message); ?></p>
                  <p style="margin:0px;" class='<?php if($fedocumento->estadoCp == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b>Estado Comprobante</b> : 
                      <?php echo e($fedocumento->nestadoCp); ?>

                  </p>
                  <p style="margin:0px;"><b>Estado Ruc</b> : <?php echo e($fedocumento->nestadoRuc); ?></p>
                  <p style="margin:0px;"><b>Estado Domicilio</b> : <?php echo e($fedocumento->ncondDomiRuc); ?></p>
                  <p style="margin:0px;"><b>Respuesta CDR</b> : <?php echo e($fedocumento->RESPUESTA_CDR); ?></p>


              </div>
          <?php endif; ?>
      </div>
    </div>