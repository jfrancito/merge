<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ORDEN COMPRA</th>
      <th>FACTURA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->id); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : <?php echo e($item->COD_ORDEN); ?> </b> </span>
          <span><b>FECHA  : <?php echo e($item->FEC_ORDEN); ?></b></span>
          <span><b>DOCUMENTO : </b><?php echo e($item->RUC_PROVEEDOR); ?></span>
          <span><b>PROVEEDOR : </b><?php echo e($item->TXT_EMPR_CLIENTE); ?> </span>
          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL); ?></span>
          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO_UC); ?></span>
          <span><b>FOLIO : </b> <?php echo e($item->FOLIO); ?></span>
          <span><b>BANCO : </b> <?php echo e($item->TXT_CATEGORIA_BANCO); ?></span>

          <span><b>H. OBSERVACION : </b> <?php echo e($item->TXT_OBSERVADO); ?></span>
          <span><b>H. REPARABLE : </b> <?php echo e($item->TXT_REPARABLE); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>AREA : </b> <?php echo e($item->AREA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
          <span><b>PERCEPCION : </b> <?php echo e($item->PERCEPCION); ?></span>
          <span><b>RETENCION : </b> <?php echo e($item->MONTO_RETENCION); ?></span>

        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
          <span><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
          <span><b>ADMINISTRACION : </b> <?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
          <div class="tools ver_cuenta_bancaria_indi select" data_orden_id = "<?php echo e($item->ID_DOCUMENTO); ?>" data_numero_cuenta = "<?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?>" data_banco_codigo = "<?php echo e($item->COD_CATEGORIA_BANCO); ?>"
            style="cursor: pointer;width: 80px;margin-bottom: 5px;"> <span class="label label-success">Ver Cuenta</span></div>


          <?php if($item->IND_REPARABLE == 1 && ( Session::get('usuario')->rol_id == '1CIX00000001' || Session::get('usuario')->rol_id == '1CIX00000019')): ?>
            <div class="tools cambiar_reparable select" data_orden_id = "<?php echo e($item->ID_DOCUMENTO); ?>" 
              style="cursor: pointer;width: 105px;"> <span class="label label-primary">Cambiar reparable</span></div>

          <?php endif; ?>

        </td>

        <?php echo $__env->make('comprobante.ajax.estadosgestion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10)))); ?>">
                    Detalle de Registro
                </a>
              </li>
            </ul>
          </div>
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