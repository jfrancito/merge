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

                <!-- TABLA DE PRODUCTOS -->
                <div class="table-responsive" style="border-radius: 8px; border: 1px solid #eaecf4;">
                    <table class="table table-hover mb-0" id="tabla-detalle-tab-ger">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th class="text-center" style="width: 50px; color: #000; font-weight: 700;">#</th>
                                <th style="color: #000; font-weight: 700;">Producto</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Tipo</th>
                                <th class="text-center" style="color: #000; font-weight: 700;">Cant. Original</th>
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

                                    $valor_editar = $cant_ger 
                                                    ?? $cant_jefe 
                                                    ?? $cant_original;
                                    
                                    $precio = $detalle->CAN_PRECIO ?? 0;
                                    $subtotal = $valor_editar * $precio;
                                    $suma_total_general += $subtotal;
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 14px; margin-bottom: 4px;">{{ $detalle->NOM_PRODUCTO }}</div>
                                        <span style="background: #edf2ff; color: #4e73df; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #d0dcfc; display: inline-flex; align-items: center;">
                                            <i class="fa fa-barcode me-1" style="font-size: 10px;"></i> {{ $detalle->COD_PRODUCTO }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-corpo {{ $detalle->IND_MATERIAL_SERVICIO == 'M' ? 'bg-light text-primary' : 'bg-light text-warning' }}">
                                            {{ $detalle->IND_MATERIAL_SERVICIO == 'M' ? 'MATERIAL' : 'SERVICIO' }}
                                        </span>
                                    </td>

                                    {{-- CANTIDAD ORIGEN --}}
                                    <td class="text-center">
                                        <span class="badge" style="background: #f0f3ff; color: #4e73df; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;">{{ (int)$cant_original }}</span>
                                    </td>

                                    {{-- CANTIDAD JEFE --}}
                                    @if($mostrarJefe)
                                        <td class="text-center">
                                            <span class="badge" style="background: #e7ffe7; color: #1cc88a; font-weight: 800; border-radius: 6px; font-size: 14px; padding: 6px 12px;">{{ (int)$cant_jefe }}</span>
                                        </td>
                                    @endif

                                    {{-- CANTIDAD GERENCIA (INPUT) --}}
                                    <td class="text-center">
                                        @if ($pedido->COD_TRABAJADOR_APRUEBA_GER == $cod_usuario_session && $pedido->COD_ESTADO == 'ETM0000000000013')
                                            <input type="number" 
                                                   class="form-control text-center input-cantidad-editar input-sm" 
                                                   value="{{ (int)$valor_editar }}"
                                                   min="1"
                                                   data-id="{{ $detalle->ID_PEDIDO }}"
                                                   data-prod="{{ $detalle->COD_PRODUCTO }}"
                                                   style="width: 80px; margin: 0 auto; font-weight: bold; border-color: #d1d3e2;">
                                        @else
                                            <span class="fw-bold text-dark" style="font-size: 15px;">{{ (int)$valor_editar }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="text-muted" style="min-width: 120px; font-size: 13px;">
                                            {{ $detalle->TXT_OBSERVACION ?: '—' }}
                                        </div>
                                    </td>

                                    <td class="text-center fw-bold cell-precio" data-precio="{{ $precio }}">S/ {{ number_format($precio, 2) }}</td>
                                    <td class="text-center fw-bold text-dark cell-subtotal">S/ {{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8f9fc;">
                                <td colspan="{{ 7 + ($mostrarJefe ? 1 : 0) }}" class="text-right fw-bold text-uppercase" style="padding: 15px; color: #0f2a52;">Total General</td>
                                <td class="text-center fw-bold text-primary total-general-ger" style="padding: 15px; font-size: 18px;">S/ {{ number_format($suma_total_general, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
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
