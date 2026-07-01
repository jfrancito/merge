<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>DOCUMENTO</th>
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->id); ?>">

        <td><b>CONTRATO</b></td>
        <td><?php echo e($item->COD_DOCUMENTO_CTBLE); ?></td>
        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
        <td><?php echo e($funcion->funciones->estorno_referencia($item->COD_DOCUMENTO_CTBLE)); ?></td>
        <td><?php echo e($item->FEC_EMISION); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
        <td><?php echo e($item->CAN_TOTAL); ?></td>
        <td><?php echo e($item->COD_USUARIO_CREA_AUD); ?></td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                  <a href="<?php echo e(url('/detalle-comprobante-provision-gasto-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($item->COD_DOCUMENTO_CTBLE, -9)))); ?>">
                    Integracion de Documento
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