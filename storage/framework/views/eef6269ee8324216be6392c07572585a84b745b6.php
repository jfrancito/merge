<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>COMPROBANTE</th>
      <th>DOCUMENTO</th>
      <th>PAGO</th>
      <th>NETO A PAGAR</th>
      <th>
        <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input type="checkbox" id="check_all_folios">
          <label for="check_all_folios"></label>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>

    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr 
        data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>"
        class="toptable" 
        >
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>COMPROBANTE : </b> <?php echo e($item->ID_DOCUMENTO); ?>  </span>
          <span><b>OPERACION  :</b> <?php echo e($item->OPERACION); ?></span>
          <span><b>PROVEEDOR : </b> <?php echo e($item->TXT_EMPR_EMISOR); ?>  </span>

          <span><b>PAGO DETRACCION  :</b> <?php echo e($item->TXT_PAGO_DETRACCION); ?></span>
          <span><b>MONTO DETRACCION  :</b> <?php echo e($item->MONTO_DETRACCION_RED); ?></span>
          <span><b>TOTAL  :</b> <?php echo e($item->TOTAL_VENTA_ORIG); ?></span>
          <span><b>ESTADO  :</b> <?php echo e($item->TXT_ESTADO); ?></span>
          <span><b>FOLIO DETRACCION  :</b> <?php echo e($item->FOLIO_DETRACCION); ?></span>
          <span><b>CUENTA DETRACCION  :</b> <?php echo e($item->CTA_DETRACCION); ?></span>

        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>DOCUMENTO : </b> <?php echo e($item->COD_DOCUMENTO_CTBLE); ?>  </span>
          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL); ?>  </span>
          <span><b>FECHA EMISION  :</b> <?php echo e($item->FEC_EMISION); ?></span>
          <span><b>SERIE  :</b> <?php echo e($item->NRO_SERIE); ?></span>
          <span><b>NRO  :</b> <?php echo e($item->NRO_DOC); ?></span>
          <span><b>MONEDA  :</b> <?php echo e($item->TXT_CATEGORIA_MONEDA); ?></span>
          <span><b>PAGO DETRACCION : </b> <?php echo e($item->TXT_PAGO_DETRACCION); ?>  </span>
          
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">

          <span><b>PAGO TOTAL (OSIRIS) : </b> <?php echo e($item->TOTAL_PAGADO); ?>  </span>
          <span><b>MONTO ACUMULADO PAGO (OSIRIS) : </b> <?php echo e($item->TOTAL_PAGOS_ACUMULADOS); ?>  </span>

          <span><b>DETRACCION PAGADA (OSIRIS) : </b> <?php echo e($item->DETRACCION_PAGADA); ?>  </span>
          <span><b>MONTO DETRACION PAGO (OSIRIS) : </b> <?php echo e($item->MONTO_DETRACCION_PAGADO); ?>  </span>
          <span><b>HABILITACION (OSIRIS) : </b> <?php echo e($item->COD_HABILITACION_DETRACCION); ?>  </span>

          <span><b>PAGO SUNAT : </b> <?php echo e($item->mto_deposito_desc); ?>  </span>
          <span><b>USUARIO SUNAT : </b> <?php echo e($item->cod_usuario_sol); ?>  </span>

        </td>

        <td>
          <b>
            <?php echo e(number_format(round($item->MONTO_DETRACCION_RED,4), 4, '.', ',')); ?>

          </b>
        </td>

        <td>

            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="<?php echo e($item->ID_DOCUMENTO); ?> input_asignar selectfolio"
                id="<?php echo e($item->ID_DOCUMENTO); ?>"
                <?php if(isset($entregable_sel)  && $item->FOLIO_DETRACCION_RESERVA==$entregable_sel->FOLIO): ?> checked <?php endif; ?>>

              <label  for="<?php echo e($item->ID_DOCUMENTO); ?>"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="<?php echo e($item->ID_DOCUMENTO); ?>"
              ></label>
            </div>
            <!-- <?php if($item->CREAR_FOLIO=='NO'): ?> -->
            <!-- <?php endif; ?> -->
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