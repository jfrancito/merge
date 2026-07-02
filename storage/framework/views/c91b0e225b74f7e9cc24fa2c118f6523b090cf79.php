
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - NOTA DE CREDITO)
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Nota de Credito</th>      
              <th>XML</th>       
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><b>RUC</b></td>
                <td><p class='subtitulomerge'><?php echo e($ordencompra->NRO_DOCUMENTO_CLIENTE); ?></p></td>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_ruc == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RUC_PROVEEDOR); ?></b>
                  </div>
                </td>
              </tr>
              
              <tr>
                <td><b>RAZON SOCIAL</b></td>
                <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_EMPR_EMISOR); ?></p></td>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_rz == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RZ_PROVEEDOR); ?></b>
                  </div>
                </td>
              </tr>


              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_CATEGORIA_MONEDA); ?></p></td>
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
                <td><p class='subtitulomerge'><?php echo e(number_format($ordencompra->CAN_TOTAL, 4, '.', ',')); ?></p></td>
                <td>
                  <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                      <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_XML, 4, '.', ',')); ?></b>
                  </div>
                </td>
              </tr>            
          </tbody>
        </table>
      </div>
    </div>
