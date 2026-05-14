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
                            <i class="fa fa-tag me-1" style="color: white;"></i> ID: <b>{{ $pedido->ID_PEDIDO }}</b>
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
                </div>
                
                <!-- BOTÓN REGRESAR DISCRETO EN LA DERECHA (ESTILO CLARO) -->
                <button class="btn-back-corporate-light" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 6px 15px; border-radius: 6px; font-size: 13px; font-weight: 600;" onclick="$('#tab-detalle-pedido').hide(); $('.nav-tabs a[href=\'#ordenpedido\']').tab('show');">
                    <i class="fa fa-arrow-left"></i> Volver al listado
                </button>
            </div>

            <div class="panel-body" style="padding: 30px;">
                
                <!-- TABLA DE PRODUCTOS (SIN TOCAR ESTRUCTURA) -->
                <div class="table-responsive" style="border-radius: 8px; border: 1px solid #eaecf4;">
                    <table class="table align-middle mb-0" id="tabla-detalle-tab">
                        <thead style="background: #f8f9fc;">
                            <tr style="font-size: 12px; color: #4e73df; font-weight: 700; text-transform: uppercase;">
                                <th class="text-center py-3 ps-4">#</th>
                                <th class="py-3">Descripción del Producto</th>
                                <th class="py-3">Categoría</th>
                                <th class="text-center py-3">Tipo</th>
                                <th class="text-center py-3">Cantidad</th>
                                
                                @php
                                    $mostrarJefe = false; $mostrarGer = false; $mostrarAdm = false;
                                    foreach ($pedillodetalle as $item) {
                                        if (!is_null($item->CAN_MODIF_JEF_AUT)) $mostrarJefe = true;
                                        if (!is_null($item->CAN_MODIF_GER)) $mostrarGer = true;
                                        if (!is_null($item->CAN_MODIF_ADM)) $mostrarAdm = true;
                                    }
                                @endphp

                                @if($mostrarJefe) <th class="text-center py-3">Cant. Jefe</th> @endif
                                @if($mostrarGer) <th class="text-center py-3">Cant. Gerencia</th> @endif
                                @if($mostrarAdm) <th class="text-center py-3">Cant. Admin</th> @endif
                                
                                <th class="py-3 pe-4">Observación</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13.5px; color: #5a5c69;">
                            @forelse($pedillodetalle as $index => $detalle)
                                <tr style="border-bottom: 1px solid #eaecf4;">
                                    <td class="text-center py-3 ps-4 fw-bold" style="color: #1d3a6d;">{{ $index + 1 }}</td>
                                    <td class="py-3">
                                        <div style="font-weight: 600; color: #2e2f37;">{{ $detalle->NOM_PRODUCTO }}</div>
                                        <small class="text-muted">Cód: {{ $detalle->COD_PRODUCTO }}</small>
                                    </td>
                                    <td class="py-3">{{ $detalle->NOM_CATEGORIA }}</td>
                                    <td class="text-center py-3">
                                        @if($detalle->IND_MATERIAL_SERVICIO == 'M')
                                            <span class="badge-corpo bg-light text-primary">Material</span>
                                        @else
                                            <span class="badge-corpo bg-light text-warning">Servicio</span>
                                        @endif
                                    </td>
                                    <td class="text-center py-3 fw-bold">{{ $detalle->CANTIDAD }}</td>

                                    @if($mostrarJefe)
                                        <td class="text-center py-3 fw-bold text-success">{{ $detalle->CAN_MODIF_JEF_AUT ?? '—' }}</td>
                                    @endif
                                    @if($mostrarGer)
                                        <td class="text-center py-3 fw-bold text-info">{{ $detalle->CAN_MODIF_GER ?? '—' }}</td>
                                    @endif
                                    @if($mostrarAdm)
                                        <td class="text-center py-3 fw-bold text-danger">{{ $detalle->CAN_MODIF_ADM ?? '—' }}</td>
                                    @endif

                                    <td class="py-3 pe-4">
                                        <div class="text-wrap" style="max-width: 200px; font-size: 12px; color: #858796;">
                                            {{ $detalle->TXT_OBSERVACION ?: '—' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">No se encontraron productos en este pedido.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- GLOSA DE RECHAZO (ESTILO DISCRETO PERO CLARO) -->
                @if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO))
                    <div class="alert alert-danger mt-4" style="background: #fff; border: 1px solid #f5c6cb; border-left: 5px solid #d9534f; border-radius: 6px;">
                        <h6 class="fw-bold text-danger mb-1" style="font-size: 14px;">Motivo del Rechazo:</h6>
                        <p class="mb-0" style="font-size: 14px; color: #000 !important;">{{ $pedido->TXT_GLOSA_RECHAZO }}</p>
                    </div>
                @endif

                <!-- BARRA DE ACCIONES FINAL -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-4" style="border-top: 2px solid transparent; width: 100%; text-align: right; margin-top: 20px !important;">
                    
                    @if ($pedido->COD_ESTADO === 'ETM0000000000001')
                        <button class="btn-corpo btn-corpo-warning editar-pedido" 
                                data-id="{{ $pedido->ID_PEDIDO }}" 
                                data-estado="{{ $pedido->COD_ESTADO }}">
                            <i class="fa fa-edit me-1"></i> Editar Pedido
                        </button>
                        <button class="btn-corpo btn-corpo-success emitir-pedido" 
                                data-id="{{ $pedido->ID_PEDIDO }}">
                            <i class="fa fa-check me-1"></i> Emitir Pedido
                        </button>
                        <button class="btn-corpo btn-corpo-danger anular-pedido" 
                                data-id="{{ $pedido->ID_PEDIDO }}">
                            <i class="fa fa-times me-1"></i> Anular Pedido
                        </button>
                    @endif
                    
                    <button class="btn-corpo btn-corpo-secondary" onclick="$('#tab-detalle-pedido').hide(); $('.nav-tabs a[href=\'#ordenpedido\']').tab('show');">
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
    .btn-back-corporate {
        position: absolute;
        top: 20px;
        right: 20px;
        background: transparent;
        border: 1px solid #d1d3e2;
        color: #858796;
        padding: 6px 15px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-back-corporate:hover {
        background: #f8f9fc;
        color: #1d3a6d;
        border-color: #1d3a6d;
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-corpo:active { transform: translateY(0); }

    .btn-corpo-success { background: #1cc88a; color: white; }
    .btn-corpo-warning { background: #f6c23e; color: white; }
    .btn-corpo-danger { background: #e74a3b; color: white; }
    .btn-corpo-secondary { background: #858796; color: white; }

    /* TABLA */
    #tabla-detalle-tab tbody tr:hover {
        background-color: #fcfcfc;
    }
</style>
