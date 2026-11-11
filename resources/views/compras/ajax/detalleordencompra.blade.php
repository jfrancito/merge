<div class="panel panel-default panel-border-color panel-border-color-info" style="box-shadow: 0 4px 10px rgba(0,0,0,0.08); border-radius: 8px;">
    <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <span style="font-weight: 700; color: #1e293b; font-size: 16px;">
            <span class="icon mdi mdi-assignment-o" style="margin-right: 5px; color: #0284c7;"></span>
            Detalle de la Orden de Compra: <span style="color: #0284c7;">{{ $orden->COD_ORDEN }}</span>
        </span>
        <div style="display: flex; align-items: center; gap: 10px;">
            @php
                $estado = trim($orden->TXT_CATEGORIA_ESTADO_ORDEN);
                $badge_class = 'badge-default';
                $badge_style = 'font-weight: bold; font-size: 11px; padding: 5px 12px; border-radius: 12px; margin-right: 15px;';
                if ($estado === 'APROBADO' || $estado === 'APROBADA') {
                    $badge_class = 'badge-warning';
                    $badge_style .= ' background-color: #f0ad4e; color: #ffffff;';
                } elseif ($estado === 'RECHAZADO' || $estado === 'RECHAZADA' || $estado === 'ANULADA') {
                    $badge_class = 'badge-danger';
                } elseif ($estado === 'GENERADA' || $estado === 'GENERADO' || $estado === 'EMITIDA') {
                    $badge_class = '';
                    $badge_style .= ' color: #000000; background-color: rgba(226, 232, 240, 0.7); border: 1px solid #cbd5e1;';
                } elseif ($estado === 'TERMINADA' || $estado === 'TERMINADO') {
                    $badge_class = 'badge-primary';
                }
            @endphp
            <span class="badge {{ $badge_class }}" style="{{ $badge_style }}">
                {{ $estado }}
            </span>
            
            @if(trim($orden->COD_CATEGORIA_ESTADO_ORDEN) === 'EOR0000000000001')
                <button type="button" 
                        class="btn btn-success btn-sm btn-aprobar-oc" 
                        data-codorden="{{ $orden->COD_ORDEN }}"
                        style="border-radius: 4px; font-weight: bold; padding: 6px 16px; margin: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 5px;">
                    <span class="icon mdi mdi-check"></span> Aprobar Orden
                </button>
                <button type="button" 
                        class="btn btn-danger btn-sm btn-rechazar-oc" 
                        data-codorden="{{ $orden->COD_ORDEN }}"
                        style="border-radius: 4px; font-weight: bold; padding: 6px 16px; margin: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 5px;">
                    <span class="icon mdi mdi-close"></span> Rechazar Orden
                </button>
            @elseif(trim($orden->COD_CATEGORIA_ESTADO_ORDEN) === 'EOR0000000000016')
                <button type="button" 
                        class="btn btn-danger btn-sm btn-rechazar-oc" 
                        data-codorden="{{ $orden->COD_ORDEN }}"
                        style="border-radius: 4px; font-weight: bold; padding: 6px 16px; margin: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 5px;">
                    <span class="icon mdi mdi-close"></span> Rechazar Orden
                </button>
            @endif
        </div>
    </div>
    
    <div class="panel-body" style="padding: 20px;">
        <!-- Información Resumen Cabecera -->
        <div class="row" style="margin-bottom: 20px; background-color: #f8fafc; border-radius: 6px; padding: 15px; border: 1px solid #f1f5f9;">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-muted" style="font-size: 11px; display: block; font-weight: 600; text-transform: uppercase;">Empresa Cliente</span>
                <span style="font-size: 14px; font-weight: bold; color: #334155;">{{ $orden->TXT_EMPR_CLIENTE }}</span>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <span class="text-muted" style="font-size: 11px; display: block; font-weight: 600; text-transform: uppercase;">Sede (Centro)</span>
                <span style="font-size: 14px; font-weight: bold; color: #334155;">{{ $orden->NOM_CENTRO ? $orden->NOM_CENTRO : $orden->COD_CENTRO }}</span>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2">
                <span class="text-muted" style="font-size: 11px; display: block; font-weight: 600; text-transform: uppercase;">Fecha Orden</span>
                <span style="font-size: 14px; font-weight: bold; color: #334155;">{{ date('d-m-Y', strtotime($orden->FEC_ORDEN)) }}</span>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2">
                <span class="text-muted" style="font-size: 11px; display: block; font-weight: 600; text-transform: uppercase;">Moneda / Total</span>
                <span style="font-size: 14px; font-weight: bold; color: #0284c7;">
                    {{ $orden->TXT_CATEGORIA_MONEDA == 'DOLARES' ? 'USD $' : 'PEN S/.' }} {{ number_format($orden->CAN_TOTAL, 2) }}
                </span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2 text-right">
                <button type="button" class="btn btn-default btn-sm btn-cerrar-detalle" style="border-radius: 4px; padding: 5px 12px; margin-top: 5px;">
                    <span class="icon mdi mdi-chevron-up"></span> Ocultar Detalle
                </button>
            </div>
            <div class="col-xs-12" style="margin-top: 10px;">
                <span class="text-muted" style="font-size: 11px; display: block; font-weight: 600; text-transform: uppercase;">Glosa</span>
                <span style="font-size: 13px; font-style: italic; color: #475569;">{{ $orden->TXT_GLOSA ? $orden->TXT_GLOSA : 'Sin glosa registrada.' }}</span>
            </div>
        </div>

        <!-- Tabla Detalle de Productos -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" style="margin-bottom: 0;">
                <thead>
                    <tr style="background-color: #f1f5f9;">
                        <th class="text-center">COD PRODUCTO</th>
                        <th class="text-center">NOMBRE PRODUCTO</th>
                        <th class="text-center">ALMACEN</th>
                        <th class="text-center">U.MEDIDA</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">COSTO S/.</th>
                        <th class="text-center">IGV</th>
                        <th class="text-center">PRECIO S/.</th>
                        <th class="text-center">TOTAL S/.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalles as $det)
                        <tr>
                            <td><b>{{ $det->COD_PRODUCTO }}</b></td>
                            <td>{{ $det->TXT_NOMBRE_PRODUCTO }}</td>
                            <td>{{ $det->TXT_ALMACEN }}</td>
                            <td class="text-center">
                                {{ $det->producto && $det->producto->unidadmedida ? $det->producto->unidadmedida->NOM_CATEGORIA : '' }}
                            </td>
                            <td class="text-center">{{ number_format($det->CAN_PRODUCTO, 4) }}</td>
                            <td class="text-center">{{ number_format($det->CAN_PRECIO_UNIT, 4) }}</td>
                            <td class="text-center">
                                @if($det->IND_IGV == 1)
                                    <span class="icon mdi mdi-check text-success" style="font-size: 14px; font-weight: bold;"></span>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($det->CAN_PRECIO_UNIT_IGV, 4) }}</td>
                            <td class="text-center" style="font-weight: bold; color: #1e293b;">
                                {{ number_format($det->CAN_VALOR_VENTA_IGV, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 15px; font-style: italic;">
                                No se encontraron productos detallados para esta orden de compra.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
