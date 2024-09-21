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
            <th class= 'tabladp'>FECHA EMISIÓN DE COMPROBANTE</th>
            <th class= 'tabladp'>FECHA AUTORIZACION</th>
            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>CODIGO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>

            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN FACTURA</th>
            <th class= 'tabladp'>BIEN / SERVICIO</th>
            <th class= 'tabladp'>MONEDA</th>


            <th class= 'tabladp'>TIPO DE CAMBIO</th>
            <th class= 'tabladp'>CANTIDAD</th>
            <th class= 'tabladp'>BASE</th>
            <th class= 'tabladp'>IGV</th>
            <th class= 'tabladp'>TOTAL</th>


            <th class= 'tabladp'>DETRACIÓN</th>
            <th class= 'tabladp'>COD DETRACCIÓN</th>
            <th class= 'tabladp'>IMPORTE DETRACCIÓN</th>
            <th class= 'tabladp'>CONSTANCIA DETRACCIÓN</th>
            <th class= 'tabladp'>NUMERO DE CONSTANCIA</th>
        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
            <td>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    FACTURA
                @else
                    RECIBO POR HONORARIO
                @endif
            </td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->ID_TIPO_DOC}}
                @else
                    02
                @endif
            </td>
            <td>{{$item->SERIE}} - {{str_pad($item->NUMERO, 7, "0", STR_PAD_LEFT)}}</td>

            <td>{{$item->RZ_PROVEEDOR}}</td>
            <td>{{$item->RUC_PROVEEDOR}}</td>
            <td>{{$item->TXT_NOMBRE_PRODUCTO}}</td>
            <td>{{$item->IND_MATERIAL_SERVICIO}}</td>
            <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
            <td>{{$item->CAN_TIPO_CAMBIO}}</td>
            <td>{{$item->CAN_PRODUCTO}}</td>
            <td>{{$item->CAN_VALOR_VENTA}}</td>
            <td>
                @if($item->IND_IGV == 1)
                    {{$item->CAN_VALOR_VENTA_IGV - $item->CAN_VALOR_VENTA}}
                @else
                    0.00
                @endif
            </td>
            <td>{{$item->CAN_VALOR_VENTA_IGV}}</td>
            <td>          
                @IF($item->CAN_DETRACCION>0)
                    SI
                @ELSE
                    NO
                @ENDIF
            </td>
            <td>-</td>
            <td>{{$item->CAN_DETRACCION}}</td>
            <td>-</td>
            <td>-</td>
        </tr>
        @endforeach
    </table>
</html>