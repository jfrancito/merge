<?php $__currentLoopData = $listaordenconsolidado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consolidado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php  
        $cabecera = $consolidado->first(); 
        // Obtener familias únicas para este consolidado
        $familias_unicas = $consolidado->unique('COD_CATEGORIA_FAMILIA')->map(function($item) {
            return [
                'id' => $item->COD_CATEGORIA_FAMILIA,
                'nombre' => $item->NOM_CATEGORIA_FAMILIA
            ];
        })->values();
     ?>

    <tr class="fila-consolidado-generado"
        data-consolidado="<?php echo e($cabecera->ID_PEDIDO_CONSOLIDADO); ?>"
        data-familias="<?php echo e(json_encode($familias_unicas)); ?>"
        style="cursor: pointer;">
        <td><?php echo e($cabecera->ID_PEDIDO_CONSOLIDADO); ?></td>
        <td><?php echo e($cabecera->NOM_EMPR); ?></td>
        <td><?php echo e($cabecera->FEC_PEDIDO); ?></td>
        <td><?php echo e($cabecera->TXT_NOMBRE); ?></td>
        <td><?php echo e($cabecera->NOM_CATEGORIA_FAMILIA); ?></td>
        <td><?php echo e($cabecera->TXT_ESTADO); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
