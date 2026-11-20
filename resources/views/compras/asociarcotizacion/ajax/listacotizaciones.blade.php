<div class="table-responsive">
    <table id="tabla_cotizaciones_sin_oc" class="table table-hover table-striped table-fw-widget" style="width:100%; font-size: 13px;">
        <thead>
            <tr style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: #ffffff;">
                <th class="text-center" style="width: 40px; vertical-align: middle;">#</th>
                <th class="text-center" style="vertical-align: middle;">ID COTIZACIÓN</th>
                <th class="text-center" style="vertical-align: middle;">FEC COTIZACIÓN</th>
                <th class="text-center" style="vertical-align: middle;">NRO SERIE</th>
                <th class="text-center" style="vertical-align: middle;">NRO DOC</th>
                <th class="text-left" style="vertical-align: middle;">NOM PROVEEDOR</th>
                <th class="text-center" style="vertical-align: middle;">MONEDA</th>
                <th class="text-center" style="vertical-align: middle;">TOTAL</th>
                <th class="text-center" style="vertical-align: middle;">ESTADO</th>
                <th class="text-center" style="width: 140px; vertical-align: middle;">ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($listacotizaciones as $index => $item)
                @php
                    $moneda_txt = trim($item->TXT_CATEGORIA_MONEDA ?? '');
                    $moneda_simbolo = (strpos(strtoupper($moneda_txt), 'DOLAR') !== false || strtoupper($moneda_txt) == 'USD') ? '$' : 'S/';
                    
                    $estado_txt = trim($item->TXT_ESTADO ?? '');
                    $badge_class = 'label-primary';
                    $badge_style = 'padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; letter-spacing: 0.4px; display: inline-block;';
                    
                    if (strtoupper($estado_txt) == 'APROBADO' || strtoupper($estado_txt) == 'APROBADA') {
                        $badge_class = 'label-success';
                        $badge_style .= ' background: #059669; color: #ffffff; box-shadow: 0 2px 6px rgba(5,150,105,0.25);';
                    } elseif (strtoupper($estado_txt) == 'GENERADO' || strtoupper($estado_txt) == 'GENERADA') {
                        $badge_class = 'label-info';
                        $badge_style .= ' background: #0284c7; color: #ffffff; box-shadow: 0 2px 6px rgba(2,132,199,0.25);';
                    } elseif (strtoupper($estado_txt) == 'ANULADO' || strtoupper($estado_txt) == 'ANULADA') {
                        $badge_class = 'label-danger';
                        $badge_style .= ' background: #dc2626; color: #ffffff;';
                    } else {
                        $badge_style .= ' background: #64748b; color: #ffffff;';
                    }
                @endphp
                <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9;">
                    <td class="text-center" style="vertical-align: middle; color: #64748b; font-weight: 600;">
                        {{ $index + 1 }}
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <span class="badge" style="background: #e0e7ff; color: #1e40af; font-size: 12px; font-weight: 700; padding: 5px 10px; border-radius: 8px; border: 1px solid #c7d2fe;">
                            <i class="fa fa-hashtag mr-1"></i>{{ $item->ID_COTIZACION }}
                        </span>
                    </td>
                    <td class="text-center" style="vertical-align: middle; color: #334155; font-weight: 500;">
                        <i class="fa fa-calendar-o text-muted mr-1"></i>
                        {{ !empty($item->FEC_COTIZACION) ? date('d-m-Y', strtotime($item->FEC_COTIZACION)) : '-' }}
                    </td>
                    <td class="text-center" style="vertical-align: middle; font-weight: 600; color: #1e293b;">
                        {{ $item->NRO_SERIE }}
                    </td>
                    <td class="text-center" style="vertical-align: middle; font-weight: 600; color: #1e293b;">
                        {{ $item->NRO_DOC }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;" title="{{ $item->NOM_EMPR_PROVEEDOR }}">
                        <div style="font-weight: 600; color: #1e293b; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <i class="fa fa-building-o text-muted mr-1"></i>{{ $item->NOM_EMPR_PROVEEDOR }}
                        </div>
                        @if(!empty($item->NRO_RUC))
                            <small class="text-muted" style="font-size: 11px;">RUC: {{ $item->NRO_RUC }}</small>
                        @endif
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <span class="badge" style="background: #f1f5f9; color: #0f172a; font-weight: 600; border: 1px solid #cbd5e1; padding: 4px 9px;">
                            {{ $moneda_txt }}
                        </span>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <span style="font-size: 13.5px; font-weight: 700; color: #0f172a;">
                            <small style="color: #64748b; font-weight: 600;">{{ $moneda_simbolo }}</small> {{ number_format((float) $item->CAN_TOTAL, 2, '.', ',') }}
                        </span>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <span class="label {{ $badge_class }}" style="{{ $badge_style }}">
                            <i class="fa fa-check-circle mr-1"></i>{{ $estado_txt }}
                        </span>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <button type="button" 
                                class="btn btn-sm btn-asociar-oc"
                                data-id="{{ $item->ID_COTIZACION }}"
                                style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; border: none; border-radius: 8px; font-weight: 700; font-size: 11.5px; padding: 6px 14px; box-shadow: 0 2px 6px rgba(16,185,129,0.3); transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa fa-link"></i> ASOCIAR OC
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 45px 15px; color: #64748b;">
                        <div style="margin-bottom: 10px;">
                            <i class="fa fa-inbox fa-3x" style="color: #cbd5e1;"></i>
                        </div>
                        <h4 style="color: #475569; font-weight: 600; margin-bottom: 5px;">No se encontraron cotizaciones sin orden de compra</h4>
                        <p class="text-muted" style="font-size: 13px;">Pruebe cambiando el rango de fechas o el centro de búsqueda.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if ($('#tabla_cotizaciones_sin_oc tbody tr td').length > 1) {
            $('#tabla_cotizaciones_sin_oc').DataTable({
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sSearch":         "Buscar:",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    }
                },
                "order": [[ 2, "desc" ]],
                "pageLength": 25,
                "responsive": true
            });
        }
    });
</script>
