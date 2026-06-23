<table id="tabla-consolidado-aprueba" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap">
  <thead class="background-th-azul">
    <tr>
      <th>ID CONSOLIDADO</th>
      <th>EMPRESA</th>
      <th>CENTRO</th>
      <th>FEC PEDIDO</th>
      <th>PERIODO</th>
      <th>FAMILIA</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listaconsolidadopedidoap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $detalles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php  
            $item = $detalles->first(); 
            // Obtener familias únicas para este consolidado
            $familias = $detalles->unique('COD_CATEGORIA_FAMILIA')->pluck('NOM_CATEGORIA_FAMILIA')->implode(', ');
         ?>
        <tr class="fila-consolidado-ap" data-id="<?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?>" style="cursor: pointer;">
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?></td>
            <td><?php echo e($item->NOM_EMPR); ?></td>
            <td><?php echo e($item->NOM_CENTRO); ?></td>
            <td><?php echo e(date('d-m-Y', strtotime($item->FEC_PEDIDO))); ?></td>
            <td><?php echo e($item->TXT_NOMBRE); ?></td>
            <td><?php echo e($familias); ?></td>
            <td>
                <span class="label label-warning" style="background-color: #f39c12;">
                    <?php echo e($item->TXT_ESTADO); ?>

                </span>
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
