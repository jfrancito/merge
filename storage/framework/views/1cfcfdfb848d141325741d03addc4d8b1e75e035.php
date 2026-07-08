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
        <th>TIPO PEDIDO</th>
        <th>CENTRO</th>
        <th>ESTADO</th>
        <th>USUARIO SOLICITA</th>
        <th>APRUEBA JEFE COMPRAS</th>
        <th>GLOSA</th>
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
            <td><?php echo e($item->TXT_TRABAJADOR_APRUEBA_ADM ?: '—'); ?></td>
            <td><?php echo e($item->TXT_GLOSA); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO); ?></td>
            <td><?php echo e($item->ID_PEDIDO_CONSOLIDADO_GENERAL); ?></td>
            <td class="align-center-tb">
                <?php if(isset($item->MULTI_ARCHIVOS) && $item->MULTI_ARCHIVOS != ''): ?>
                    <?php 
                        $archivos_raw = explode(' [SEP] ', $item->MULTI_ARCHIVOS);
                        $archivos = [];
                        foreach($archivos_raw as $ar) {
                            $partes = explode(' [FLD] ', $ar);
                            if(count($partes) == 2) {
                                $archivos[] = ['nombre' => $partes[0], 'url' => $partes[1]];
                            }
                        }
                     ?>

                    <?php if(count($archivos) > 1): ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download"></i> Archivo <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $arch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url('descargar-archivo-informe/'.base64_encode($arch['url']))); ?>" target="_blank">
                                            <?php echo e(($index + 1) . '. ' . $arch['nombre']); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php elseif(count($archivos) == 1): ?>
                        <a href="<?php echo e(url('descargar-archivo-informe/'.base64_encode($archivos[0]['url']))); ?>"
                           class="btn btn-xs btn-success"
                           target="_blank"
                           title="Descargar: <?php echo e($archivos[0]['nombre']); ?>">
                            <i class="fa fa-download"></i> Archivo
                        </a>
                    <?php endif; ?>
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
