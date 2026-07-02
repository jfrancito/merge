<table id="cesii" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" style='width: 100%;'>
    <thead style="background: #1d3a6d; color: white; text-align: center">
    <tr>
        <th>CÓDIGO</th>
        <th>ENVASES</th>

        <?php $__currentLoopData = $centros_internacional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th><?php echo e('CANT. '.$centro['NOM_CENTRO']); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <th>PRECIO UNITARIO</th>
        <th>MONTO</th>
        <th>% PORCENTAJE</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $compras_internacional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item['COD_PRODUCTO']); ?></td>
                <td><?php echo e($item['NOM_PRODUCTO']); ?></td>

                <?php $__currentLoopData = $centros_internacional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td style="text-align: right"><?php echo e(number_format($item[$centro1['COD_CENTRO']], 2, '.', '')); ?></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <td style="text-align: right"><?php echo e(number_format($item['PRE_CON_IGV'], 2, '.', '')); ?></td>
                <td style="text-align: right"><?php echo e(number_format($item['TOTAL'], 2, '.', '')); ?></td>

                <td style="text-align: right"><?php echo e(number_format((($item['TOTAL'] * 100 ) / $total_internacional), 2, '.', '')); ?></td>

            </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <tfoot>
    <tr style="background: #4285f4; color: white; text-align: center">
        <th colspan="2">TOTAL</th>

        <?php $__currentLoopData = $centros_internacional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th style="text-align: right"><?php echo e(number_format($centro2['MONTO'], 2, '.', '')); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <th></th>
        <th style="text-align: right"><?php echo e(number_format($total_internacional, 2, '.', '')); ?></th>
        <th style="text-align: right"><?php echo e(number_format($total_porcentaje_internacional, 2, '.', '')); ?></th>
    </tr>
    </tfoot>
</table>
