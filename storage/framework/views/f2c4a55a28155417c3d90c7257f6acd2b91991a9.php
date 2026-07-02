<table id="reporteliquidaciones"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%">
    <?php 
        $total_monto = 0.0000;
     ?>
    <thead class="background-th-azul">
    <tr>
        <th>EMPRESA</th>
        <th>CENTRO</th>
        <th>TRABAJADOR</th>
        <th>FECHA LIQUIDACIÓN</th>
        <th>MES NRO</th>
        <th>MES</th>
        <th>NRO LIQUIDACIÓN</th>
        <th>MONEDA</th>
        <th>PROVEEDOR</th>
        <th>TIPO DOCUMENTO</th>
        <th>NRO DOCUMENTO</th>
        <th>FECHA DOCUMENTO</th>
        <th>PRODUCTO</th>
        <th>CATEGORÍA PRODUCTO</th>
        <th>ESTADO DOCUMENTO</th>
        <th>MONTO (SOLES)</th>
        <th>CENTRO COSTO</th>
        <th>GLOSA</th>
        <th>USUARIO REGISTRO</th>
        <th>AUTORIZA</th>

    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $listaLiquidaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item['EMP_SISTEMA']); ?></td>
            <td><?php echo e($item['NOM_CENTRO']); ?></td>
            <td><?php echo e($item['TRABAJADOR']); ?></td>
            <td class="align-center-tb">
                <?php if(!empty($item['FECHA_LIQUIDACION'])): ?>
                    <?php echo e(\Carbon\Carbon::parse($item['FECHA_LIQUIDACION'])->format('d/m/Y')); ?>

                <?php endif; ?>
            </td>
            <td class="align-center-tb"><?php echo e($item['MES_NRO']); ?></td>
            <td><?php echo e($item['MES']); ?></td>
            <td><?php echo e($item['NRO_LIQUIDACION']); ?></td>
            <td><?php echo e($item['MONEDA']); ?></td>
            <td><?php echo e($item['PROVEEDOR']); ?></td>
            <td><?php echo e($item['TIPO_DOCUMENTO']); ?></td>
            <td><?php echo e($item['NRO_DOCUMENTO']); ?></td>
            <td class="align-center-tb">
                <?php if(!empty($item['FEC_EMISION'])): ?>
                    <?php echo e(\Carbon\Carbon::parse($item['FEC_EMISION'])->format('d/m/Y')); ?>

                <?php endif; ?>
            </td>
            <td><?php echo e($item['PRODUCTO']); ?></td>
            <td><?php echo e($item['CATEGORIA_PRODUSTO']); ?></td>
            <td><?php echo e($item['ESTADO_DOCUMENTO']); ?></td>
            <td class="align-right-tb"><?php echo e(number_format($item['MONTO_DOCUMENTO_SOLES'], 2, '.', ',')); ?></td>
            <td><?php echo e($item['CENTRO_COSTO']); ?></td>
            <td><?php echo e($item['GLOSA']); ?></td>
            <td><?php echo e($item['USUARIO_REGISTRO']); ?></td>
            <td><?php echo e($item['AUTORIZA']); ?></td>            
        </tr>
        <?php 
            $total_monto += $item['MONTO_DOCUMENTO_SOLES'];
         ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>

    <?php if($total_monto > 0): ?>
        <tfoot>
        <tr style="background: #4285f4; color: white; text-align: left">
            <th colspan="16" class="center footerho">TOTAL</th>
            <th class="align-right-tb"><?php echo e(number_format($total_monto, 2, '.', ',')); ?></th>
            <th colspan="3"></th>
        </tr>
        </tfoot>
    <?php endif; ?>
</table>

<?php if(isset($ajax)): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
<?php endif; ?>
