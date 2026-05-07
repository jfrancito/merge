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
            <th class= 'tabladp'>ITEM</th>
            <th class= 'tabladp'>OPERACION</th>
            <th class= 'tabladp'>ID DOCUMENTO</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>RAZON SOCIAL</th>
            <th class= 'tabladp'>SERIE</th>
            <th class= 'tabladp'>NUMERO</th>
            <th class= 'tabladp'>MONEDA</th>
            <th class= 'tabladp'>TOTAL VENTA</th>
            <th class= 'tabladp'>ESTADO</th>
            <th class= 'tabladp'>RESPONSABLE</th>
            <th class= 'tabladp'>MODO REPARABLE</th>
            <th class= 'tabladp'>MODO REPARABLE HIBRIDO</th>
        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{$index + 1}}</td>
            <td>{{$item->OPERACION}}</td>
            <td>{{$item->ID_DOCUMENTO}}</td>
            <td>{{$item->RUC_PROVEEDOR}}</td>
            <td>{{$item->RZ_PROVEEDOR}}</td>
            <td>{{$item->SERIE}}</td>
            <td>{{$item->NUMERO}}</td>
            <td>{{$item->MONEDA}}</td>
            <td>{{number_format((float)$item->TOTAL_VENTA_ORIG, 2, '.', ',')}}</td>
            <td>{{$item->TXT_ESTADO}}</td>
            <td>{{$item->NOMBRES}}</td>
            <td>{{$item->MODO_REPARABLE}}</td>
            <td>{{$item->MODO_REPARABLE_HIBRIDO}}</td>
        </tr>
        @endforeach
    </table>
</html>
