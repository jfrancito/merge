<div tabindex="0" class="panel panel-default panel-contrast pnldetallesdocumentos">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARACION DE VALE Y LIQUIDACION
    </div>
    <div class="panel-body panel-body-contrast">
        <table id="tblactivos" class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>VALE</th>
                <th>LIQUIDACION</th>
                <th>MONTO VALE</th>
                <th>MONTO LIQUIDACION</th>
                <th>DIFERENCIA</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                // Calcular sumas antes del bucle
                $sumaMonto = 0;
                $sumaTotal = 0;
                $sumaRestante = 0;
             ?>
            
            <?php $__currentLoopData = $listaarendirlg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    // Acumular las sumas
                    $sumaMonto += $item['monto'];
                    $sumaTotal += $item['TOTAL'];
                    $sumaRestante += $item['restante'];
                 ?>
                <tr>
                    <td><?php echo e($item['concepto']); ?></td>
                    <td><?php echo e($item['TXT_PRODUCTO']); ?></td>
                    <td><?php echo e(number_format($item['monto'], 2)); ?></td>
                    <td><?php echo e(number_format($item['TOTAL'], 2)); ?></td>
                    <td><?php echo e(number_format($item['restante'], 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <tr style="font-weight: bold; background-color: #f5f5f5;">
                <td></td>
                <td></td>
                <td><b><?php echo e(number_format($sumaMonto, 2)); ?></b></td>
                <td><b><?php echo e(number_format($sumaTotal, 2)); ?></b></td>
                <td><b><?php echo e(number_format($sumaRestante, 2)); ?></b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
