<div tabindex="0" class="panel panel-default panel-contrast pnldetallesdocumentos">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
    </div>
    <div class="panel-body panel-body-contrast">
        <table id="tblactivos" class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>FECHA EMISION</th>
                <th>DOCUMENTO</th>
                <th>TIPO DOCUMENTO</th>
                <th>PROVEEDOR</th>
                <th>CONTRATO</th>
                <th>MONEDA CONTRATO</th>
                <th>TOTAL</th>
                <th>ASIENTO</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $tdetliquidaciongastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="filalg filalgvalidar <?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?> <?php if($index == 0): ?> activofl <?php endif; ?>"
                    data_valor="<?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?>" data_asiento_cabecera="<?php echo e($item->TXT_CENTRO); ?>"
                    data_asiento_detalle="<?php echo e($item->TOKEN); ?>" data_valor_id="<?php echo e($item->BUSQUEDAD); ?>">
                    <td><?php echo e(date_format(date_create($item->FECHA_EMISION), 'd/m/Y')); ?></td>
                    <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </td>
                    <td><?php echo e($item->TXT_TIPODOCUMENTO); ?></td>
                    <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
                    <td><?php echo e($item->COD_CONTRATO); ?></td>
                    <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
                    <td><?php echo e($item->TOTAL); ?></td>
                    <td><?php if($item->BUSQUEDAD === 1): ?> GENERADO <?php else: ?> NO GENERADO <?php endif; ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="total_xml" name="total_xml"
           value=""/>
</div>
