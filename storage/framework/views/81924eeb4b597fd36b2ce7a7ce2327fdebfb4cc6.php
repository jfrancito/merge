<div class="card shadow-sm mb-4">

  <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            LISTA ORDEN DE PEDIDO
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>ID PEDIDO</th>
                        <th>FECHA</th>
                        <th>MES</th>
                        <th>AÑO</th>
                        <th>TIPO PEDIDO</th>
                        <th>SOLICITA</th>
                        <th>AREA</th>
                        <th>AUTORIZA</th>
                        <th>APRUEBA GER</th>
                        <th>APRUEBA ADM</th>
                        <th>GLOSA</th>
                        <th>ESTADO</th>
                        <th>VER DETALLE</th>
                        <th>ARCHIVO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listapedido; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($item['COD_ESTADO'] === 'ETM0000000000006'&& trim($item['COD_USUARIO_MODIF_AUD']) === trim($cod_usuario_modifica)): ?>

                        <tr class="align-middle">
                            <td><?php echo e($item['ID_PEDIDO']); ?></td>
                            <td><?php echo e($item['FEC_PEDIDO']); ?></td>
                            <td><?php echo e($item['TXT_NOMBRE']); ?></td>
                            <td><?php echo e($item['COD_ANIO']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_TIPO_PEDIDO']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_TRABAJADOR_SOLICITA']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_AREA']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_TRABAJADOR_AUTORIZA']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_TRABAJADOR_APRUEBA_GER']); ?></td>
                            <td class="col-nombre"><?php echo e($item['TXT_TRABAJADOR_APRUEBA_ADM']); ?></td>
                            <td><?php echo e($item['TXT_GLOSA']); ?></td>
                            <td><?php echo $__env->make('comprobante.ajax.estadospedido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></td>
                            <td class="text-center">
                                <div class="grupo-acciones">

                                    <!-- VER DETALLE (SIEMPRE VISIBLE) -->
                                    <button
                                        class="btn btn-sm btn-primary ver-detalle-pedido"
                                        data-id="<?php echo e($item['ID_PEDIDO']); ?>">
                                        <i class="fa fa-eye me-1"></i> Detalle
                                    </button>
                                </div>
                            </td>
                            <td class="align-center-tb">
                                <?php if($item['MULTI_ARCHIVOS'] != ''): ?>
                                    <?php 
                                        $archivos_raw = explode(' [SEP] ', $item['MULTI_ARCHIVOS']);
                                        $archivos = [];
                                        foreach($archivos_raw as $ar) {
                                            $partes = explode(' [FLD] ', $ar);
                                            if(count($partes) == 2) {
                                                $archivos[] = ['nombre' => $partes[0], 'url' => $partes[1]];
                                            }
                                        }
                                     ?>

                                    <?php if(count($archivos) > 1): ?>
                                        <!-- MÚLTIPLES ARCHIVOS: DROPDOWN -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-download"></i> Archivos <span class="caret"></span>
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
                                        <!-- UN SOLO ARCHIVO -->
                                        <a href="<?php echo e(url('descargar-archivo-informe/'.base64_encode($archivos[0]['url']))); ?>"
                                           class="btn btn-xs btn-success"
                                           title="Descargar: <?php echo e($archivos[0]['nombre']); ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .pedido-card {
        border-radius: 6px;
        border: none;
    }

    .pedido-header {
        background: linear-gradient(90deg, #1d3a6d, #2c4f91);
        color: #fff;
        font-weight: 600;
        padding: 14px 18px;
        font-size: 15px;
        border-radius: 6px 6px 0 0;
    }

    .table thead th {
        background: #f3f5f9;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    /* GENERAL */
    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }

    /* ===============================
       COLUMNAS CON 2 LÍNEAS
       =============================== */

    .col-nombre {
        max-width: 140px;
        white-space: normal !important;
        word-break: break-word;
        line-height: 1.2;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .col-glosa {
        max-width: 180px;
        white-space: normal !important;
        word-break: break-word;
        line-height: 1.2;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===============================
       BOTONES (SE QUEDAN IGUAL)
       =============================== */

    .grupo-acciones {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .grupo-acciones .btn {
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>












