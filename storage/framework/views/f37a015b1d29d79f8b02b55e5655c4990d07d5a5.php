
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><?php echo e($fedocumento->OPERACION); ?>

      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>VALOR</th>
              <th>Documento</th>      
              <th>XML</th>       
            </tr>
          </thead>
          <tbody>

              <tr>
                <td><b>RUC</b></td>
                <td><p class='subtitulomerge'><?php echo e($documento_top->RUC); ?></p></td>
                <td class="">
                  <div class='subtitulomerge <?php if($fedocumento->ind_ruc == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RUC_PROVEEDOR); ?></b>
                  </div>
                </td>
              </tr>

              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>
                  <?php if(count($documento_top)>0): ?>
                    <?php echo e($documento_top->MONEDA); ?>

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
                <td><p class='subtitulomerge'><?php echo e(number_format($documento_asociados->sum('MONTOATENDIDOREAL'), 4, '.', ',')); ?></p></td>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                      <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></b>
                  </div>
                </td>
              </tr>

            
          </tbody>
        </table>
      </div>
    </div>
