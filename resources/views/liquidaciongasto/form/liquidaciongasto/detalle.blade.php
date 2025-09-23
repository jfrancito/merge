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
                <th>ASIENTO</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tdetliquidaciongastos as $index => $item)
                <tr class="filalg {{$item->ID_DOCUMENTO}}{{$item->ITEM}} @if($index == 0) activofl @endif"
                    data_valor="{{$item->ID_DOCUMENTO}}{{$item->ITEM}}" data_asiento_cabecera="{{$item->TXT_CENTRO}}"
                    data_asiento_detalle="{{$item->TOKEN}}" data_valor_id="{{$item->BUSQUEDAD}}">
                    <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                    <td>{{$item->SERIE}} - {{$item->NUMERO}} </td>
                    <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                    <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
                    <td>{{$item->COD_CONTRATO}}</td>
                    <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
                    <td>{{$item->TOTAL}}</td>
                    <td>@if($item->BUSQUEDAD === 1) GENERADO @else NO GENERADO @endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" id="total_xml" name="total_xml"
           value=""/>
</div>
