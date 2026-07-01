<table id="p_tablatransito" 
       class="<?php echo e($tipo == 'EXC' ? '' : 'table table-bordered table-hover td-color-borde td-padding-7 display nowrap'); ?>">
    <thead class="background-th-azul">
 
    <tr>
        <th style="text-align: center;">Sede Origen</th>
        <th style="text-align: center;">Almacén Origen</th>
        <th style="text-align: center;">Sede Destino</th>
        <th style="text-align: center;">Almacén Destino</th>
        <th style="text-align: center;">N° Transferencia</th>
        <th style="text-align: center;">GRR</th>
        <th style="text-align: center;">Código</th>
        <th style="text-align: center;">Producto</th>
        <th style="text-align: center;">Cantidad</th>
        <th style="text-align: center;">Costo</th>
        <th style="text-align: center;">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        if (!is_array($listatransito) || empty($listatransito)) {
            $listatransito = []; // Asegurar que sea un array vacío si no es válido
        }

        $total_kg = 0;
        $totales_sl = 0;

        foreach ($listatransito as $item) {    
            $total_kg += $item['STK_50'];
            $totales_sl += $item['COSTO_TOTAL'];

     ?>
        <tr>
            <td style="text-align: left;"><?php echo e($item['ORIGEN']); ?></td>
            <td style="text-align: left;"><?php echo e($item['ALMACEN_ORIGEN']); ?></td>
            <td style="text-align: left;"><?php echo e($item['DESTINO']); ?></td>
            <td style="text-align: left;"><?php echo e($item['ALMACEN_DESTINO']); ?></td>
            <td style="text-align: left;"><?php echo e($item['COD_ORDEN']); ?></td>
            <td style="text-align: left;"><?php echo e($item['TXT_GRR']); ?></td>
            <td style="text-align: left;"><?php echo e($item['COD_PRODUCTO']); ?></td>
            <td style="text-align: left;"><?php echo e($item['NOM_PRODUCTO']); ?></td>
            <td style="text-align: right;"><?php echo e(number_format($item['STK_50'], 2, '.', '')); ?></td>
            <td style="text-align: right;"><?php echo e(number_format($item['CAN_PRECIO_COSTO'], 2, '.', '')); ?></td>
            <td style="text-align: right;"><?php echo e(number_format($item['COSTO_TOTAL'], 2, '.', '')); ?></td>
        </tr>
    <?php    
        }
     ?>    

        <tr>
            <td  colspan="8" style="text-align: right;" class="negrita">TOTAL</td>
            <td style="text-align: right;" class="negrita"><?php echo e(number_format($total_kg, 2, '.', '')); ?></td>
            <td style="text-align: right;"></td>
            <td style="text-align: right;" class="negrita"><?php echo e(number_format($totales_sl, 2, '.', '')); ?></td>
        </tr>    
        
    </tbody>

</table>