<div class="panel panel-default panel-table" style="border-radius: 12px; overflow: hidden; border: 1px solid #eaecf4;">
    <div class="panel-body" style="padding: 15px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <div class="input-group shadow-soft" style="border-radius: 20px; overflow: hidden; max-width: 400px; margin-left: auto;">
                    <span class="input-group-addon" style="background: #1d3a6d; color: #fff; border: none;">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control buscar-tabla-local" placeholder="Buscar en esta pestaña..." style="border: none; height: 38px; font-weight: 500;">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-condensed tabla-cotizaciones-aprob" style="font-size: 13px;">
                <thead style="background: #1d3a6d; color: #fff;">
                    <tr>
                        <th class="text-center" style="width: 60px; padding: 12px 15px;">#</th>
                        <th class="text-center" style="padding: 12px 15px;">ID COTIZACIÓN</th>
                        <th class="text-center" style="padding: 12px 15px;">CENTRO</th>
                        <th class="text-center" style="padding: 12px 15px;">FECHA</th>
                        <th class="text-center" style="padding: 12px 15px;">NRO SERIE</th>
                        <th class="text-center" style="padding: 12px 15px;">NRO DOC</th>
                        <th class="text-center" style="padding: 12px 15px;">PROVEEDOR</th>
                        <th class="text-center" style="padding: 12px 15px;">MONEDA</th>
                        <th class="text-center" style="padding: 12px 15px;">TIPO PAGO</th>
                        <th class="text-center" style="padding: 12px 15px;">TOTAL</th>
                        <th class="text-center" style="padding: 12px 15px;">ESTADO</th>
                        <th class="text-center" style="padding: 12px 15px;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listacotizaciones as $index => $item)
                        <tr style="transition: all 0.3s; border-bottom: 1px solid #f2f2f2;">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center"><b style="color: #1d3a6d;">{{ $item->ID_COTIZACION }}</b></td>
                            <td class="text-center">
                                <span class="label label-info" style="background: #34aadc; color: #fff; font-weight: bold;">
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
                                <span class="label label-default" style="background: #eef1f7; color: #1d3a6d; font-weight: bold;">
                                    {{ $item->TXT_CATEGORIA_MONEDA }}
                                </span>
                            </td>
                            <td class="text-center">{{ $item->TXT_CATEGORIA_TIPO_PAGO }}</td>
                            <td class="text-center">
                                <b style="font-size: 14px;">{{ number_format($item->CAN_TOTAL, 2, '.', ',') }}</b>
                            </td>
                            <td class="text-center">
                                @if($tipo == 'pendientes')
                                    <span class="label label-warning" style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                @elseif($tipo == 'aprobado')
                                    <span class="label label-success" style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                @else
                                    <span class="label label-danger" style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <button class="btn btn-sm ver-detalle-cotizacion" data-id="{{ $item->ID_COTIZACION }}" style="border-radius: 8px; padding: 6px 15px; transition: all 0.3s; background: #f0f3ff; border: 1px solid #d0dcfc; color: #4e73df; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-weight: 700; font-size: 11px; letter-spacing: 0.5px;" title="Ver Detalle de Cotización">
                                        <i class="fa fa-eye" style="font-size: 14px; margin-right: 7px;"></i>
                                        DETALLE
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
