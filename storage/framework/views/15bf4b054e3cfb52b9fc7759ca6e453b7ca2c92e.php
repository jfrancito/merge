<table id="tabla-consolidados-aprobados" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap">
  <thead class="background-th-azul">
    <tr>
      <th class="text-center" style="width: 40px;">
          <input type="checkbox" id="check-all-consolidados">
      </th>
      <th class="text-center">ID CONSOLIDADO</th>
      <th>EMPRESA</th>
      <th>CENTRO</th>
      <th class="text-center">FEC PEDIDO</th>
      <th class="text-center">PERIODO</th>
      <th>FAMILIA</th>
      <th class="text-center">ESTADO</th>
      <th class="text-center">ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $lista_aprobados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $detalles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php  
            $item = $detalles->first(); 
            $familias = $detalles->unique('COD_CATEGORIA_FAMILIA')->pluck('NOM_CATEGORIA_FAMILIA')->implode(', ');
         ?>
        <tr class="fila-consolidado-ap-aprobado" data-id="<?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?>" style="cursor: pointer;">
            <td class="text-center" onclick="event.stopPropagation();">
                <input type="checkbox" class="chk-consolidado" value="<?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?>" data-centro="<?php echo e($item->NOM_CENTRO); ?>" data-familia="<?php echo e($familias); ?>">
            </td>
            <td class="text-center"><?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?></td>
            <td><?php echo e($item->NOM_EMPR); ?></td>
            <td><?php echo e($item->NOM_CENTRO); ?></td>
            <td class="text-center"><?php echo e(date('d-m-Y', strtotime($item->FEC_PEDIDO))); ?></td>
            <td class="text-center"><?php echo e($item->TXT_NOMBRE); ?></td>
            <td><?php echo e($familias); ?></td>
            <td class="text-center">
                <span class="label label-success" style="background-color: #27ae60;">
                    <?php echo e($item->TXT_ESTADO); ?>

                </span>
            </td>
            <td class="text-center">
                <a href="<?php echo e(url('/exportar-excel-consolidado/'.$item->ID_PEDIDO_CONSOLIDADO)); ?>" 
                   class="btn btn-sm btn-success" 
                   title="Exportar Excel"
                   style="border-radius: 4px; padding: 4px 8px;">
                    <i class="mdi mdi-file-excel"></i> Excel
                </a>
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
