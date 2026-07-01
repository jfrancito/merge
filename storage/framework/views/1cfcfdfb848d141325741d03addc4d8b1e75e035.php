<table id="reporteordenpedidoestado"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
    <tr>
        <th>ID PEDIDO</th>
        <th>AREA</th>
        <th>FECHA PEDIDO</th>
        <th>AÑO</th>
        <th>PERIODO</th>
        <th>CENTRO</th>
        <th>ESTADO</th>
        <th>APRUEBA JEFE COMPRAS</th>
        <th>CONSOLIDADO SEDE</th>
        <th>CONSOLIDADO GENERAL</th>
        <th>ARCHIVO</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $resultado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="fila-pedido" 
            data-id="<?php echo e($item->ID_PEDIDO); ?>" 
            style="cursor: pointer;"
            title="Doble clic para ver detalle">
            <td><?php echo e($item->ID_PEDIDO); ?></td>
            <td><?php echo e($item->NOM_AREA); ?></td>
            <td class="align-center-tb"><?php echo e($item->FEC_PEDIDO); ?></td>
            <td><?php echo e($item->COD_ANIO); ?></td>
            <td><?php echo e($item->NOM_PERIODO); ?></td>
            <td><?php echo e($item->NOM_CENTRO); ?></td>
            <td><?php echo e($item->TXT_ESTADO); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_ADM ?: '—'); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO_GENERAL); ?></td>
            <td class="align-center-tb">
                <?php if(!empty($item->URL_ARCHIVO)): ?>
                    <a href="<?php echo e(url('descargar-archivo-informe/'.base64_encode($item->URL_ARCHIVO))); ?>"
                       class="btn btn-xs btn-success"
                       title="Descargar archivo">
                        <i class="fa fa-download"></i>
                    </a>
                <?php else: ?>
                    <span class="text-muted">—</span>
                <?php endif; ?>
            </td>
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
