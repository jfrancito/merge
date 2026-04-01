<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
            <div class="panel-body">
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
                                   <span class="label label-default" style="background: #eef1f7; color: #1d3a6d; font-weight: bold;">
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
                                       <span class="label label-success" style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
                                   @else
                                       <span class="label label-warning" style="padding: 5px 10px; border-radius: 20px;">{{ $item->TXT_ESTADO }}</span>
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

                                        @if(isset($item->RUTA_ARCHIVO) && !empty($item->RUTA_ARCHIVO))
                                            <a href="{{ url('/descargar-archivo-informe/'.base64_encode($item->RUTA_ARCHIVO)) }}" 
                                               class="btn btn-sm btn-default shadow-soft"
                                               style="border-radius: 4px; padding: 5px 12px; transition: all 0.2s; height: 35px; line-height: 25px;"
                                               title="Descargar Cotización">
                                                <i class="mdi mdi-download" style="font-size: 16px; margin-right: 5px;"></i>
                                            </a>
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
