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
            <th class= 'tabladp'>MONEDA</th>

            <th class= 'tabladp'>TIPO DE CAMBIO</th>
            <th class= 'tabladp'>TOTAL</th>

            <th class= 'tabladp'>COD OPERACION CAJA</th>
            <th class= 'tabladp'>MOVIMIENTO</th>
            <th class= 'tabladp'>BANCO</th>
            <th class= 'tabladp'>CUENTA</th>


            <th class= 'tabladp'>MEDIO PAGO</th>
            <th class= 'tabladp'>FECHA PAGO</th>
            <th class= 'tabladp'>NOMBRE BANCO</th>
            <th class= 'tabladp'>IMPORTE PAGADO</th>
            <th class= 'tabladp'>PDF PAGO MERGE</th>


        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
            <td>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    FACTURA
                @else
                    @if($item->ID_TIPO_DOC == 'R1')
                        RECIBO POR HONORARIO
                    @else
                        RECIBO DE SERVICIOS
                    @endif
                @endif
            </td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->ID_TIPO_DOC}}
                @else
                    @if($item->ID_TIPO_DOC == 'R1')
                        02
                    @else
                        14
                    @endif
                @endif
            </td>
            <td>{{$item->SERIE}} - {{str_pad($item->NUMERO, 7, "0", STR_PAD_LEFT)}}</td>
            <td>{{$item->RZ_PROVEEDOR}}</td>
            <td>{{$item->RUC_PROVEEDOR}}</td>
            <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
            <td>{{$item->CAN_TIPO_CAMBIO}}</td>
            <td>
                {{$item->TOTAL_VENTA_ORIG}}
            </td>
            <td>{{$item->COD_OPERACION_CAJA}}</td>
            <td>{{$item->TXT_ITEM_MOVIMIENTO}}</td>
            <td>{{$item->NOMBRE_BANCO_CAJA}}</td>
            <td>{{$item->CUENTA}}</td>


            <td>{{$item->MEDIO_PAGO}}</td>
            <td>{{$item->FECHA_PAGO}}</td>
            <td>{{$item->NOMBRE_BANCO}}</td>
            <td>{{$item->IMPORTE}}</td>

            <td>
                @if($item->COD_ESTADO_FE == 'ETM0000000000008')
                    SI
                @else
                    NO
                @endif
            </td>


        </tr>
        @endforeach
    </table>
</html>
