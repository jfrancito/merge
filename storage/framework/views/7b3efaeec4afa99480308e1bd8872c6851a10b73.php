<table class="table table-striped table-bordered table-hover td-color-borde td-padding-7">
    <thead>
        <tr>
            <th colspan="12" style="text-align: center; font-size: 14px; font-weight: bold; background-color: #f1f5f9;">
                DETALLE CONSOLIDADO: <?php echo e($id_consolidado); ?>

            </th>
        </tr>
        <tr>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>COD PRODUCTO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>PRODUCTO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>UNIDAD MEDIDA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CANTIDAD</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>STOCK</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>RESERVADO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>DIFERENCIA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CAN COMPRAR</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>FAMILIA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>CENTRO</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>AREA</b></th>
            <th style="background-color: #1e3a8a; color: #ffffff;"><b>OBSERVACION</b></th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $listadetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->COD_PRODUCTO); ?></td>
                <td><?php echo e($item->NOM_PRODUCTO); ?></td>
                <td><?php echo e($item->NOM_CATEGORIA_MEDIDA); ?></td>
                <td style="text-align: right;"><?php echo e(number_format($item->CANTIDAD, 2)); ?></td>
                <td style="text-align: right;"><?php echo e(number_format($item->STOCK, 2)); ?></td>
                <td style="text-align: right;"><?php echo e(number_format($item->RESERVADO, 2)); ?></td>
                <td style="text-align: right;"><?php echo e(number_format($item->DIFERENCIA, 2)); ?></td>
                <td style="text-align: right; font-weight: bold;">
                    <?php echo e(number_format(!is_null($item->CAN_COMPRADA) ? $item->CAN_COMPRADA : ($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA), 2)); ?>

                </td>
                <td><?php echo e($item->NOM_CATEGORIA_FAMILIA); ?></td>
                <td><?php echo e($item->TXT_CENTROS); ?></td>
                <td><?php echo e($item->TXT_AREAS); ?></td>
                <td><?php echo e($item->TXT_GLOSAS); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
