<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index+1); ?></td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
          <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
          <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
          <span><b>FECCHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
          <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
          <span><b>PROVEEDOR : </b><?php echo e($item->RZ_PROVEEDOR); ?> </span>
          
          <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
        </td>


        <td class="cell-detail sorting_1" style="position: relative;">



          <span><b>USUARIO CONTACTO : </b> <?php echo e($item->TXT_CONTACTO); ?></span>
          <span><b>FOLIO : </b> <?php echo e($item->FOLIO); ?></span>
          <span><b>H. OBSERVACION : </b> <?php echo e($item->TXT_OBSERVADO); ?></span>
          <span><b>H. REPARABLE : </b> <?php echo e($item->TXT_REPARABLE); ?></span>


        </td>



        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
          <?php if($item->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
            <span><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
          <?php endif; ?>
          <span><b>ADMINISTRACION : </b> <?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></span>
          <div class="tools ver_cuenta_bancaria_indi select" data_orden_id = "<?php echo e($item->ID_DOCUMENTO); ?>" data_numero_cuenta = "<?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?>" data_banco_codigo = "<?php echo e($item->COD_CATEGORIA_BANCO); ?>"
            style="cursor: pointer;width: 80px;"> <span class="label label-success">Ver Cuenta</span></div>
          
        </td>
        <?php echo $__env->make('comprobante.ajax.estadosgestion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/detalle-comprobante-oc-validado-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">
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

