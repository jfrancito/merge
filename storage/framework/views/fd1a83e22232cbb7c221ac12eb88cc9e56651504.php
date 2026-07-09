<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    h1{
        text-align: center;
    }
    .subtitulos{
        font-weight: bold;
        font-style: italic;
    }
    .titulotabla{
        background: #4285f4;
        color: #fff;
        font-weight: bold;
    }
    .tabladp{
        background: #bababa;
        color:#fff;
    }
    .negrita{
        font-weight: bold;
    }
    .center{
        text-align: center;
    }
</style>
<table>
    <thead>
    <tr>
        <th class='tabladp'>ID PEDIDO</th>
        <th class='tabladp'>AREA</th>
        <th class='tabladp'>FECHA PEDIDO</th>
        <th class='tabladp'>AÑO</th>
        <th class='tabladp'>PERIODO</th>
        <th class='tabladp'>TIPO PEDIDO</th>
        <th class='tabladp'>CENTRO</th>
        <th class='tabladp'>ESTADO</th>
        <th class='tabladp'>USUARIO SOLICITA</th>
        <th class='tabladp'>JEFE AUTORIZA</th>
        <th class='tabladp'>APRUEBA GERENCIA DE AREA</th>
        <th class='tabladp'>APRUEBA GERENCIA ADM O JEFE DE COMPRAS</th>
        <th class='tabladp'>CONSOLIDADO SEDE</th>
        <th class='tabladp'>CONSOLIDADO GENERAL</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $resultado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->ID_PEDIDO); ?></td>
            <td><?php echo e($item->NOM_AREA); ?></td>
            <td><?php echo e($item->FEC_PEDIDO); ?></td>
            <td><?php echo e($item->COD_ANIO); ?></td>
            <td><?php echo e($item->NOM_PERIODO); ?></td>
            <td><?php echo e($item->TXT_TIPO_PEDIDO); ?></td>
            <td><?php echo e($item->NOM_CENTRO); ?></td>
            <td>
                <?php if(isset($item->COD_ESTADO) && $item->COD_ESTADO == 'ETM0000000000015' && isset($item->COD_TRABAJADOR_APRUEBA_ADM) && $item->COD_TRABAJADOR_APRUEBA_ADM == 'IITR000000000391'): ?>
                    POR APROBAR GERENCIA ADM
                <?php else: ?>
                    <?php echo e($item->TXT_ESTADO); ?>

                <?php endif; ?>
            </td>
            <td><?php echo e($item->TXT_TRABAJADOR_SOLICITA); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_AUTORIZA ?: '—'); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_GER ?: '—'); ?></td>
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_ADM ?: '—'); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO_GENERAL); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</html>

