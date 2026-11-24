<div tabindex="0" class="panel panel-default panel-contrast pnldetallesdocumentos">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
    </div>
    <div class="panel-body panel-body-contrast">
        <table id="tblactivos" class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>FECHA EMISION</th>
                <th>DOCUMENTO</th>
                <th>TIPO DOCUMENTO</th>
                <th>PROVEEDOR</th>
                <th>CONTRATO</th>
                <th>MONEDA CONTRATO</th>
                <th>TOTAL</th>
                <th>OPCIONES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tdetliquidaciongastos as $index => $item)
                <tr class="filalg filalgvalidar {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index == 0) activofl @endif"
                    data_valor="{{$item->ID_DOCUMENTO}}{{$item->ITEM}}" data_asiento_compra="{{$item->TXT_CENTRO}}"
                    data_asiento_reversion="{{$item->TOKEN}}" data_valor_compra="{{$item->BUSQUEDAD}}"
                    data_valor_reversion="{{$item->CONTADOR}}"
                    data_exento_asiento="{{isset($item->EXENTO_ASIENTO) ? $item->EXENTO_ASIENTO : 0}}">
                    <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                    <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                    <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                    <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
                    <td>{{$item->COD_CONTRATO}}</td>
                    <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
                    <td>{{$item->TOTAL}}</td>
                    <td>
                        @php
                            $esUsuarioAdmin = (Session::has('usuario') && (strtolower(trim(Session::get('usuario')->name)) == 'admin' || strtolower(trim(Session::get('usuario')->nombre)) == 'admin' || Session::get('usuario')->id == '1CIX00000001')) || (Session::has('usuario_original') && (strtolower(trim(Session::get('usuario_original')->name)) == 'admin' || strtolower(trim(Session::get('usuario_original')->nombre)) == 'admin' || Session::get('usuario_original')->id == '1CIX00000001'));
                        @endphp
                        @if(isset($item->EXENTO_ASIENTO) && $item->EXENTO_ASIENTO == 1)
                            <span class="badge badge-warning" style="background-color: #f59e0b; color: #fff; padding: 5px 9px; font-size: 11px; font-weight: bold; border-radius: 4px; display: inline-block;">
                                <i class="fa fa-ban"></i> Exento de Asiento
                            </span>
                            @if($esUsuarioAdmin)
                                <button type="button" 
                                        class="btn btn-xs btn-default btn-toggle-exento-asiento" 
                                        data-iddocumento="{{$item->ID_DOCUMENTO}}" 
                                        data-item="{{$item->ITEM}}" 
                                        data-accion="habilitar"
                                        title="Permitir generar asiento para este comprobante (Solo Admin)"
                                        style="margin-left: 5px; border-color: #f59e0b; color: #b45309; font-weight: bold;">
                                    <i class="fa fa-unlock"></i> Permitir Asiento
                                </button>
                            @endif
                        @else
                            @if($item->BUSQUEDAD === 1)
                                <button type="button" class="btn btn-sm btn-primary asiento-compra">
                                    👁 Asiento Compra
                                </button>
                            @endif
                            @if($item->CONTADOR === 1)
                                <button type="button" class="btn btn-sm btn-success asiento-reversion">
                                    👁 Asiento Reversion
                                </button>
                            @endif
                            @if($esUsuarioAdmin)
                                @php
                                    $esAerolineaOriginal = $funcion->esAerolineaExentaAsiento((object)['COD_EMPRESA_PROVEEDOR' => $item->COD_EMPRESA_PROVEEDOR, 'TXT_EMPRESA_PROVEEDOR' => $item->TXT_EMPRESA_PROVEEDOR]);
                                @endphp
                                @if($esAerolineaOriginal)
                                    <button type="button" 
                                            class="btn btn-xs btn-default btn-toggle-exento-asiento" 
                                            data-iddocumento="{{$item->ID_DOCUMENTO}}" 
                                            data-item="{{$item->ITEM}}" 
                                            data-accion="restringir"
                                            title="Volver a marcar como Exento de Asiento (Solo Admin)"
                                            style="margin-left: 5px; border-color: #6c757d; color: #6c757d;">
                                        <i class="fa fa-lock"></i> Eximir
                                    </button>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" id="total_xml" name="total_xml" value=""/>
    <input type="hidden" id="tipo_operacion" name="tipo_operacion" value=""/>
    <input type="hidden" id="operacion" name="operacion" value=""/>
</div>
