<div class="table-responsive">
    <table
        class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
        cellspacing="0" width="100%" id="lista-consolidado-general-terminado">

        <thead class="background-th-azul">
            <tr>
                <th>ID CONSOLIDADO GENERAL</th>
                <th>EMPRESA</th>
                <th>FECHA CONSOLIDADO GENERAL</th>
                <th>MES</th>
                <th>FAMILIA</th>
                <th>ESTADO</th>
            </tr>
        </thead>

        <tbody>
       <?php $__currentLoopData = $listaordenpedidogeneralterminado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consolidado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php  $cabecera = $consolidado->first();  ?>

    <tr class="fila-consolidado-general-terminado"
        data-consolidado-general="<?php echo e($cabecera->ID_PEDIDO_CONSOLIDADO_GENERAL); ?>"
        data-familia-cod = '<?php echo e($cabecera->COD_CATEGORIA_FAMILIA); ?>'
        style="cursor: pointer;">
        <td><?php echo e($cabecera->ID_PEDIDO_CONSOLIDADO_GENERAL); ?></td>
        <td><?php echo e($cabecera->NOM_EMPR); ?></td>
        <td><?php echo e($cabecera->FEC_PEDIDO); ?></td>
        <td><?php echo e($cabecera->TXT_NOMBRE); ?></td>
        <td><?php echo e($cabecera->NOM_CATEGORIA_FAMILIA); ?></td>
        <td><?php echo e($cabecera->TXT_ESTADO); ?></td>
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>

    </table>



    <div id="lista-detalle-consolidado-general-container">
        <!-- AQUÍ SE CARGARÁ EL DETALLE POR AJAX -->
    </div>
</div>
