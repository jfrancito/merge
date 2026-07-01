<table id="divsaldos" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
    <tr>
        <th>COD_DIV</th>
        <th>NRO_DIV</th>
        <th>FECHA_DIV</th>
        <th>TITULAR_DIV</th>
        <th>IMPORTE_DIV</th>
        <th>TOTAL_NCI</th>
        <th>COBRADO</th>
        <th>POR_COBRAR</th>
        <th>COD_DOCUMENTO_CTBLE</th>
        <th>TXT_CATEGORIA_TIPO_DOC</th>
        <th>NRO_SERIE</th>
        <th>NRO_DOC</th>
        <th>FECHA_DOC</th>
        <th>FECHA_VEN_DOC</th>
        <th>TITULAR_DOC</th>
        <th>ALTERNATIVO_DOC</th>
        <th>TOTAL_DOC</th>
        <th>TOTAL_NC</th>
        <th>TOTAL_ND</th>
        <th>CAN_AMORTIZADO</th>
        <th>FILA</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $listareporte; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item['COD_DIV']); ?></td>
            <td><?php echo e($item['NRO_DIV']); ?></td>
            <td><?php echo e($item['FECHA_DIV']); ?></td>
            <td><?php echo e($item['TITULAR_DIV']); ?></td>
            <td><?php echo e(number_format($item['IMPORTE_DIV'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['TOTAL_NCI'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['COBRADO'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['POR_COBRAR'], 4, '.', ',')); ?></td>
            <td><?php echo e($item['COD_DOCUMENTO_CTBLE']); ?></td>
            <td><?php echo e($item['TXT_CATEGORIA_TIPO_DOC']); ?></td>
            <td><?php echo e($item['NRO_SERIE']); ?></td>
            <td><?php echo e($item['NRO_DOC']); ?></td>
            <td><?php echo e($item['FECHA_DOC']); ?></td>
            <td><?php echo e($item['FECHA_VEN_DOC']); ?></td>
            <td><?php echo e($item['TITULAR_DOC']); ?></td>
            <td><?php echo e($item['ALTERNATIVO_DOC']); ?></td>
            <td><?php echo e(number_format($item['TOTAL_DOC'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['TOTAL_NC'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['TOTAL_ND'], 4, '.', ',')); ?></td>
            <td><?php echo e(number_format($item['CAN_AMORTIZADO'], 4, '.', ',')); ?></td>
            <td><?php echo e($item['FILA']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php if(isset($ajax)): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
<?php endif; ?>
