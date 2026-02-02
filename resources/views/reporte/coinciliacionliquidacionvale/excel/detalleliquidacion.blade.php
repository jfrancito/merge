<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">ID_DOCUMENTO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_DOCUMENTO_CTBLE</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">NRO_SERIE</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">NRO_DOC</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_EMPRESA</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_EMPRESA</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">ARENDIR_ID</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_AREA</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_USUARIO_AUTORIZA</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_EMPRESA_TRABAJADOR</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_EMPRESA_TRABAJADOR</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">FEC_EMISION</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">PERIODO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_PRODUCTO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_PRODUCTO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TOTAL</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_VALE</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">DESTINO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">MOTIVO</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">COD_PRODUCTO_VALE</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TXT_PRODUCTO_VALE</th>
                <th style="background-color: #0f172a; color: #ffffff; font-weight: bold;">TOTAL_VALE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaDetalle as $item)
                <tr>
                    <td>{{ $item->ID_DOCUMENTO }}</td>
                    <td>{{ $item->COD_DOCUMENTO_CTBLE }}</td>
                    <td>{{ $item->NRO_SERIE }}</td>
                    <td>{{ $item->NRO_DOC }}</td>
                    <td>{{ $item->COD_EMPRESA }}</td>
                    <td>{{ $item->TXT_EMPRESA }}</td>
                    <td>{{ $item->ARENDIR_ID }}</td>
                    <td>{{ $item->TXT_AREA }}</td>
                    <td>{{ $item->TXT_USUARIO_AUTORIZA }}</td>
                    <td>{{ $item->TXT_EMPRESA_TRABAJADOR }}</td>
                    <td>{{ $item->COD_EMPRESA_TRABAJADOR }}</td>
                    <td>{{ $item->FEC_EMISION }}</td>
                    <td>{{ $item->PERIODO }}</td>
                    <td>{{ $item->COD_PRODUCTO }}</td>
                    <td>{{ $item->TXT_PRODUCTO }}</td>
                    <td>{{ number_format($item->TOTAL, 2, '.', '') }}</td>
                    <td>{{ $item->COD_VALE }}</td>
                    <td>{{ $item->DESTINO }}</td>
                    <td>{{ $item->MOTIVO }}</td>
                    <td>{{ $item->COD_PRODUCTO_VALE }}</td>
                    <td>{{ $item->TXT_PRODUCTO_VALE }}</td>
                    <td>{{ number_format($item->TOTAL_VALE, 2, '.', '') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>