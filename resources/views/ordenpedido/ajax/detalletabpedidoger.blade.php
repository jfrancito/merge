@php
    $cod_usuario_session = Session::get('usuario')->usuarioosiris_id ?? null;
    $mostrarJefe = false;

    foreach($pedillodetalle as $item){
        if(!is_null($item->CAN_MODIF_JEF_AUT)) $mostrarJefe = true;
    }
@endphp

<div class="row">
    <div class="col-md-12">
        <!-- CONTENEDOR PRINCIPAL CON ESTÉTICA CORPORATIVA -->
        <div class="panel panel-default shadow-sm" style="border-radius: 12px; border: 1px solid #e3e6f0; background: #fff; overflow: hidden;">
            
            <!-- ENCABEZADO CORPORATIVO CON FONDO AZUL (GERENCIA) -->
            <div class="panel-heading" style="background: #0f2a52; border-bottom: none; padding: 40px 20px; position: relative; color: white;">
                <div class="text-center">
                    <h1 class="fw-bold" style="color: white; font-size: 28px; margin-bottom: 10px; letter-spacing: -0.5px;">Aprobación de Gerencia</h1>
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-tag me-1" style="color: white;"></i> Pedido: <b>{{ $pedido->ID_PEDIDO }}</b>
                        </span>
                        <span style="color: rgba(255,255,255,0.3);">|</span>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85); font-weight: 500;">
                            <i class="fa fa-calendar me-1" style="color: white;"></i> Fecha: <b>{{ date('d-m-Y', strtotime($pedido->FEC_PEDIDO)) }}</b>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span style="font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500;">
                            <i class="fa fa-clock-o me-1" style="color: white;"></i> Hora Creación: <b>{{ $pedido->FEC_USUARIO_CREA_AUD ? date('H:i:s', strtotime($pedido->FEC_USUARIO_CREA_AUD)) : '—' }}</b>
                        </span>
                    </div>
                    <div class="mt-1">
                        <span style="font-size: 14px; color: rgba(255,255,255,0.7); font-weight: 500;">
                            <i class="fa fa-check-circle-o me-1" style="color: white;"></i> Fec/Hora Aprobación: <b>{{ $pedido->FEC_USUARIO_MODIF_AUD ? date('d-m-Y H:i:s', strtotime($pedido->FEC_USUARIO_MODIF_AUD)) : '—' }}</b>
                        </span>
                    </div>
                </div>
                
                <!-- BOTÓN REGRESAR -->
                <button class="btn-back-corporate-light" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 6px 15px; border-radius: 6px; font-size: 13px; font-weight: 600;" onclick="$('#tab-detalle-pedido-ger').hide(); $('.nav-tabs a[href=\'#ordenpedidoger\']').tab('show');">
                    <i class="fa fa-arrow-left"></i> Volver al listado
                </button>
            </div>

            <div class="panel-body" style="padding: 30px 40px;">
                
                <!-- INFORMACIÓN GENERAL -->
                <div class="row mb-5" style="background: #f8f9fc; border-radius: 10px; padding: 25px; border: 1px solid #edf0f7;">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Solicitante</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;">{{ $pedido->TXT_TRABAJADOR_SOLICITA }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Área / Departamento</label>
                        <p class="mb-0 text-dark fw-bold" style="font-size: 15px;">{{ $pedido->TXT_AREA }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Estado</label>
                        <div>
                            @php $item = ['COD_ESTADO' => $pedido->COD_ESTADO, 'TXT_ESTADO' => $pedido->TXT_ESTADO]; @endphp
                            @include('comprobante.ajax.estadospedido')
                        </div>
                    </div>
                </div>

                <!-- TABLA DE PRODUCTOS (ANCHO COMPLETO) -->
                <div class="table-responsive" style="border-radius: 8px; border: 1px solid #eaecf4;">
                    <table class="table table-hover mb-0" id="tabla-detalle-tab-ger">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th class="text-center" style="width: 50px; color: #000; font-weight: 700;">#</th>
                                <th style="color: #000; font-weight: 700;">Producto</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Tipo</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Original</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Uni. Medida</th>
                                @if($mostrarJefe) <th class="text-center" style="color: #000; font-weight: 700;">Cant. Autoriza Jefe</th> @endif
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Aprob. Gerencia</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Observación</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Precio Unit.</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Total Item</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13.5px; color: #5a5c69;">
                            @php $suma_total_general = 0; @endphp
                            @foreach($pedillodetalle as $index => $detalle)
                                @php
                                    $cant_original = $detalle->CANTIDAD;
                                    $cant_jefe     = $detalle->CAN_MODIF_JEF_AUT;
                                    $cant_ger      = $detalle->CAN_MODIF_GER;

                                    $valor_editar = $cant_ger ?? $cant_jefe ?? $cant_original;
                                    $precio = $detalle->CAN_PRECIO ?? 0;
                                    $subtotal = $valor_editar * $precio;
                                    $suma_total_general += $subtotal;
                                @endphp
                                <tr style="border-bottom: 1px solid #eaecf4;">
                                    <td class="text-center fw-bold text-muted" style="vertical-align: middle;">{{ $index + 1 }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="fw-bold text-dark" style="font-size: 14px; margin-bottom: 4px;">{{ $detalle->NOM_PRODUCTO }}</div>
                                        <span style="background: #edf2ff; color: #4e73df; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #d0dcfc; display: inline-flex; align-items: center;">
                                            <i class="fa fa-tag me-1" style="font-size: 10px;"></i> {{ $detalle->COD_PRODUCTO }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge-corpo {{ $detalle->IND_MATERIAL_SERVICIO == 'M' ? 'bg-light text-primary' : 'bg-light text-warning' }}">
                                            {{ $detalle->IND_MATERIAL_SERVICIO == 'M' ? 'MATERIAL' : 'SERVICIO' }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge" style="background: #f0f3ff; color: #4e73df; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;">{{ (int) $cant_original }}</span>
                                    </td>
                                    <td class="text-center" style="font-weight: 600; color: #333; vertical-align: middle;">
                                        {{ $detalle->NOM_UNIDAD_MEDIDA ?? 'UND' }}
                                    </td>
                                    
                                    @if($mostrarJefe)
                                        <td class="text-center" style="vertical-align: middle;">
                                            <span class="fw-bold text-success" style="font-size: 15px;">{{ (int)$cant_jefe }}</span>
                                        </td>
                                    @endif

                                    <td class="text-center" style="vertical-align: middle; width: 140px;">
                                        @if ($pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000013')
                                            <input type="number" 
                                                   class="form-control text-center input-cantidad-editar input-cantidad-ger-val"
                                                   value="{{ (int)$valor_editar }}" 
                                                   min="0" 
                                                   data-id="{{ $detalle->COD_PRODUCTO }}"
                                                   style="width: 90px; display: inline-block;">
                                        @else
                                            <span class="fw-bold text-dark" style="font-size: 15px;">{{ (int)$valor_editar }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="text-muted" style="min-width: 120px; font-size: 13px;">
                                            {{ $detalle->TXT_OBSERVACION ?: '—' }}
                                        </div>
                                    </td>

                                    <td class="text-center fw-bold cell-precio" data-precio="{{ $precio }}" style="vertical-align: middle;">S/ {{ number_format($precio, 2) }}</td>
                                    <td class="text-center fw-bold text-dark cell-subtotal" style="vertical-align: middle;">S/ {{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8f9fc;">
                                <td colspan="{{ 8 + ($mostrarJefe ? 1 : 0) }}" class="text-right fw-bold text-uppercase" style="padding: 15px; color: #0f2a52;">Total General</td>
                                <td class="text-center fw-bold text-primary total-general-ger" style="padding: 15px; font-size: 18px;">S/ {{ number_format($suma_total_general, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- PANEL DE SEGUIMIENTO (LÍNEA DE TIEMPO) -->
                <!-- PANEL DE SEGUIMIENTO (CENTRADITO Y COMPACTO) -->
                <div class="panel panel-default" style="max-width: 650px; margin: 30px 0 0 0; border-radius: 12px; border: 1px solid #eaecf4; background: #fff; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); overflow: hidden;">
                    <div class="panel-heading" style="background: #f8f9fc; padding: 12px 20px; border-bottom: 1px solid #eaecf4;">
                        <h4 class="fw-bold" style="color: #1d3a6d; font-size: 15px; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-history" style="color: #4e73df;"></i> Línea de Tiempo y Seguimiento del Pedido
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 20px; max-height: 400px; overflow-y: auto;">
                        @if(count($historial) > 0)
                            <div class="timeline-container-op" style="position: relative; padding-left: 30px; padding-right: 5px;">
                                <div class="timeline-line-op" style="position: absolute; top: 0; bottom: 0; left: 15px; width: 2px; background-color: #eaecf4; border-radius: 1px;"></div>
                                @foreach($historial as $index => $log)
                                    @php
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
                                    @endphp
                                    <div class="timeline-item-op" style="position: relative; margin-bottom: 20px; display: flex; flex-direction: column;">
                                        <!-- Icon Badge -->
                                        <div class="timeline-badge-op" style="position: absolute; left: -30px; width: 28px; height: 28px; border-radius: 50%; background-color: {{ $iconBg }}; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 1;">
                                            <i class="{{ $iconClass }}" style="color: white; font-size: 12px;"></i>
                                        </div>
                                        <!-- Panel Content -->
                                        <div class="timeline-panel-op" style="background: #f8f9fc; border: 1px solid #eaecf4; border-radius: 8px; padding: 12px 15px; transition: all 0.2s ease-in-out;">
                                            <div class="timeline-header-op" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; border-bottom: 1px dashed #eaecf4; padding-bottom: 8px; margin-bottom: 8px; gap: 8px;">
                                                <span class="timeline-title-op" style="font-size: 14px; font-weight: 700; color: #1d3a6d;">{{ $log->TIPO }}</span>
                                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                    <span class="timeline-time-op" style="font-size: 14px; font-weight: 800; color: #4e73df; background: #eef2ff; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #d0dcfc;">
                                                        <i class="fa fa-clock-o"></i> {{ date('H:i:s', strtotime($log->FECHA)) }}
                                                    </span>
                                                    <span class="text-dark" style="font-size: 13px; font-weight: 700; background: #f1f3f9; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #e2e8f0; color: #333 !important;">
                                                        <i class="fa fa-calendar-o text-muted"></i> {{ date('d-m-Y', strtotime($log->FECHA)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="timeline-body-op">
                                                <div class="timeline-user-op" style="font-size: 13px; color: #4e73df; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                                    <i class="fa fa-user" style="color: #858796;"></i>
                                                    <span>{{ $log->USUARIO_NOMBRE }}</span>
                                                </div>
                                                @if(!empty($log->MENSAJE))
                                                    <div class="timeline-message-op alert alert-warning" style="margin-top: 8px; margin-bottom: 0; padding: 8px 12px; border-left: 3px solid #f6c23e; background: #fffdf5; border-radius: 4px; font-size: 12px; color: #856404; font-weight: 600;">
                                                        {{ $log->MENSAJE }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-muted" style="padding: 20px 0;">
                                <i class="fa fa-info-circle fa-2x mb-2 text-info" style="color: #36b9cc; margin-bottom: 10px;"></i>
                                <p class="mb-0" style="font-size: 13px; margin: 0;">No se registran transiciones de historial para este pedido.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- BARRA DE ACCIONES FINAL -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-4" style="border-top: 2px solid transparent; width: 100%; text-align: right; margin-top: 50px !important;">
                    
                    @if ($pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000013')
                        <button class="btn-corpo btn-corpo-warning btn-editar-cantidades-ger" 
                                data-id="{{ $pedido->ID_PEDIDO }}">
                            <i class="fa fa-edit me-1"></i> Editar Cantidades
                        </button>

                        <button class="btn-corpo btn-corpo-success aprobar-pedido-ger" 
                                data-id="{{ $pedido->ID_PEDIDO }}">
                            <i class="fa fa-check-circle me-1"></i> Aprobar Pedido
                        </button>

                        <button class="btn-corpo btn-corpo-danger rechazar-pedido-ger" 
                                data-id="{{ $pedido->ID_PEDIDO }}">
                            <i class="fa fa-times-circle me-1"></i> Rechazar Pedido
                        </button>
                    @endif
                    
                    <button class="btn-corpo btn-corpo-secondary" onclick="$('#tab-detalle-pedido-ger').hide(); $('.nav-tabs a[href=\'#ordenpedidoger\']').tab('show');">
                        Cerrar Detalle
                    </button>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .fw-bold { font-weight: 700; }
    .btn-back-corporate-light { transition: all 0.2s; }
    .btn-back-corporate-light:hover { background: rgba(255, 255, 255, 0.2) !important; transform: translateX(-3px); }
    .badge-corpo { padding: 4px 10px; border-radius: 4px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; }
    .bg-light.text-primary { background-color: #f0f3ff !important; color: #4e73df !important; }
    .bg-light.text-warning { background-color: #fffaf0 !important; color: #f6c23e !important; }
    .btn-corpo { padding: 10px 24px; border-radius: 6px; font-size: 14px; font-weight: 700; border: none; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center; }
    .btn-corpo:hover { transform: translateY(-1px); filter: brightness(0.95); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    .btn-corpo-success { background: #1cc88a; color: white; }
    .btn-corpo-warning { background: #f6c23e; color: white; }
    .btn-corpo-danger { background: #e74a3b; color: white; }
    .btn-corpo-secondary { background: #858796; color: white; }
    .input-cantidad-editar { border-radius: 8px !important; border: 2px solid #eaecf4 !important; background-color: #f8f9fc !important; color: #0f2a52 !important; font-size: 14px !important; font-weight: 800 !important; height: 34px !important; padding: 0px 12px !important; transition: all 0.2s ease-in-out !important; box-shadow: none !important; text-align: center; }
    .gap-3 { gap: 1rem; }

    .timeline-panel-op:hover {
        background: #ffffff !important;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.08) !important;
        border-color: #d1d3e2 !important;
    }
</style>

<script>
$(document).ready(function() {
    const formatter = new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN', minimumFractionDigits: 2 });

    $('.ordenpedidoprincipal').on('input', '.input-cantidad-editar', function() {
        let input = $(this);
        let cantidad = parseFloat(input.val()) || 0;
        let row = input.closest('tr');
        let precio = parseFloat(row.find('.cell-precio').data('precio')) || 0;
        let subtotal = cantidad * precio;
        row.find('.cell-subtotal').text(formatter.format(subtotal).replace('PEN', 'S/'));
        recalcularTotalGeneralGer();
    });

    function recalcularTotalGeneralGer() {
        let totalGeneral = 0;
        $('#tabla-detalle-tab-ger tbody tr').each(function() {
            let row = $(this);
            let input = row.find('.input-cantidad-editar');
            let cantidad = (input.length > 0) ? (parseFloat(input.val()) || 0) : (parseFloat(row.find('td:nth-child(6) span').text()) || 0);
            let precio = parseFloat(row.find('.cell-precio').data('precio')) || 0;
            totalGeneral += (cantidad * precio);
        });
        $('.total-general-ger').text(formatter.format(totalGeneral).replace('PEN', 'S/'));
    }
});
</script>
