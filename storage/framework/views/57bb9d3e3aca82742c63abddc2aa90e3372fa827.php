<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>
      <th>DETRACION</th>
      <th>ANTICIPO</th>
      <th>NETO A PAGAR</th>
      <th>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : </b> <?php echo e($item->ID_DOCUMENTO); ?>  </span>
          <span><b>NRO DOCUMENTO : </b> <?php echo e($item->COD_DOCUMENTO_CTBLE); ?>  </span>
          <span><b>DOCUMENTO : </b> <?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?>  </span>
          <span><b>PROVEEDOR  :</b> <?php echo e($item->TXT_EMPR_EMISOR); ?></span>
          <span><b>COMPROBANTE ASOCIADO : </b> <?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></span>
          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO); ?></span>
          <span><b>FECHA VENCIMIENTO DOC: </b> <?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?>  </span>
          <span><b>FECHA APROBACION ADMIN  :</b><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
          <span><b>MONEDA  :</b><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></span>
          
          <span><b>ESTADO CANJE  :</b>
            <?php if($item->NRO_SERIE == ''): ?>
              <span class="badge badge-danger" style="width: 100px;">SIN CANJEAR</span>
            <?php else: ?>
              <span class="badge badge-success" style="width: 100px;">CANJEADO</span>
            <?php endif; ?>
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> <?php echo e($item->IND_MATERIAL_SERVICIO); ?>  </span>
          <span><b>BANCO  :</b><?php echo e($item->TXT_EMPR_BANCO); ?></span>
          <span><b>SUBIO VOUCHER  :</b>
            <?php if($item->COD_ESTADO == 'ETM0000000000008'): ?>
              SI
            <?php else: ?>
              NO
            <?php endif; ?>
          </span>
          <span><b>CUENTA DETRACCION: </b> <?php echo e($item->CTA_DETRACCION); ?>  </span>
          <span><b>VALOR DETRACCION  :</b><?php echo e($item->VALOR_DETRACCION); ?></span>
          <span><b>PAGO DETRACCION: </b> <?php echo e($item->TXT_PAGO_DETRACCION); ?>  </span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <span><b><?php echo e(number_format(round($item->TOTAL_VENTA_ORIG+$item->CAN_CENTIMO, 4), 4, '.', ',')); ?>  </b></span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b><?php echo e($item->MONTO_DETRACCION_RED); ?></b>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b><?php echo e(number_format(round($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',')); ?></b>
        </td>
        <td class="center neto_pagar"><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
        <td>
            <?php if($item->NRO_SERIE != '' && 0<=0): ?>
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="<?php echo e($item->ID_DOCUMENTO); ?> input_asignar selectfolio"
                id="<?php echo e($item->ID_DOCUMENTO); ?>" 
                <?php if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO): ?> checked <?php endif; ?>>
              <label  for="<?php echo e($item->ID_DOCUMENTO); ?>"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="<?php echo e($item->ID_DOCUMENTO); ?>"
              ></label>
            </div>
            <?php endif; ?>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>

<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>

<?php if(isset($mensaje)): ?>
  <script type="text/javascript">
    alertajax("<?php echo e($mensaje); ?>");
  </script> 
<?php endif; ?>