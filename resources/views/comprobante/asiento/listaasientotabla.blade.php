<table id="asientolista" tabindex="0"
       class="table table-bordered table-hover td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%">
    <thead style="background: #1d3a6d; color: white">
    <tr>
        <th>Tipo Asiento</th>
        <th>Descripción Asiento</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($asiento_compra))
        <tr data_indicador="C" data_input="C" data_asiento_cabecera="{{json_encode($asiento_compra[1])}}" data_asiento_detalle="{{json_encode($asiento_compra[2])}}">
            <td>{{$asiento_compra[1][0]['TXT_CATEGORIA_TIPO_ASIENTO']}}</td>
            <td>Asiento Compra - Libro Compra</td>
            <td>
                <button type="button" class="btn btn-sm btn-primary ver-asiento">
                    👁 Ver Asiento
                </button>
            </td>
        </tr>
    @endif
    @if(!empty($asiento_reparable_reversion))
        <tr data_indicador="C" data_input="RV" data_asiento_cabecera="{{json_encode($asiento_reparable_reversion[1])}}" data_asiento_detalle="{{json_encode($asiento_reparable_reversion[2])}}">
            <td>{{$asiento_reparable_reversion[1][0]['TXT_CATEGORIA_TIPO_ASIENTO']}}</td>
            <td>Asiento Diario - Reversion Asiento Reparable</td>
            <td>
                <button type="button" class="btn btn-sm btn-primary ver-asiento">
                    👁 Ver Asiento
                </button>
            </td>
        </tr>
    @endif
    @if(!empty($asiento_deduccion))
        <tr data_indicador="C" data_input="D" data_asiento_cabecera="{{json_encode($asiento_deduccion[1])}}" data_asiento_detalle="{{json_encode($asiento_deduccion[2])}}">
            <td>{{$asiento_deduccion[1][0]['TXT_CATEGORIA_TIPO_ASIENTO']}}</td>
            <td>Asiento Diario - Deducción de Anticipo</td>
            <td>
                <button type="button" class="btn btn-sm btn-primary ver-asiento">
                    👁 Ver Asiento
                </button>
            </td>
        </tr>
    @endif
    @if(!empty($asiento_percepcion))
        <tr data_indicador="C" data_input="P" data_asiento_cabecera="{{json_encode($asiento_percepcion[1])}}" data_asiento_detalle="{{json_encode($asiento_percepcion[2])}}">
            <td>{{$asiento_percepcion[1][0]['TXT_CATEGORIA_TIPO_ASIENTO']}}</td>
            <td>Asiento Compra - Libro Compra Percepción</td>
            <td>
                <button type="button" class="btn btn-sm btn-primary ver-asiento">
                    👁 Ver Asiento
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>

<input type="hidden" id="asientosgenerados" name="asientosgenerados" value=""/>
