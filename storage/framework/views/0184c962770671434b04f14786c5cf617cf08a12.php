<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>LIQUIDACION COMPRA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>ID : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
          <span><b>CODIGO : <?php echo e($item->CODIGO); ?> </b> </span>
          <span><b>FECHA  : <?php echo e($item->FECHA_EMI); ?></b></span>
          <span><b>TRABAJADOR : </b><?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?> </span>
          <span><b>CUENTA : </b><?php echo e($item->TXT_CUENTA); ?> </span>
          <span><b>SUB CUENTA : </b><?php echo e($item->TXT_SUBCUENTA); ?> </span>
          <span><b>CENTRO : </b><?php echo e($item->TXT_CENTRO); ?> </span>
          <span><b>PERIODO : </b><?php echo e($item->TXT_PERIODO); ?> </span>

          <span><b>OSIRIS DOCUMENTO : </b><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?> </span>
          <span><b>OSIRIS ID : </b><?php echo e($item->COD_DOCUMENTO_CTBLE); ?> </span>



          <span><b>TOTAL : </b> <?php echo e($item->TOTAL); ?></span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>JEFE : </b> <?php echo e(date_format(date_create($item->FECHA_JEFE_APRUEBA), 'd-m-Y h:i:s')); ?></span>
          <span><b>ADMINISTRACION : </b> <?php echo e(date_format(date_create($item->FECHA_ADM_APRUEBA), 'd-m-Y h:i:s')); ?></span>
        </td>
        <?php echo $__env->make('comprobante.ajax.estadosfe', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="<?php echo e(url('/detalle-comprobante-lg-validado/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>">
                    Detalle de Registro
                </a>
              </li>

              <li>
                <a href="<?php echo e(url('/liquidacion-viaje-pdf/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8)))); ?>" Target="_blank">
                  Liquidacion de viaje PDF
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