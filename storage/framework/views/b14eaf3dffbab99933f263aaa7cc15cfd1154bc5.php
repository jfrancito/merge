<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - ORDEN COMPRA)
  </div>
  <div class="panel-body panel-body-contrast">
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th>Valor</th>
          <th>Orden de Compra</th>      
          <th class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">XML</th>       
        </tr>
      </thead>
      <tbody>
          <tr>
            <td><b>RUC</b></td>
            <td><p class='subtitulomerge'><?php echo e($ordencompra->NRO_DOCUMENTO_CLIENTE); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
              <div class='subtitulomerge <?php if($fedocumento->ind_ruc == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RUC_PROVEEDOR); ?></b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>RAZON SOCIAL</b></td>
            <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
              <div class='subtitulomerge <?php if($fedocumento->ind_rz == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RZ_PROVEEDOR); ?></b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'><?php echo e(date_format(date_create($ordencompra->FEC_ORDEN), 'd/m/Y')); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
              <div class='subtitulomerge <?php if($fedocumento->ind_fecha == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e(date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y')); ?></b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>MONEDA</b></td>
            <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_CATEGORIA_MONEDA); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
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
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'><?php echo e(number_format($ordencompra->CAN_TOTAL+$ordencompra_f->CAN_PERCEPCION, 4, '.', ',')); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
              <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                  <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_XML+$fedocumento->PERCEPCION, 4, '.', ',')); ?></b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>FORMA PAGO</b></td>
            <td><p class='subtitulomerge'><?php echo e($tp->NOM_CATEGORIA); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
              <div class='subtitulomerge <?php if($fedocumento->ind_formapago == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><?php echo e($fedocumento->FORMA_PAGO); ?> 
              </div>
            </td>
          </tr>

          <tr>
            <td><b>CANTIDAD ITEM</b></td>
            <td><p class='subtitulomerge'><?php echo e(count($detalleordencompra)); ?></p></td>
            <td class="<?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
               <div class='subtitulomerge <?php if($fedocumento->ind_cantidaditem == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e(count($detallefedocumento)); ?></b>
               </div>
            </td>
          </tr>

          <tr>
            <td><b>DETRACCION</b></td>
            <td  colspan="2" class=""><b><?php echo e($ordencompra_f->PERCEPCION); ?></b></td>
          </tr>

          <tr>
            <td><b>PERCEPCION</b></td>
            <td  colspan="2" class=""><b><?php echo e($ordencompra_f->CAN_PERCEPCION); ?></b></td>
          </tr>

          <tr>
            <td><b>RETENCION IGV</b></td>
            <td  colspan="2" class=""><b><?php echo e($ordencompra_f->CAN_RETENCION); ?></b></td>
          </tr>
          <tr>
            <td><b>RETENCION 4TA CATEGORIA</b></td>
            <td  colspan="2" class=""><b><?php echo e($ordencompra_f->CAN_IMPUESTO_RENTA); ?></b></td>
          </tr>


          <tr>
            <td><b>Anticipo</b></td>
            <td><p class='subtitulomerge'><b><?php echo e($fedocumento->MONTO_ANTICIPO_DESC); ?><b></p></td>
          </tr>
          <tr>
            <td><b>Otro anticipo</b></td>
            <td><p class='subtitulomerge'><?php echo e($fedocumento->MONTO_ANTICIPO_DESC_OTROS); ?></p></td>
          </tr>
          

          <tr>
            <td><b>Grupo</b></td>
            <td><p class='subtitulomerge'><?php echo e($fedocumento->COD_NOMBRE_MK); ?></p></td>
          </tr>


      </tbody>
    </table>
  </div>
</div>