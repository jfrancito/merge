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
            <th class= 'tabladp'>N°</th>
            <th class= 'tabladp'>FECHA</th>
            <th class= 'tabladp'>FACTURA</th>
            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>TOTAL</th>
        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{$index +1}}</td>
            <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
            <td>{{$item->SERIE}}-{{$item->NUMERO}}</td>
            <td>{{$item->RZ_PROVEEDOR}}</td>
            <td>{{$item->TOTAL_VENTA_ORIG}}</td>   
        </tr>
        @endforeach
    </table>
</html>
