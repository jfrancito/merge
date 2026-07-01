<?php 
    $cod_usuario_session = Session::get('usuario')->usuarioosiris_id ?? null;
    $mostrarJefe = false;
    $mostrarGer  = false;

    foreach($pedillodetalle as $item){
        if(!is_null($item->CAN_MODIF_JEF_AUT)) $mostrarJefe = true;
        if(!is_null($item->CAN_MODIF_GER)) $mostrarGer = true;
    }
 ?>

<div class="row">
    <div class="col-md-12">
        <!-- CONTENEDOR PRINCIPAL CON ESTÉTICA CORPORATIVA -->
        <div class="panel panel-default shadow-sm" style="border-radius: 12px; border: 1px solid #e3e6f0; background: #fff; overflow: hidden;">
            
            <!-- ENCABEZADO CORPORATIVO CON FONDO AZUL -->
            <div class="panel-heading" style="background: #1d3a6d; border-bottom: none; padding: 40px 20px; position: relative; color: white;">
                <div class="text-center">
                    <h1 class="fw-bold" style="color: white; font-size: 28px; margin-bottom: 10px; letter-spacing: -0.5px;">Detalle de Orden de Pedido</h1>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-tag me-1" style="color: white;"></i> ID: <b><?php echo e($pedido->ID_PEDIDO); ?></b>
                        </span>
                        <span style="color: rgba(255,255,255,0.3);">|</span>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-calendar me-1" style="color: white;"></i> Fecha: <b><?php echo e(date('d-m-Y', strtotime($pedido->FEC_PEDIDO))); ?></b>
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
                <button class="btn-back-corporate-light" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 6px 15px; border-radius: 6px; font-size: 13px; font-weight: 600;" onclick="$('#tab-detalle-pedido-adm').hide(); $('.nav-tabs a[href=\'#ordenpedidoadm\']').tab('show');">
                    <i class="fa fa-arrow-left"></i> Volver al listado
                </button>
            </div>

            <div class="panel-body" style="padding: 30px 40px;">
                
                <!-- INFORMACIÓN GENERAL DEL PEDIDO -->
                <div class="row mb-5" style="background: #f8f9fc; border-radius: 10px; padding: 25px; border: 1px solid #edf0f7;">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Solicitante</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;"><?php echo e($pedido->TXT_TRABAJADOR_SOLICITA); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Área / Departamento</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;"><?php echo e($pedido->TXT_AREA); ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Estado Actual</label>
                        <div>
                            <?php  $item = ['COD_ESTADO' => $pedido->COD_ESTADO, 'TXT_ESTADO' => $pedido->TXT_ESTADO];  ?>
                            <?php echo $__env->make('comprobante.ajax.estadospedido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE PRODUCTOS -->
                <div class="table-responsive" style="border-radius: 8px; border: 1px solid #eaecf4;">
                    <table class="table table-hover mb-0" id="tabla-detalle-tab-adm">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th class="text-center" style="width: 50px; color: #000; font-weight: 700;">#</th>
                                <th style="color: #000; font-weight: 700;">Producto</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Tipo</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Origen</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Uni. Medida</th>
                                <?php if($mostrarJefe): ?> <th class="text-center" style="color: #000; font-weight: 700;">Cant. Autoriza Jefe</th> <?php endif; ?>
                                <?php if($mostrarGer): ?> <th class="text-center" style="color: #000; font-weight: 700;">Cant. Gerencia</th> <?php endif; ?>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Aprueba Admin</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Observación</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Precio Unit.</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Total Item</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13.5px; color: #5a5c69;">
                            <?php  $suma_total_general = 0;  ?>
                            <?php $__currentLoopData = $pedillodetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $cant_original = $detalle->CANTIDAD;
                                    $cant_jefe     = $detalle->CAN_MODIF_JEF_AUT;
                                    $cant_ger      = $detalle->CAN_MODIF_GER;
                                    $cant_adm      = $detalle->CAN_MODIF_ADM;

                                    $valor_editar = $cant_adm 
                                                    ?? $cant_ger 
                                                    ?? $cant_jefe 
                                                    ?? $cant_original;
                                    
                                    $precio = $detalle->CAN_PRECIO ?? 0;
                                    $subtotal = $cant_original * $precio; // El subtotal se calcula sobre la original o sobre la final? Usualmente sobre original
                                    $suma_total_general += $subtotal;
                                 ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?php echo e($index + 1); ?></td>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 14px; margin-bottom: 4px;"><?php echo e($detalle->NOM_PRODUCTO); ?></div>
                                        <span style="background: #edf2ff; color: #4e73df; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #d0dcfc; display: inline-flex; align-items: center;">
                                            <i class="fa fa-tag me-1" style="font-size: 10px;"></i> <?php echo e($detalle->COD_PRODUCTO); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-corpo <?php echo e($detalle->IND_MATERIAL_SERVICIO == 'M' ? 'bg-light text-primary' : 'bg-light text-warning'); ?>">
                                            <?php echo e($detalle->IND_MATERIAL_SERVICIO == 'M' ? 'MATERIAL' : 'SERVICIO'); ?>

                                        </span>
                                    </td>

                                    
                                    <td class="text-center">
                                        <span class="badge" style="background: #f0f3ff; color: #4e73df; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;"><?php echo e((int)$cant_original); ?></span>
                                    </td>

                                    <td class="text-center" style="font-weight: 600; color: #333;">
                                        <?php echo e($detalle->NOM_CATEGORIA ?: '—'); ?>

                                    </td>

                                    
                                    <?php if($mostrarJefe): ?>
                                        <td class="text-center">
                                            <span class="badge" style="background: #e7ffe7; color: #1cc88a; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;"><?php echo e((int)$cant_jefe); ?></span>
                                        </td>
                                    <?php endif; ?>

                                    
                                    <?php if($mostrarGer): ?>
                                        <td class="text-center">
                                            <span class="badge" style="background: #fff4e5; color: #f6c23e; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;"><?php echo e((int)$cant_ger); ?></span>
                                        </td>
                                    <?php endif; ?>

                                    
                                    <td class="text-center">
                                        <?php if($pedido->COD_TRABAJADOR_APRUEBA_ADM == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000015'): ?>
                                            <input type="number" 
                                                   class="form-control text-center input-cantidad-editar input-sm" 
                                                   value="<?php echo e((int)$valor_editar); ?>"
                                                   min="1"
                                                   data-id="<?php echo e($detalle->ID_PEDIDO); ?>"
                                                   data-prod="<?php echo e($detalle->COD_PRODUCTO); ?>"
                                                   style="width: 80px; margin: 0 auto; font-weight: bold; border-color: #d1d3e2;">
                                        <?php else: ?>
                                            <span class="fw-bold text-dark" style="font-size: 15px;"><?php echo e((int)$valor_editar); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="text-muted" style="min-width: 120px; font-size: 13px;">
                                            <?php echo e($detalle->TXT_OBSERVACION ?: '—'); ?>

                                        </div>
                                    </td>

                                    <td class="text-center fw-bold cell-precio" data-precio="<?php echo e($precio); ?>">S/ <?php echo e(number_format($precio, 2)); ?></td>
                                    <td class="text-center fw-bold text-dark cell-subtotal">S/ <?php echo e(number_format($subtotal, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8f9fc;">
                                <td colspan="<?php echo e(8 + ($mostrarJefe ? 1 : 0) + ($mostrarGer ? 1 : 0)); ?>" class="text-right fw-bold text-uppercase" style="padding: 15px; color: #1d3a6d;">Total General</td>
                                <td class="text-center fw-bold text-primary total-general-adm" style="padding: 15px; font-size: 18px;">S/ <?php echo e(number_format($suma_total_general, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO)): ?>
                    <div class="alert alert-danger mt-4" style="background: #fff; border: 1px solid #f5c6cb; border-left: 5px solid #d9534f; border-radius: 6px;">
                        <h6 class="fw-bold text-danger mb-1" style="font-size: 14px;">Motivo del Rechazo:</h6>
                        <p class="mb-0" style="font-size: 14px; color: #000 !important;"><?php echo e($pedido->TXT_GLOSA_RECHAZO); ?></p>
                    </div>
                <?php endif; ?>

                <!-- BARRA DE ACCIONES FINAL -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-4" style="border-top: 2px solid transparent; width: 100%; text-align: right; margin-top: 50px !important;">
                    
                    <?php if($pedido->COD_TRABAJADOR_APRUEBA_ADM == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000015'): ?>
                        <button class="btn-corpo btn-corpo-warning btn-editar-cantidades-adm" 
                                data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-edit me-1"></i> Editar Cantidades
                        </button>

                        <button class="btn-corpo btn-corpo-success aprobar-pedido-adm" 
                                data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-check-circle me-1"></i> Aprobar Pedido
                        </button>

                        <button class="btn-corpo btn-corpo-danger rechazar-pedido-adm" 
                                data-id="<?php echo e($pedido->ID_PEDIDO); ?>">
                            <i class="fa fa-times-circle me-1"></i> Rechazar Pedido
                        </button>
                    <?php endif; ?>
                    
                    <button class="btn-corpo btn-corpo-secondary" onclick="$('#tab-detalle-pedido-adm').hide(); $('.nav-tabs a[href=\'#ordenpedidoadm\']').tab('show');">
                        Cerrar Detalle
                    </button>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* TIPOGRAFÍA Y COLORES */
    .fw-bold { font-weight: 700; }
    
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
    .bg-light.text-primary { background-color: #f0f3ff !important; color: #4e73df !important; }
    .bg-light.text-warning { background-color: #fffaf0 !important; color: #f6c23e !important; }

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
    .btn-corpo:active { transform: translateY(0); }

    .btn-corpo-success { background: #1cc88a; color: white; }
    .btn-corpo-warning { background: #f6c23e; color: white; }
    .btn-corpo-danger { background: #e74a3b; color: white; }
    .btn-corpo-secondary { background: #858796; color: white; }

    /* INPUT CANTIDAD MODERNO */
    .input-cantidad-editar {
        border-radius: 8px !important;
        border: 2px solid #eaecf4 !important;
        background-color: #f8f9fc !important;
        color: #1d3a6d !important;
        font-size: 14px !important;
        font-weight: 800 !important;
        height: 34px !important;
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

    /* TABLA */
    #tabla-detalle-tab-adm tbody tr:hover {
        background-color: #fcfcfc;
    }
    
    .gap-3 { gap: 1rem; }
</style>

<script>
$(document).ready(function() {
    // Formateador de moneda
    const formatter = new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN',
        minimumFractionDigits: 2
    });

    // Evento al cambiar la cantidad
    $('.ordenpedidoprincipal').on('input', '.input-cantidad-editar', function() {
        let input = $(this);
        let cantidad = parseFloat(input.val()) || 0;
        let row = input.closest('tr');
        let precio = parseFloat(row.find('.cell-precio').data('precio')) || 0;
        
        // Calcular subtotal del item
        let subtotal = cantidad * precio;
        
        // Actualizar celda de subtotal
        row.find('.cell-subtotal').text(formatter.format(subtotal).replace('PEN', 'S/'));

        // Recalcular Total General
        recalcularTotalGeneralAdm();
    });

    function recalcularTotalGeneralAdm() {
        let totalGeneral = 0;
        $('#tabla-detalle-tab-adm tbody tr').each(function() {
            let row = $(this);
            let input = row.find('.input-cantidad-editar');
            let cantidad = 0;
            
            if (input.length > 0) {
                cantidad = parseFloat(input.val()) || 0;
            } else {
                // Si no es editable, obtener el valor del texto
                cantidad = parseFloat(row.find('td:nth-child(7) span').text()) || 0;
            }
            
            let precio = parseFloat(row.find('.cell-precio').data('precio')) || 0;
            totalGeneral += (cantidad * precio);
        });

        // Actualizar el footer
        $('.total-general-adm').text(formatter.format(totalGeneral).replace('PEN', 'S/'));
    }
});
</script>
