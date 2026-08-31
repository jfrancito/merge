<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table"
            style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="panel-body">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="input-group shadow-soft"
                            style="border-radius: 20px; overflow: hidden; max-width: 400px; margin-left: auto;">
                            <span class="input-group-addon" style="background: #1d3a6d; color: #fff; border: none;">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="buscar_cotizacion_principal" class="form-control"
                                placeholder="Buscar por ID, proveedor..."
                                style="border: none; height: 40px; font-weight: 500;">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tabla_cotizaciones_aprob" class="table table-hover table-condensed" style="font-size: 13px;">
                        <thead style="background: #1d3a6d; color: #fff;">
                            <tr>
                                <th class="text-center" style="width: 60px; padding: 15px;">#</th>
                                <th class="text-center" style="padding: 15px;">ID COTIZACIÓN</th>
                                <th class="text-center" style="padding: 15px;">CENTRO</th>
                                <th class="text-center" style="padding: 15px;">FECHA</th>
                                <th class="text-center" style="padding: 15px;">NRO SERIE</th>
                                <th class="text-center" style="padding: 15px;">NRO DOC</th>
                                <th class="text-center" style="padding: 15px;">PROVEEDOR</th>
                                <th class="text-center" style="padding: 15px;">MONEDA</th>
                                <th class="text-center" style="padding: 15px;">TIPO PAGO</th>
                                <th class="text-center" style="padding: 15px;">TOTAL</th>
                                <th class="text-center" style="padding: 15px;">ESTADO</th>
                                <th class="text-center" style="padding: 15px;">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($listacotizaciones) > 0)
                                @foreach($listacotizaciones as $index => $item)
                                    <tr style="transition: all 0.3s; border-bottom: 1px solid #f2f2f2;">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center"><b style="color: #1d3a6d;">{{ $item->ID_COTIZACION }}</b></td>
                                        <td class="text-center">
                                            <span class="label label-info"
                                                style="background: #34aadc; color: #fff; font-weight: bold;">
                                                {{ $item->ABREV_CENTRO }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->FEC_COTIZACION)) }}</td>
                                        <td class="text-center">{{ $item->NRO_SERIE }}</td>
                                        <td class="text-center">{{ $item->NRO_DOC }}</td>
                                        <td class="text-center" title="{{ $item->NOM_EMPR_PROVEEDOR }}">
                                            {{ str_limit($item->NOM_EMPR_PROVEEDOR, 30) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="label label-default"
                                                style="background: #eef1f7; color: #1d3a6d; font-weight: bold;">
                                                {{ $item->TXT_CATEGORIA_MONEDA }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $item->TXT_CATEGORIA_TIPO_PAGO }}</td>
                                        <td class="text-center">
                                            <b style="font-size: 14px;">{{ number_format($item->CAN_TOTAL, 2, '.', ',') }}</b>
                                        </td>
                                        <td class="text-center">
                                            <span class="label label-warning"
                                                style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div style="display: flex; gap: 5px; justify-content: center;">
                                                <button class="btn btn-sm ver-detalle-cotizacion"
                                                    data-id="{{ $item->ID_COTIZACION }}"
                                                    style="border-radius: 8px; padding: 6px 15px; transition: all 0.3s; background: #f0f3ff; border: 1px solid #d0dcfc; color: #4e73df; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-weight: 700; font-size: 11px; letter-spacing: 0.5px;"
                                                    title="Ver Detalle de Cotización">
                                                    <i class="fa fa-eye" style="font-size: 14px; margin-right: 7px;"></i>
                                                    DETALLE
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="text-center" style="padding: 30px; color: #999;">
                                        <i class="fa fa-info-circle fa-2x" style="margin-bottom: 10px; display: block;"></i>
                                        No se encontraron cotizaciones pendientes de aprobación de Gerencia Administrativa.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Inicializar buscador local en tiempo real en la tabla
        $("#buscar_cotizacion_principal").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tabla_cotizaciones_aprob tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<style>
    .ver-detalle-cotizacion:hover {
        transform: scale(1.15) !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
    }
</style>
