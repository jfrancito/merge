<table id="reporteliquidaciones"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%">
    @php
        $total_monto = 0.0000;
    @endphp
    <thead class="background-th-azul">
    <tr>
        <th>EMPRESA</th>
        <th>CENTRO</th>
        <th>TRABAJADOR</th>
        <th>FECHA LIQUIDACIÓN</th>
        <th>MES NRO</th>
        <th>MES</th>
        <th>NRO LIQUIDACIÓN</th>
        <th>MONEDA</th>
        <th>PROVEEDOR</th>
        <th>TIPO DOCUMENTO</th>
        <th>NRO DOCUMENTO</th>
        <th>FECHA DOCUMENTO</th>
        <th>PRODUCTO</th>
        <th>CATEGORÍA PRODUCTO</th>
        <th>ESTADO DOCUMENTO</th>
        <th>MONTO (SOLES)</th>
        <th>CENTRO COSTO</th>
        <th>GLOSA</th>
        <th>USUARIO REGISTRO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listaLiquidaciones as $item)
        <tr>
            <td>{{ $item['EMP_SISTEMA'] }}</td>
            <td>{{ $item['NOM_CENTRO'] }}</td>
            <td>{{ $item['TRABAJADOR'] }}</td>
            <td class="align-center-tb">
                @if(!empty($item['FECHA_LIQUIDACION']))
                    {{ \Carbon\Carbon::parse($item['FECHA_LIQUIDACION'])->format('d/m/Y') }}
                @endif
            </td>
            <td class="align-center-tb">{{ $item['MES_NRO'] }}</td>
            <td>{{ $item['MES'] }}</td>
            <td>{{ $item['NRO_LIQUIDACION'] }}</td>
            <td>{{ $item['MONEDA'] }}</td>
            <td>{{ $item['PROVEEDOR'] }}</td>
            <td>{{ $item['TIPO_DOCUMENTO'] }}</td>
            <td>{{ $item['NRO_DOCUMENTO'] }}</td>
            <td class="align-center-tb">
                @if(!empty($item['FEC_EMISION']))
                    {{ \Carbon\Carbon::parse($item['FEC_EMISION'])->format('d/m/Y') }}
                @endif
            </td>
            <td>{{ $item['PRODUCTO'] }}</td>
            <td>{{ $item['CATEGORIA_PRODUSTO'] }}</td>
            <td>{{ $item['ESTADO_DOCUMENTO'] }}</td>
            <td class="align-right-tb">{{ number_format($item['MONTO_DOCUMENTO_SOLES'], 2, '.', ',') }}</td>
            <td>{{ $item['CENTRO_COSTO'] }}</td>
            <td>{{ $item['GLOSA'] }}</td>
            <td>{{ $item['USUARIO_REGISTRO'] }}</td>
        </tr>
        @php
            $total_monto += $item['MONTO_DOCUMENTO_SOLES'];
        @endphp
    @endforeach
    </tbody>

    @if($total_monto > 0)
        <tfoot>
        <tr style="background: #4285f4; color: white; text-align: left">
            <th colspan="15" class="center footerho">TOTAL</th>
            <th class="align-right-tb">{{ number_format($total_monto, 2, '.', ',') }}</th>
            <th colspan="3"></th>
        </tr>
        </tfoot>
    @endif
</table>

@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif
