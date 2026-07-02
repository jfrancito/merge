<!-- HEADER -->
<div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b1a3d, #1f2a50); flex: 0 0 auto;">
    <h5 class="modal-title fw-semibold text-center w-100" style="margin: 0;">
        <div class="d-flex justify-content-center align-items-center mb-1">
            <i class="mdi mdi-receipt me-2 opacity-75" style="font-size: 20px;"></i>
            <span style="letter-spacing: 1px;">DETALLE DEL PEDIDO</span>
        </div>

        <span class="d-block fw-medium pedido-numero" style="color: #64b5f6;">
            N° <?php echo e($pedido->ID_PEDIDO ?? ''); ?>

        </span>
    </h5>
</div>

<!-- BODY -->
<div class="modal-body p-0 bg-light" style="flex: 1 1 auto; overflow: hidden; display: flex; flex-direction: column;">

    <div class="table-responsive detalle-scroll" style="flex: 1 1 auto; width: 100%;">
        <table class="table table-hover align-middle mb-0 detalle-table">
            <?php 
                $mostrarJefe = false;
                $mostrarGer = false;
                $mostrarAdm = false;

                foreach ($pedillodetalle as $item) {
                    if (!is_null($item->CAN_MODIF_JEF_AUT)) {
                        $mostrarJefe = true;
                    }
                    if (!is_null($item->CAN_MODIF_GER)) {
                        $mostrarGer = true;
                    }
                    if (!is_null($item->CAN_MODIF_ADM)) {
                        $mostrarAdm = true;
                    }
                }
             ?>

            <thead class="text-white sticky-top detalle-thead">
                <tr class="text-uppercase small">
                    <th class="text-center" style="width: 50px;">#</th>
                    <th style="min-width: 200px;">Producto</th>
                    <th style="width: 120px;">Tipo</th>
                    <th style="width: 150px;">Categoría</th>
                    <th class="text-center" style="width: 80px;">Cant.</th>
                    <?php if($mostrarJefe): ?>
                    <th class="text-center" style="width: 100px;">Cant. Jefe</th> <?php endif; ?>
                    <?php if($mostrarGer): ?>
                    <th class="text-center" style="width: 100px;">Cant. Ger.</th><?php endif; ?>
                    <?php if($mostrarAdm): ?>
                    <th class="text-center" style="width: 100px;">Cant. Adm.</th><?php endif; ?>
                    <th>Observación</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pedillodetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center fw-semibold text-muted">
                            <?php echo e($index + 1); ?>

                        </td>

                        <td class="fw-bold product-name" title="<?php echo e($detalle->NOM_PRODUCTO); ?>">
                            <?php echo e($detalle->NOM_PRODUCTO); ?>

                        </td>

                        <td class="text-secondary small">
                            <?php echo e($detalle->IND_MATERIAL_SERVICIO == 'M' ? 'MATERIAL' : 'SERVICIO'); ?>

                        </td>

                        <td class="text-secondary small" title="<?php echo e($detalle->NOM_CATEGORIA); ?>">
                            <?php echo e($detalle->NOM_CATEGORIA); ?>

                        </td>

                        
                        <td class="text-center">
                            <span class="badge-cantidad">
                                <?php echo e($detalle->CANTIDAD); ?>

                            </span>
                        </td>

                        <?php if($mostrarJefe): ?>
                            <td class="text-center">
                                <?php if(!is_null($detalle->CAN_MODIF_JEF_AUT)): ?>
                                    <span class="badge-cantidad badge-jefe">
                                        <?php echo e($detalle->CAN_MODIF_JEF_AUT); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <?php if($mostrarGer): ?>
                            <td class="text-center">
                                <?php if(!is_null($detalle->CAN_MODIF_GER)): ?>
                                    <span class="badge-cantidad badge-gerencia">
                                        <?php echo e($detalle->CAN_MODIF_GER); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <?php if($mostrarAdm): ?>
                            <td class="text-center">
                                <?php if(!is_null($detalle->CAN_MODIF_ADM)): ?>
                                    <span class="badge-cantidad badge-admin">
                                        <?php echo e($detalle->CAN_MODIF_ADM); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                        <td class="observacion-cell text-muted" title="<?php echo e($detalle->TXT_OBSERVACION); ?>">
                            <?php echo e($detalle->TXT_OBSERVACION ?: '—'); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted fst-italic py-5">
                            <i class="mdi mdi-information-outline" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                            No hay productos en este pedido.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO)): ?>
        <div class="rechazo-container mx-3 my-3">
            <div class="alert alert-danger mb-0" style="border-radius: 10px; border: none; background: #fff5f5; border-left: 4px solid #f44336; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="d-flex align-items-center mb-1">
                    <i class="mdi mdi-close-circle text-danger me-2" style="font-size: 18px;"></i>
                    <h6 class="fw-bold text-danger mb-0" style="font-size: 13px; text-transform: uppercase;">Motivo del Rechazo</h6>
                </div>
                <p class="mb-0 text-dark" style="font-size: 14px; line-height: 1.4;">
                    <?php echo e($pedido->TXT_GLOSA_RECHAZO); ?>

                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal-footer justify-content-center bg-white border-top" style="flex: 0 0 auto; padding: 15px;">
    <button type="button" data-dismiss="modal" class="btn btn-primary modal-close shadow-sm" style="border-radius: 20px; padding: 6px 25px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-size: 11px;">
        Cerrar Detalle
    </button>
</div>

<style>
    .pedido-numero {
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .detalle-scroll {
        max-height: calc(90vh - 160px);
        overflow-y: auto;
        background: #f8f9fa;
    }

    .detalle-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .detalle-scroll::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 10px;
    }

    .detalle-table {
        border-collapse: separate;
        border-spacing: 0 5px;
        padding: 0 15px;
    }

    .detalle-thead th {
        background: #1f2a50;
        color: #fff;
        font-weight: 600;
        font-size: 11px;
        padding: 12px 10px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .detalle-table tbody tr {
        background: #fff;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .detalle-table tbody tr:hover {
        background: #f1f4ff;
        transform: scale(1.005);
    }

    .detalle-table td {
        padding: 10px;
        border: none;
        vertical-align: middle;
        font-size: 13px;
    }

    .product-name {
        color: #2c3e50;
        font-size: 14px !important;
    }

    .badge-cantidad {
        display: inline-block;
        background: #eef2f7;
        color: #334155;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 14px;
        min-width: 40px;
    }

    .badge-jefe { background: #e0f2fe; color: #0369a1; }
    .badge-gerencia { background: #f0fdf4; color: #15803d; }
    .badge-admin { background: #faf5ff; color: #7e22ce; }

    .observacion-cell {
        font-style: italic;
        font-size: 12px;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>