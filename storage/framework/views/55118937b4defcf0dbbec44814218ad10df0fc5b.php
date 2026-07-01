
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><?php echo e($fedocumento->OPERACION); ?>

      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Contrato</th>      
              <th>XML</th>       
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>
                  <?php if(count($documento_top)>0): ?>
                    <?php echo e($documento_top->TXT_CATEGORIA_MONEDA); ?>

                  <?php endif; ?>
                  
                </p></td>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_moneda == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'> <b>
                      <?php if($fedocumento->MONEDA == 'PEN'): ?>
                          SOLES
                      <?php else: ?>
                          <?php echo e($fedocumento->MONEDA); ?>

                      <?php endif; ?></b>
                  </div>
                </td>
              </tr>
              <tr>
                <td><b>Total</b></td>
                <?php if($fedocumento->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
                  <td><p class='subtitulomerge'><?php echo e(number_format($documento_asociados->sum('CAN_TOTAL'), 4, '.', ',')); ?></p></td>
                <?php else: ?>
                  <td><p class='subtitulomerge'><?php echo e(number_format($fereftop1->TOTAL_MERGE, 4, '.', ',')); ?></p></td>
                <?php endif; ?>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                      <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></b>
                  </div>
                </td>
              </tr>
              <tr>
                <td><b>Anticipo</b></td>
                <td><p class='subtitulomerge'><?php echo e($fedocumento->SERIE_ANTICIPO); ?>-<?php echo e($fedocumento->NRO_ANTICIPO); ?>//<?php echo e($fedocumento->MONTO_ANTICIPO_DESC); ?></p></td>
              </tr>
              <tr>
                <td><b>Otro anticipo</b></td>
                <td><p class='subtitulomerge'><?php echo e($fedocumento->MONTO_ANTICIPO_DESC_OTROS); ?></p></td>
              </tr>
              

          </tbody>
        </table>
      </div>
    </div>
