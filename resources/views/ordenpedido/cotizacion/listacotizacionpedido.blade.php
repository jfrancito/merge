<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table"
            style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="panel-body">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="input-group shadow-soft" style="border-radius: 20px; overflow: hidden; max-width: 400px; margin-left: auto;">
                            <span class="input-group-addon" style="background: #1d3a6d; color: #fff; border: none;">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="buscar_cotizacion_principal" class="form-control" 
                                   placeholder="Buscar por ID, proveedor o estado..." 
                                   style="border: none; height: 40px; font-weight: 500;">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tabla_cotizaciones" class="table table-hover table-condensed" style="font-size: 13px;">
                        <thead style="background: #1d3a6d; color: #fff;">
                            <tr>
                                <th class="text-center" style="padding: 15px;">#</th>
                                <th style="padding: 15px;">ID COTIZACIÓN</th>
                                <th style="padding: 15px;">FECHA</th>
                                <th style="padding: 15px;">NRO SERIE</th>
                                <th style="padding: 15px;">NRO DOC</th>
                                <th style="padding: 15px;">PROVEEDOR</th>
                                <th class="text-center" style="padding: 15px;">MONEDA</th>
                                <th class="text-center" style="padding: 15px;">TIPO PAGO</th>
                                <th style="padding: 15px;">OBSERVACIÓN</th>
                                <th class="text-right" style="padding: 15px;">TOTAL</th>
                                <th class="text-center" style="padding: 15px;">ESTADO</th>
                                <th class="text-center" style="padding: 15px;">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listacotizaciones as $index => $item)
                                <tr style="transition: all 0.3s; border-bottom: 1px solid #f2f2f2;">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><b style="color: #1d3a6d;">{{ $item->ID_COTIZACION }}</b></td>
                                    <td>{{ date('d-m-Y', strtotime($item->FEC_COTIZACION)) }}</td>
                                    <td>{{ $item->NRO_SERIE }}</td>
                                    <td>{{ $item->NRO_DOC }}</td>
                                    <td title="{{ $item->NOM_EMPR_PROVEEDOR }}">
                                        {{ str_limit($item->NOM_EMPR_PROVEEDOR, 30) }}
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-default"
                                            style="background: #eef1f7; color: #1d3a6d; font-weight: bold;">
                                            {{ $item->TXT_CATEGORIA_MONEDA }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $item->TXT_CATEGORIA_TIPO_PAGO }}</td>
                                    <td>{{ str_limit($item->TXT_OBSERVACION, 40) }}</td>
                                    <td class="text-right">
                                        <b style="font-size: 14px;">{{ number_format($item->CAN_TOTAL, 2, '.', ',') }}</b>
                                    </td>
                                    <td class="text-center">
                                        @if($item->TXT_ESTADO == 'GENERADO')
                                            <span class="label label-primary"
                                                style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                        @else
                                            <span class="label label-success"
                                                style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div style="display: flex; gap: 5px; justify-content: center;">
                                            <button class="btn btn-sm btn-info ver-detalle-cotizacion"
                                                data-id="{{ $item->ID_COTIZACION }}"
                                                style="border-radius: 50%; width: 35px; height: 35px; transition: transform 0.2s;"
                                                title="Ver Detalle">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            @if($item->COD_ESTADO != 'ETM0000000000005')
                                                <button class="btn btn-sm btn-warning editar-cotizacion"
                                                    data-id="{{ $item->ID_COTIZACION }}"
                                                    style="border-radius: 50%; width: 35px; height: 35px; transition: transform 0.2s;"
                                                    title="Editar Cotización">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <button class="btn btn-sm btn-success aprobar-cotizacion"
                                                    data-id="{{ $item->ID_COTIZACION }}"
                                                    style="border-radius: 50%; width: 35px; height: 35px; transition: transform 0.2s;"
                                                    title="Aprobar Cotización">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            @endif

                                            @if(!empty($item->RUTAS_ARCHIVOS))
                                                @php $archivos_lista = explode('|', $item->RUTAS_ARCHIVOS); @endphp
                                                @if(count($archivos_lista) == 1)
                                                    @php 
                                                        $archivo_data = explode('*', $archivos_lista[0]);
                                                        $ruta_link = $archivo_data[0];
                                                        $nombre_link = isset($archivo_data[1]) ? $archivo_data[1] : 'Archivo';
                                                    @endphp
                                                    <a href="{{ url('/descargar-archivo-informe/' . base64_encode($ruta_link)) }}"
                                                        class="btn btn-sm btn-success shadow-success btn-descarga-premium"
                                                        style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; background: #28a745; border: none;"
                                                        target="_blank"
                                                        title="Descargar: {{ $nombre_link }}">
                                                        <i class="mdi mdi-download" style="font-size: 18px; color: #fff;"></i>
                                                    </a>
                                                @else
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-success shadow-success dropdown-toggle btn-descarga-premium" 
                                                                type="button" data-toggle="dropdown" 
                                                                style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; background: #28a745; border: none;"
                                                                title="Descargar Archivos ({{ count($archivos_lista) }})">
                                                            <i class="mdi mdi-download" style="font-size: 18px; color: #fff;"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" style="border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); border: none; min-width: 250px;">
                                                            <li class="dropdown-header" style="font-weight: bold; color: #1d3a6d;">Documentos Adjuntos</li>
                                                            @foreach($archivos_lista as $idx_arch => $archivo_str)
                                                                @php 
                                                                    $archivo_data = explode('*', $archivo_str);
                                                                    $ruta_file = $archivo_data[0];
                                                                    $nombre_file = isset($archivo_data[1]) ? $archivo_data[1] : ('Archivo ' . ($idx_arch + 1));
                                                                @endphp
                                                                <li>
                                                                    <a href="{{ url('/descargar-archivo-informe/' . base64_encode($ruta_file)) }}" target="_blank" style="padding: 10px 20px;">
                                                                        <i class="mdi mdi-file-pdf text-danger" style="margin-right: 10px; font-size: 16px;"></i> 
                                                                        {{ $nombre_file }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endif

                                            @if($item->COD_ESTADO != 'ETM0000000000005')
                                                <button class="btn btn-sm btn-danger eliminar-cotizacion"
                                                    data-id="{{ $item->ID_COTIZACION }}"
                                                    style="border-radius: 50%; width: 35px; height: 35px; transition: transform 0.2s; border: none; background: #e3342f;"
                                                    title="Eliminar Cotización">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenedor dinámico para el modal -->
<div id="modal-detalle-cotizacion-container"></div>

<style>
    .ver-detalle-cotizacion:hover,
    .editar-cotizacion:hover,
    .aprobar-cotizacion:hover,
    .btn-descarga-premium:hover {
        transform: scale(1.15) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }
    .btn-descarga-premium i {
        line-height: 35px;
    }
</style>