<?php 
    $cod_usuario_session = Session::get('usuario')->usuarioosiris_id ?? null;
 ?>

<div class="row">
    <div class="col-md-12">
        <!-- CONTENEDOR PRINCIPAL CON ESTÉTICA CORPORATIVA -->
        <div class="panel panel-default shadow-sm"
            style="border-radius: 12px; border: 1px solid #e3e6f0; background: #fff; overflow: hidden;">

            <!-- ENCABEZADO CORPORATIVO CON FONDO AZUL -->
            <div class="panel-heading"
                style="background: #1d3a6d; border-bottom: none; padding: 40px 20px; position: relative; color: white;">
                <div class="text-center">
                    <h1 class="fw-bold"
                        style="color: white; font-size: 28px; margin-bottom: 10px; letter-spacing: -0.5px;">Detalle de
                        Orden de Pedido</h1>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-tag me-1" style="color: white;"></i> ID: <b><?php echo e($pedido->ID_PEDIDO); ?></b>
                        </span>
                        <span style="color: rgba(255,255,255,0.3);">|</span>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-calendar me-1" style="color: white;"></i> Fecha:
                            <b><?php echo e(date('d-m-Y', strtotime($pedido->FEC_PEDIDO))); ?></b>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span style="font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500;">
                            <i class="fa fa-clock-o me-1" style="color: white;"></i> Hora Creación: <b><?php echo e($pedido->FEC_USUARIO_CREA_AUD ? date('H:i:s', strtotime($pedido->FEC_USUARIO_CREA_AUD)) : '—'); ?></b>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span style="font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500;">
                            <i class="fa fa-check-circle-o me-1" style="color: white;"></i> Fec/Hora Aprobación: <b><?php echo e($pedido->FEC_USUARIO_MODIF_AUD ? date('d-m-Y H:i:s', strtotime($pedido->FEC_USUARIO_MODIF_AUD)) : '—'); ?></b>
                        </span>
                    </div>
                </div>

                <!-- BOTÓN REGRESAR DISCRETO EN LA DERECHA -->
                <button class="btn-back-corporate-light"
                    style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 6px 15px; border-radius: 6px; font-size: 13px; font-weight: 600;"
                    onclick="$('#tab-detalle-pedido-aut').hide(); $('.nav-tabs a[href=\'#ordenpedidoautoriza\']').tab('show');">
                    <i class="fa fa-arrow-left"></i> Volver al listado
                </button>
            </div>

            <div class="panel-body" style="padding: 30px 40px;">

                <!-- INFORMACIÓN GENERAL DEL PEDIDO -->
                <div class="row mb-5"
                    style="background: #f8f9fc; border-radius: 10px; padding: 25px; border: 1px solid #edf0f7;">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block"
                            style="letter-spacing: 0.5px;">Solicitante</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;">
                            <?php echo e($pedido->TXT_TRABAJADOR_SOLICITA); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block"
                            style="letter-spacing: 0.5px;">Área / Departamento</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;"><?php echo e($pedido->TXT_AREA); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block"
                            style="letter-spacing: 0.5px;">Estado Actual</label>
                        <div>
                            <?php  $item = ['COD_ESTADO' => $pedido->COD_ESTADO, 'TXT_ESTADO' => $pedido->TXT_ESTADO];  ?>
                            <?php echo $__env->make('comprobante.ajax.estadospedido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE PRODUCTOS (ANCHO COMPLETO) -->
                <div class="table-responsive" style="border-radius: 8px; border: 1px solid #eaecf4;">
                    <table class="table table-hover mb-0" id="tabla-detalle-tab-aut">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th class="text-center" style="width: 50px; color: #000; font-weight: 700;">#</th>
                                <th style="color: #000; font-weight: 700;">Producto</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Tipo</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Origen</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Uni. Medida</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Autoriza Jefe</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Observación</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Precio Unit.</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Total Item</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13.5px; color: #5a5c69;">
                            <?php  $suma_total_general = 0;  ?>
                            <?php $__currentLoopData = $pedillodetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $cantidad_mostrar = $detalle->CAN_MODIF_ADM
                                        ?? $detalle->CAN_MODIF_GER
                                        ?? $detalle->CAN_MODIF_JEF_AUT
                                        ?? $detalle->CANTIDAD;

                                    $precio = $detalle->CAN_PRECIO ?? 0;
                                    $subtotal = $cantidad_mostrar * $precio;
                                    $suma_total_general += $subtotal;
                                 ?>
                                <tr style="border-bottom: 1px solid #eaecf4;">
                                    <td class="text-center fw-bold" style="color: #1d3a6d; vertical-align: middle;"><?php echo e($index + 1); ?></td>
                                    <td style="vertical-align: middle;">
                                        <div style="font-weight: 600; color: #2e2f37;"><?php echo e($detalle->NOM_PRODUCTO); ?></div>
                                        <small class="text-muted">Cód: <?php echo e($detalle->COD_PRODUCTO); ?></small>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php if($detalle->IND_MATERIAL_SERVICIO == 'M'): ?>
                                            <span class="badge-corpo bg-light text-primary">Material</span>
                                        <?php else: ?>
                                            <span class="badge-corpo bg-light text-warning">Servicio</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center fw-bold" style="vertical-align: middle;"><?php echo e((int) $detalle->CANTIDAD); ?></td>
                                    <td class="text-center text-uppercase" style="vertical-align: middle;"><?php echo e($detalle->NOM_UNIDAD_MEDIDA ?? 'UND'); ?></td>
                                    
                                    <!-- Cantidad Autorizada (Editable o Texto) -->
                                    <td class="text-center" style="vertical-align: middle; width: 140px;">
                                        <?php if($pedido->COD_TRABAJADOR_AUTORIZA == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000010'): ?>
                                            <input type="number" 
                                                   class="form-control input-cantidad-editar input-cantidad-aut-val" 
                                                   value="<?php echo e((int)$cantidad_mostrar); ?>" 
                                                   min="0"
                                                   data-id="<?php echo e($detalle->COD_PRODUCTO); ?>"
                                                   style="width: 90px; display: inline-block;">
                                        <?php else: ?>
                                            <span class="fw-bold text-success" style="font-size: 14px;"><?php echo e((int)$cantidad_mostrar); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td style="vertical-align: middle;">
                                        <div class="text-wrap" style="max-width: 180px; font-size: 12px; color: #858796;">
                                            <?php echo e($detalle->TXT_OBSERVACION ?: '—'); ?>

                                        </div>
                                    </td>
                                    <td class="text-center fw-bold" style="vertical-align: middle;">S/ <?php echo e(number_format($precio, 2)); ?></td>
                                    <td class="text-center fw-bold text-dark cell-subtotal" style="vertical-align: middle;">S/ <?php echo e(number_format($subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8f9fc;">
                                <td colspan="8" class="text-right fw-bold text-uppercase"
                                    style="padding: 15px; color: #1d3a6d;">Total General</td>
                                <td class="text-center fw-bold text-primary total-general-aut" style="padding: 15px; font-size: 18px;">S/
                                    <?php echo e(number_format($suma_total_general, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- GLOSA DE RECHAZO (ESTILO DISCRETO PERO CLARO) -->
                <?php if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO)): ?>
                    <div class="alert alert-danger mt-4"
                        style="background: #fff; border: 1px solid #f5c6cb; border-left: 5px solid #d9534f; border-radius: 6px;">
                        <h6 class="fw-bold text-danger mb-1" style="font-size: 14px;">Motivo del Rechazo:</h6>
                        <p class="mb-0" style="font-size: 14px; color: #000 !important;"><?php echo e($pedido->TXT_GLOSA_RECHAZO); ?>

                        </p>
                    </div>
                <?php endif; ?>

                <!-- PANEL DE SEGUIMIENTO (LÍNEA DE TIEMPO) -->
                <!-- PANEL DE SEGUIMIENTO (CENTRADITO Y COMPACTO) -->
                <div class="panel panel-default" style="max-width: 650px; margin: 30px 0 0 0; border-radius: 12px; border: 1px solid #eaecf4; background: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); overflow: hidden;">
                    <div class="panel-heading" style="background: #f8f9fc; padding: 12px 20px; border-bottom: 1px solid #eaecf4;">
                        <h4 class="fw-bold" style="color: #1d3a6d; font-size: 15px; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-history" style="color: #4e73df;"></i> Línea de Tiempo y Seguimiento del Pedido
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 20px; max-height: 400px; overflow-y: auto;">
                        <?php if(count($historial) > 0): ?>
                            <div class="timeline-container-op" style="position: relative; padding-left: 30px; padding-right: 5px;">
                                <div class="timeline-line-op" style="position: absolute; top: 0; bottom: 0; left: 15px; width: 2px; background-color: #eaecf4; border-radius: 1px;"></div>
                                <?php $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $iconClass = 'fa fa-check';
                                        $iconBg = '#1cc88a'; // verde por defecto
                                        
                                        $tipoUpper = strtoupper($log->TIPO);
                                        if (strpos($tipoUpper, 'RECHAZADO') !== false || strpos($tipoUpper, 'ANULA') !== false) {
                                            $iconClass = 'fa fa-times';
                                            $iconBg = '#e74a3b'; // rojo
                                        } elseif (strpos($tipoUpper, 'GENERADO') !== false) {
                                            $iconClass = 'fa fa-plus';
                                            $iconBg = '#4e73df'; // azul
                                        } elseif (strpos($tipoUpper, 'EMITIDO') !== false) {
                                            $iconClass = 'fa fa-paper-plane-o';
                                            $iconBg = '#36b9cc'; // celeste
                                        } elseif (strpos($tipoUpper, 'AUTORIZADO') !== false || strpos($tipoUpper, 'AUTORIZACIÓN') !== false) {
                                            $iconClass = 'fa fa-thumbs-o-up';
                                            $iconBg = '#f6c23e'; // amarillo
                                        }
                                     ?>
                                    <div class="timeline-item-op" style="position: relative; margin-bottom: 20px; display: flex; flex-direction: column;">
                                        <!-- Icon Badge -->
                                        <div class="timeline-badge-op" style="position: absolute; left: -30px; width: 28px; height: 28px; border-radius: 50%; background-color: <?php echo e($iconBg); ?>; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 1;">
                                            <i class="<?php echo e($iconClass); ?>" style="color: white; font-size: 12px;"></i>
                                        </div>
                                        <!-- Panel Content -->
                                        <div class="timeline-panel-op" style="background: #f8f9fc; border: 1px solid #eaecf4; border-radius: 8px; padding: 12px 15px; transition: all 0.2s ease-in-out;">
                                            <div class="timeline-header-op" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; border-bottom: 1px dashed #eaecf4; padding-bottom: 8px; margin-bottom: 8px; gap: 8px;">
                                                <span class="timeline-title-op" style="font-size: 14px; font-weight: 700; color: #1d3a6d;"><?php echo e($log->TIPO); ?></span>
                                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                    <span class="timeline-time-op" style="font-size: 14px; font-weight: 800; color: #4e73df; background: #eef2ff; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #d0dcfc;">
                                                        <i class="fa fa-clock-o"></i> <?php echo e(date('H:i:s', strtotime($log->FECHA))); ?>

                                                    </span>
                                                    <span class="text-dark" style="font-size: 13px; font-weight: 700; background: #f1f3f9; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #e2e8f0; color: #333 !important;">
                                                        <i class="fa fa-calendar-o text-muted"></i> <?php echo e(date('d-m-Y', strtotime($log->FECHA))); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="timeline-body-op">
                                                <div class="timeline-user-op" style="font-size: 13px; color: #4e73df; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                                    <i class="fa fa-user" style="color: #858796;"></i>
                                                    <span><?php echo e($log->USUARIO_NOMBRE); ?></span>
                                                </div>
                                                <?php if(!empty($log->MENSAJE)): ?>
                                                    <div class="timeline-message-op alert alert-warning" style="margin-top: 8px; margin-bottom: 0; padding: 8px 12px; border-left: 3px solid #f6c23e; background: #fffdf5; border-radius: 4px; font-size: 12px; color: #856404; font-weight: 600;">
                                                        <?php echo e($log->MENSAJE); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted" style="padding: 20px 0;">
                                <i class="fa fa-info-circle fa-2x mb-2 text-info" style="color: #36b9cc; margin-bottom: 10px;"></i>
                                <p class="mb-0" style="font-size: 13px; margin: 0;">No se registran transiciones de historial para este pedido.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- BARRA DE ACCIONES FINAL -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-4"
                    style="border-top: 2px solid #transparent; width: 100%; text-align: right; margin-top: 50px !important;">

                    <?php if($pedido->COD_TRABAJADOR_AUTORIZA == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000010'): ?>
                        <button class="btn-corpo btn-corpo-warning btn-editar-cantidades-aut"
                            data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-edit me-1"></i> Editar Cantidades 
                        </button>

                        <button class="btn-corpo btn-corpo-success autorizar-pedido" data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-check-circle me-1"></i> Autorizar Pedido
                        </button>

                        <button class="btn-corpo btn-corpo-danger rechazar-pedido" data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-times-circle me-1"></i> Rechazar Pedido
                        </button>
                    <?php endif; ?>

                    <button class="btn-corpo btn-corpo-secondary"
                        onclick="$('#tab-detalle-pedido-aut').hide(); $('.nav-tabs a[href=\'#ordenpedidoautoriza\']').tab('show');">
                        Cerrar Detalle
                    </button>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* TIPOGRAFÍA Y COLORES */
    .fw-bold {
        font-weight: 700;
    }

    /* BOTON VOLVER */
    .btn-back-corporate-light {
        transition: all 0.2s;
    }

    .btn-back-corporate-light:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        transform: translateX(-3px);
    }

    /* BADGES Y ETIQUETAS */
    .badge-corpo {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .bg-light.text-primary {
        background-color: #f0f3ff !important;
        color: #4e73df !important;
    }

    .bg-light.text-warning {
        background-color: #fffaf0 !important;
        color: #f6c23e !important;
    }

    /* BOTONES CORPORATIVOS */
    .btn-corpo {
        padding: 10px 24px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-corpo:hover {
        transform: translateY(-1px);
        filter: brightness(0.95);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-corpo:active {
        transform: translateY(0);
    }

    .btn-corpo-success {
        background: #1cc88a;
        color: white;
    }

    .btn-corpo-warning {
        background: #f6c23e;
        color: white;
    }

    .btn-corpo-danger {
        background: #e74a3b;
        color: white;
    }

    .btn-corpo-secondary {
        background: #858796;
        color: white;
    }

    /* INPUT CANTIDAD MODERNO */
    .input-cantidad-editar {
        border-radius: 8px !important;
        border: 2px solid #eaecf4 !important;
        background-color: #f8f9fc !important;
        color: #1d3a6d !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        height: 34px !important;
        /* Altura similar al badge */
        padding: 0px 12px !important;
        transition: all 0.2s ease-in-out !important;
        box-shadow: none !important;
        text-align: center;
    }

    .input-cantidad-editar:focus {
        border-color: #4e73df !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1) !important;
        transform: scale(1.05);
    }

    .gap-3 {
        gap: 1rem;
    }

    .timeline-panel-op:hover {
        background: #ffffff !important;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08) !important;
        border-color: #d1d3e2 !important;
    }
</style>