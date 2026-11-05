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
            <th class= 'tabladp'>CONTRATO</th>
            <th class= 'tabladp'>NRO CONTRATO</th>

            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>USUARIO CONTACTO</th>

            <th class= 'tabladp'>COMPROBANTE ASOCIADO</th>
            <th class= 'tabladp'>FECHA VENCIMIENTO DOC</th>
            <th class= 'tabladp'>ENTIDAD BANCARIA</th>
            <th class= 'tabladp'>CUENTA BANCARIA</th>
        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>
            <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
            <td>{{$item->TXT_EMPR_EMISOR}}</td>
            <td>{{$item->TXT_CONTACTO}}</td>            
            <td>{{$item->NRO_SERIE_DOC}} - {{$item->NRO_DOC_DOC}}</td>
            <td>{{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}</td>
            <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
            <td><b>{{$item->TXT_NRO_CUENTA_BANCARIA}}</b></td>
        </tr>
        @endforeach
    </table>
</html>
