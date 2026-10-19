<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        h1{
            text-align: center;
        }
        .subtitulos{
            font-weight: bold;
            font-style: italic;
        }
        .titulotabla{
            background: #4285f4;
            color: #fff;
            font-weight: bold;
        }
        .tabladp{
            background: #bababa;
            color:#fff;
        }
        .tablaho{
            background: #37b358;
            color:#fff;
        }
        .tablamar{
            background: #4285f4;
            color:#fff;
        }
        .tablaagrupado{
            background: #ea4335;
            color:#fff;
        }
        .negrita{
            font-weight: bold;
        }
        .center{
            text-align: center;
        }
        .reportevacadesc{
            background: #ea4335;
            color: #fff;
            font-weight: bold;
        }
        .tablafila2{
          background: #f5f5f5;
        }
        .tablafila1{
          background: #ffffff;
        }
        .warning{
          background-color: #f6c163 !important;
        }

        .vcent{ display: table-cell; vertical-align:middle;text-align: center;}

        .gris{
            background: #C8C9CA;
        }
        .blanco{
          background: #ffffff;
        }
    </style>
    <table>
        <tr>
            <th class='tabladp'>ID_MERGE</th>
            <th class='tabladp'>ID OSIRIS</th>
            <th class='tabladp'>FEC AUTORIZACION</th>
            <th class='tabladp'>SERIE</th>
            <th class='tabladp'>NUMERO DOC</th>
            <th class='tabladp'>CENTRO</th>
            <th class='tabladp'>SOLICITANTE</th>
            <th class='tabladp'>JEFE AUTORIZA</th>
            <th class='tabladp'>APRUEBA ADM</th>
            <th class='tabladp'>CONTRATO</th>
            <th class='tabladp'>SUB CUENTA</th>
            <th class='tabladp'>MONEDA</th>
            <th class='tabladp'>GLOSA</th>
            <th class='tabladp'>TOTAL</th>
            <th class='tabladp'>ESTADO</th>
            <th class='tabladp'>FEC INICIO</th>
            <th class='tabladp'>FEC FIN</th>
            <th class='tabladp'>DESTINO</th>
        </tr>
        @foreach($listavale as $index => $item)
        <tr>
            <td>{{ $item->ID_MERGE }}</td>
            <td>{{ $item->ID_OSIRIS }}</td>
            <td>{{ (!empty($item->FEC_AUTORIZACION) && substr($item->FEC_AUTORIZACION, 0, 10) != '1900-01-01') ? date_format(date_create($item->FEC_AUTORIZACION), 'd-m-Y') : '' }}</td>
            <td>{{ $item->SERIE }}</td>
            <td>{{ $item->NUMERO_DOC }}</td>
            <td>{{ $item->CENTRO }}</td>
            <td>{{ $item->SOLICITANTE }}</td>
            <td>{{ $item->JEFE_AUTORIZA }}</td>
            <td>{{ $item->APRUEBA_ADM }}</td>
            <td>{{ $item->CONTRATO }}</td>
            <td>{{ $item->SUB_CUENTA }}</td>
            <td>{{ $item->MONEDA }}</td>
            <td>{{ $item->GLOSA }}</td>
            <td>{{ $item->TOTAL }}</td>
            <td>{{ $item->ESTADO }}</td>
            <td>{{ (!empty($item->FEC_INICIO) && substr($item->FEC_INICIO, 0, 10) != '1900-01-01') ? date_format(date_create($item->FEC_INICIO), 'd-m-Y') : '' }}</td>
            <td>{{ (!empty($item->FEC_FIN) && substr($item->FEC_FIN, 0, 10) != '1900-01-01') ? date_format(date_create($item->FEC_FIN), 'd-m-Y') : '' }}</td>
            <td>{{ trim($item->DESTINO) }}</td>
        </tr>
        @endforeach
    </table>
</html>
