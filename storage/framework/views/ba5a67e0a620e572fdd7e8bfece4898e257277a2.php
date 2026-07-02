<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>
      <th>DESCUENTO</th>
      <th>PERCEPCCION</th>
      <th>NETO A PAGAR</th>
      <th>
<!--         <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input  type="checkbox"
                  class="todo_asignar input_asignar"
                  id="todo_asignar"
          >
          <label  for="todo_asignar"
                  data-atr = "todas_asignar"
                  class = "checkbox_asignar"                    
                  name="todo_asignar"
            ></label>
        </div> -->
      </th>
    </tr>
  </thead>
  <tbody>

    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr 
        data_requerimiento_id = "<?php echo e($item->COD_ORDEN); ?>"
        class="toptable" 
        >
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>NRO OC : </b> <?php echo e($item->COD_ORDEN); ?>  </span>
          <span><b>PROVEEDOR  :</b> <?php echo e($item->TXT_EMPR_CLIENTE); ?></span>
          <p style="margin-bottom: 1px;"><b>COMPROBANTE ASOCIADO : </b> <?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?> 
            <span style="display: inline;color: #34a853;cursor: pointer;font-size: 18px;" class="mdi mdi-eye mdidetdoc" data_doc="<?php echo e($item->COD_ORDEN); ?>"></span> </p>
          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO); ?></span>
          <span><b>FECHA VENCIMIENTO DOC: </b> <?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?>  </span>
          <span><b>FECHA APROBACION ADMIN  :</b><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
          <span><b>MONEDA  :</b><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></span>

          <?php if($permiso_editar_cuenta==1): ?>
            <div class="tools ver_cuenta_bancaria_oc select" 
              data_prefijo_id = "<?php echo e(substr($item->COD_ORDEN, 0,6)); ?>"
              data_orden_id = "<?php echo e(Hashids::encode(substr($item->COD_ORDEN, -10))); ?>"
              style="cursor: pointer;width: 100px;margin-bottom: 12px;"> 
              <span class="label label-success">Ver Cuenta</span>
            </div>
            <div class="tools agregar_cuenta_bancaria_oc select" 
              data_prefijo_id = "<?php echo e(substr($item->COD_ORDEN, 0,6)); ?>"
              data_orden_id = "<?php echo e(Hashids::encode(substr($item->COD_ORDEN, -10))); ?>"
              style="cursor: pointer;width: 100px;"> 
              <span class="label label-success">Agregar Cuenta</span>
            </div>
          <?php endif; ?>



        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> <?php echo e($item->IND_MATERIAL_SERVICIO); ?>  </span>
          <span><b>BANCO  :</b><?php echo e($item->TXT_BANCO); ?></span>
          <span><b>CUENTA  :</b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></span>

          <span><b>SUBIO VOUCHER  :</b>
            <?php if($item->COD_ESTADO_VOUCHER == 'ETM0000000000008'): ?>
              SI
            <?php else: ?>
              NO
            <?php endif; ?>
          </span>
          <span><b>ORDEN INGRESO  :</b><?php echo e($item->COD_TABLA_ASOC); ?></span>
          <span><b>PAGO DETRACCION  :</b><?php echo e($item->TXT_PAGO_DETRACCION); ?></span>
          <span><b>AVISO NOTA CREDITO  :
            <?php if($item->NC_PROVEEDOR > 0): ?>
              <?php echo e($item->NC_PROVEEDOR); ?>

            <?php else: ?>
              0
            <?php endif; ?></b>
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>IMPORTE: </b> <?php echo e($item->CAN_TOTAL); ?>  </span>
          <span><b>ANTICIPO  :</b><?php echo e(round($item->MONTO_ANTICIPO_DESC,4) + round($item->MONTO_ANTICIPO_DESC_OTROS,4)); ?></span>
          <span><b>NOTA CREDITO  :</b><?php echo e(round($item->MONTO_NC,4)); ?></span>
          <span><b>COMPENSACION  :</b><?php echo e(round($item->COMPENSACION,2)); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>OBLIGACION: </b>           
            <?php if($item->CAN_DETRACCION>0): ?>
              DETRACION
            <?php else: ?>
              <?php if($item->CAN_RETENCION>0): ?>
                RETENCION IGV
              <?php else: ?>
                <?php if($item->CAN_IMPUESTO_RENTA>0): ?>
                  RETENCION 4TA CATEGORIA
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>  
          </span>
          <span><b>DESCUENTO: </b> <?php echo e($item->CAN_DSCTO); ?></span>
          <span><b>TOTAL DESCUENTO: </b>           
            <?php if($item->CAN_DETRACCION>0): ?>
              <?php echo e($item->CAN_DETRACCION); ?>

            <?php else: ?>
              <?php if($item->CAN_RETENCION>0): ?>
                <?php echo e($item->CAN_RETENCION); ?>

              <?php else: ?>
                <?php if($item->CAN_IMPUESTO_RENTA>0): ?>
                  <?php echo e($item->CAN_IMPUESTO_RENTA); ?>

                <?php else: ?>
                  0.00                
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          </span>
        </td>
        <td>
          <b>
            <?php echo e(number_format(round($item->PERCEPCION,4), 4, '.', ',')); ?>

          </b>
        </td>
        <td class="center neto_pagar">
          <b>
            <?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?>

          </b>
        </td>
        <td>
            <?php if($item->NC_PROVEEDOR<=0): ?>
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="<?php echo e($item->COD_ORDEN); ?> input_asignar selectfolio"
                id="<?php echo e($item->COD_ORDEN); ?>"
                <?php if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO): ?> checked <?php endif; ?>>

              <label  for="<?php echo e($item->COD_ORDEN); ?>"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="<?php echo e($item->COD_ORDEN); ?>"
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