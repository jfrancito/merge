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
            <th class= 'tabladp'>FEC PEDIDO</th>
            <th class= 'tabladp'>AÑO</th>
            <th class= 'tabladp'>MES</th>
            <th class= 'tabladp'>EMPRESA</th>
            <th class= 'tabladp'>CENTRO</th>
            <th class= 'tabladp'>AREA</th>
            <th class= 'tabladp'>TIPO PEDIDO</th>
            <th class= 'tabladp'>SOLICITA</th>
            <th class= 'tabladp'>AUTORIZA</th>
            <th class= 'tabladp'>APRUEBA GER</th>
            <th class= 'tabladp'>APRUEBA ADM</th>
            <th class= 'tabladp'>GLOSA</th>
            <th class= 'tabladp'>ESTADO</th>
            <th class= 'tabladp'>COD PRODUCTO</th>
            <th class= 'tabladp'>PRODUCTO</th>
            <th class= 'tabladp'>CATEGORIA FAMILIA</th>
            <th class= 'tabladp'>CATEGORIA UNIDAD</th>
            <th class= 'tabladp'>CANTIDAD</th>
            <th class= 'tabladp'>OBSERVACION PRODUCTO</th>

        </tr>

         @foreach($listaordenpedido as $index => $item) 
        <tr>
            <td>{{ $item->ID_PEDIDO }}</td>
            <td>{{ $item->FEC_PEDIDO }}</td>
            <td>{{ $item->COD_ANIO }}</td>
            <td>{{ $item->TXT_NOMBRE }}</td>
            <td>{{ $item->NOM_EMPR }}</td>
            <td>{{ $item->NOM_CENTRO }}</td>
            <td>{{ $item->TXT_AREA }}</td>
            <td>{{ $item->TXT_TIPO_PEDIDO }}</td>
            <td>{{ $item->TXT_TRABAJADOR_SOLICITA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_AUTORIZA }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_GER }}</td>
            <td>{{ $item->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
            <td>{{ $item->TXT_GLOSA }}</td>
            <td>{{ $item->TXT_ESTADO }}</td>
            <td>{{ $item->COD_PRODUCTO ?? '' }}</td>
            <td>{{ $item->NOM_PRODUCTO }}</td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            <td>{{ $item->NOM_CATEGORIA }}</td>
            <td>{{ $item->CANTIDAD }}</td>
            <td>{{ $item->TXT_OBSERVACION }}</td>
        </tr>
        @endforeach
    </table>
</html>


         