<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    $total_mn = 0.0000;
    $total_me = 0.0000;
 ?>
<style type="text/css">
    h1{
        text-align: center;
    }
    .footerho{
        border: 1px solid #000000;
        background: #4285f4;
        color: #fff;
        font-weight: bold;
    }
    .tablaho{
        border: 1px solid #000000;
        background: #1d3a6d;
        color:#fff;
        font-weight: bold;
    }
    .center{
        text-align: center;
    }
</style>
<table>
    <thead>
    <tr>
        <th class="center tablaho" colspan="<?php echo e(count($centros_comercial) + 5); ?>">INDUAMERICA COMERCIAL</th>
    </tr>
    <tr>
        <th class="center tablaho">CÓDIGO</th>
        <th class="center tablaho">ENVASES</th>

        <?php $__currentLoopData = $centros_comercial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th class="center tablaho"><?php echo e('CANT. '.$centro['NOM_CENTRO']); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <th class="center tablaho">PRECIO UNITARIO</th>
        <th class="center tablaho">MONTO</th>
        <th class="center tablaho">% PORCENTAJE</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $compras_comercial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item['COD_PRODUCTO']); ?></td>
            <td><?php echo e($item['NOM_PRODUCTO']); ?></td>

            <?php $__currentLoopData = $centros_comercial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td style="text-align: right"><?php echo e(number_format($item[$centro1['COD_CENTRO']], 2, '.', '')); ?></td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <td style="text-align: right"><?php echo e(number_format($item['PRE_CON_IGV'], 2, '.', '')); ?></td>
            <td style="text-align: right"><?php echo e(number_format($item['TOTAL'], 2, '.', '')); ?></td>

            <td style="text-align: right"><?php echo e(number_format((($item['TOTAL'] * 100 ) / $total_comercial), 2, '.', '')); ?></td>

        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <tfoot>
    <tr>
        <th class="center footerho" colspan="2">TOTAL</th>

        <?php $__currentLoopData = $centros_comercial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th class="footerho" style="text-align: right"><?php echo e(number_format($centro2['MONTO'], 2, '.', '')); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <th class="center footerho" ></th>
        <th class="footerho" style="text-align: right"><?php echo e(number_format($total_comercial, 2, '.', '')); ?></th>
        <th class="footerho" style="text-align: right"><?php echo e(number_format($total_porcentaje_comercial, 2, '.', '')); ?></th>
    </tr>
    </tfoot>
</table>

</html>
