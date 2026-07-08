<!-- HEADER -->
<div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b1a3d, #1f2a50); flex: 0 0 auto;">
    <h5 class="modal-title fw-semibold text-center w-100" style="margin: 0;">
        <div class="d-flex justify-content-center align-items-center mb-1">
            <i class="mdi mdi-receipt me-2 opacity-75" style="font-size: 20px;"></i>
            <span style="letter-spacing: 1px;">DETALLE DEL PEDIDO</span>
        </div>

        <span class="d-block fw-medium pedido-numero" style="color: #64b5f6;">
            N° {{ $pedido->ID_PEDIDO ?? '' }}
        </span>
    </h5>
</div>

<!-- BODY -->
<div class="modal-body p-0 bg-light" style="flex: 1 1 auto; overflow: hidden; display: flex; flex-direction: column;">

    <div class="table-responsive detalle-scroll" style="flex: 1 1 auto; width: 100%;">
        <table class="table table-hover align-middle mb-0 detalle-table">
            @php
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
            @endphp

            <thead class="text-white sticky-top detalle-thead">
                <tr class="text-uppercase small">
                    <th class="text-center" style="width: 50px;">#</th>
                    <th style="min-width: 200px;">Producto</th>
                    <th style="width: 120px;">Tipo</th>
                    <th style="width: 150px;">Categoría</th>
                    <th class="text-center" style="width: 80px;">Cant.</th>
                    @if($mostrarJefe)
                    <th class="text-center" style="width: 100px;">Cant. Jefe</th> @endif
                    @if($mostrarGer)
                    <th class="text-center" style="width: 100px;">Cant. Ger.</th>@endif
                    @if($mostrarAdm)
                    <th class="text-center" style="width: 100px;">Cant. Adm.</th>@endif
                    <th>Observación</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pedillodetalle as $index => $detalle)
                    <tr>
                        <td class="text-center fw-semibold text-muted">
                            {{ $index + 1 }}
                        </td>

                        <td class="fw-bold product-name" title="{{ $detalle->NOM_PRODUCTO }}">
                            {{ $detalle->NOM_PRODUCTO }}
                        </td>

                        <td class="text-secondary small">
                            {{ $detalle->IND_MATERIAL_SERVICIO == 'M' ? 'MATERIAL' : 'SERVICIO' }}
                        </td>

                        <td class="text-secondary small" title="{{ $detalle->NOM_CATEGORIA }}">
                            {{ $detalle->NOM_CATEGORIA }}
                        </td>

                        {{-- CANTIDAD ORIGINAL --}}
                        <td class="text-center">
                            <span class="badge-cantidad">
                                {{ $detalle->CANTIDAD }}
                            </span>
                        </td>

                        @if($mostrarJefe)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_JEF_AUT))
                                    <span class="badge-cantidad badge-jefe">
                                        {{ $detalle->CAN_MODIF_JEF_AUT }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        @endif

                        @if($mostrarGer)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_GER))
                                    <span class="badge-cantidad badge-gerencia">
                                        {{ $detalle->CAN_MODIF_GER }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        @endif

                        @if($mostrarAdm)
                            <td class="text-center">
                                @if(!is_null($detalle->CAN_MODIF_ADM))
                                    <span class="badge-cantidad badge-admin">
                                        {{ $detalle->CAN_MODIF_ADM }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        @endif

                        <td class="observacion-cell text-muted" title="{{ $detalle->TXT_OBSERVACION }}">
                            {{ $detalle->TXT_OBSERVACION ?: '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted fst-italic py-5">
                            <i class="mdi mdi-information-outline" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                            No hay productos en este pedido.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PANEL DE SEGUIMIENTO (LÍNEA DE TIEMPO) -->
    <div class="tracking-container mx-3 my-3">
        <div class="card border-0 shadow-sm" style="border-radius: 10px; background: #fff; border: 1px solid #e3e6f0;">
            <div class="card-header py-3" style="background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h6 class="m-0 font-weight-bold text-primary" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa fa-history" style="font-size: 16px; color: #4e73df;"></i>
                    LÍNEA DE TIEMPO Y SEGUIMIENTO DEL PEDIDO
                </h6>
            </div>
            <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;">
                @if(isset($historial) && count($historial) > 0)
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
                                            <span class="timeline-time-op" style="font-size: 13px; font-weight: 800; color: #4e73df; background: #eef2ff; padding: 3px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #d0dcfc;">
                                                <i class="fa fa-clock-o"></i> {{ date('H:i:s', strtotime($log->FECHA)) }}
                                            </span>
                                            <span class="text-dark" style="font-size: 12px; font-weight: 700; background: #f1f3f9; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #e2e8f0; color: #333 !important;">
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
                    <div class="text-center py-4 text-muted">
                        <i class="fa fa-info-circle mb-2" style="font-size: 24px; color: #36b9cc; display: block; margin-bottom: 10px;"></i>
                        No se registran transiciones de historial para este pedido.
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(isset($pedido->TXT_GLOSA_RECHAZO) && !empty($pedido->TXT_GLOSA_RECHAZO))
        <div class="rechazo-container mx-3 my-3">
            <div class="alert alert-danger mb-0" style="border-radius: 10px; border: none; background: #fff5f5; border-left: 4px solid #f44336; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <div class="d-flex align-items-center mb-1">
                    <i class="mdi mdi-close-circle text-danger me-2" style="font-size: 18px;"></i>
                    <h6 class="fw-bold text-danger mb-0" style="font-size: 13px; text-transform: uppercase;">Motivo del Rechazo</h6>
                </div>
                <p class="mb-0 text-dark" style="font-size: 14px; line-height: 1.4;">
                    {{ $pedido->TXT_GLOSA_RECHAZO }}
                </p>
            </div>
        </div>
    @endif
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