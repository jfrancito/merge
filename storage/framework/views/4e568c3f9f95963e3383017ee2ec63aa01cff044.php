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
      <tr data_requerimiento_id = "<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>NRO CONTRATO : </b> <?php echo e($item->COD_DOCUMENTO_CTBLE); ?>  </span>
          <span><b>DOCUMENTO : </b> <?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?>  </span>
          <span><b>PROVEEDOR  :</b> <?php echo e($item->TXT_EMPR_EMISOR); ?></span>
          <span><b>COMPROBANTE ASOCIADO : </b> <?php echo e($item->NRO_SERIE_DOC); ?> - <?php echo e($item->NRO_DOC_DOC); ?></span>
          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO); ?></span>
          <span><b>FECHA VENCIMIENTO DOC: </b> <?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?>  </span>
          <span><b>FECHA APROBACION ADMIN  :</b><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
          <span><b>MONEDA  :</b><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></span>
          <span><b>ESTADO CANJE  :</b>
            <?php if($item->NRO_SERIE_DOC == ''): ?>
              <span class="badge badge-danger" style="width: 100px;">SIN CANJEAR</span>
            <?php else: ?>
              <span class="badge badge-success" style="width: 100px;">CANJEADO</span>
            <?php endif; ?>
          </span>
          <?php 
            $transferencia    =   $funcion->con_transferencia_itt($item->NRO_ITT);
            $swtran           =   0;
           ?>
          <span><b>TRANSFERENCIA:
            <?php if(count($transferencia)<=0): ?>
                <span class="badge badge-default" style="width: 150px;display: inline-block;">SIN TRANSFERENCIA</span>
            <?php else: ?>
                <?php if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA'): ?>
                  <span class="badge badge-danger" style="width: 150px;display: inline-block;">NO RECEPCIONADO</span>
                  <?php  $swtran           =   1;  ?>
                <?php else: ?>
                  <span class="badge badge-success" style="width: 150px;display: inline-block;"><?php echo e($transferencia->TXT_CATEGORIA_ESTADO_ORDEN); ?></span>
                <?php endif; ?>
            <?php endif; ?>
              </b>
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> <?php echo e($item->IND_MATERIAL_SERVICIO); ?>  </span>
          <span><b>BANCO  :</b><?php echo e($item->TXT_BANCO); ?></span>
          <span><b>SUBIO VOUCHER  :</b>
            <?php if($item->COD_ESTADO_VOUCHER == 'ETM0000000000008'): ?>
              SI
            <?php else: ?>
              NO
            <?php endif; ?>
          </span>
          <span><b>CUENTA DETRACCION: </b> <?php echo e($item->CTA_DETRACCION); ?>  </span>
          <span><b>VALOR DETRACCION  :</b><?php echo e($item->VALOR_DETRACCION); ?></span>
          <span><b>PAGO DETRACCION: </b> <?php echo e($item->TXT_PAGO_DETRACCION); ?>  </span>
<!--           <span><b>NOTA CREDITO  :
            <?php if($item->NC_PROVEEDOR > 0): ?>
              <?php echo e($item->NC_PROVEEDOR); ?>

            <?php else: ?>
              0
            <?php endif; ?></b>
          </span> -->

          <span>
            <b>DEUDA:
              <?php if($item->CAN_DEUDA > 0): ?>
               <span data_id_doc = '<?php echo e($item->COD_EMPR_EMISOR); ?>' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;display: inline-block;">DEUDA</span>
              <?php else: ?>
                <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
              <?php endif; ?>
            </b>
          </span>


        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <span><b><?php echo e(number_format(round($item->TOTAL_VENTA_ORIG, 4), 4, '.', ',')); ?></b></span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b><?php echo e($item->MONTO_DETRACCION_RED); ?></b>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b><?php echo e(number_format(round($item->MONTO_ANTICIPO_DESC  + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',')); ?></b>
        </td>

        <td class="center neto_pagar"><b> <?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
        <td>

            <?php if(count($transferencia)>0): ?>
                <?php if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA'): ?>
                  <span class="badge badge-danger" style="width: 150px;display: inline-block;">NO RECEPCIONADO</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($item->NRO_SERIE_DOC != '' && $item->NC_PROVEEDOR<=0 && $swtran==0): ?>
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?> input_asignar selectfolio"
                id="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>" 
                <?php if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO): ?> checked <?php endif; ?>>

              <label  for="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>"
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