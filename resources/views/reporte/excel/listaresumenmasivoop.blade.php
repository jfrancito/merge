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
            <th class= 'tabladp'>ID PEDIDO</th>
            <th class= 'tabladp'>ESTADO</th>
            <th class= 'tabladp'>FEC PEDIDO</th>
            <th class= 'tabladp'>AREA</th>
            <th class= 'tabladp'>FAMILIA</th>
            <th class= 'tabladp'>GLOSA</th>
            <th class= 'tabladp'>SOLICITA</th>
            <th class= 'tabladp'>AUTORIZA</th>
            <th class= 'tabladp'>APRUEBA ADM</th>
        </tr>

         @foreach($listaordenpedido as $index => $item) 
        <tr>
            <td>{{ $item->ID_PEDIDO }}</td>
            <td>{{ $item->TXT_ESTADO }}</td>
            <td>{{ $item->FEC_PEDIDO }}</td>
            <td>{{ $item->TXT_AREA }}</td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->TXT_GLOSA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_AUTORIZA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
        </tr>
        @endforeach
    </table>
</html>


         