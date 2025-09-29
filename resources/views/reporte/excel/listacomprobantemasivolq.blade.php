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
            <th class= 'tabladp'>ID LIQUIDACION</th>
            <th class= 'tabladp'>TRABAJADOR</th>
            <th class= 'tabladp'>FECHA EMISIÓN DE LIQUIDACION</th>
            <th class= 'tabladp'>FECHA EMISIÓN DE COMPROBANTE</th>
            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>
            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN FACTURA</th>
            <th class= 'tabladp'>MONEDA</th>
            <th class= 'tabladp'>CANTIDAD</th>
            <th class= 'tabladp'>BASE</th>
            <th class= 'tabladp'>IGV</th>
            <th class= 'tabladp'>TOTAL</th>
            <th class= 'tabladp'>USUARIO AUTORIZA</th>

            <th class= 'tabladp'>USUARIO</th>
            <th class= 'tabladp'>CORREO USUARIO</th>
            <th class= 'tabladp'>JEFE</th>
            <th class= 'tabladp'>CORREO JEFE</th>

        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
            <td>{{$item->ID_DOCUMENTO}}</td>
            <td>{{$item->TXT_EMPRESA_TRABAJADOR}}</td>

            <td>{{date_format(date_create($item->FECHA_EMI), 'd-m-Y')}}</td>
            <td>{{date_format(date_create($item->FECHA_EMISION), 'd-m-Y')}}</td>
            <td>{{$item->TXT_TIPODOCUMENTO}}</td>
            <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
            <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
            <td>{{$item->NRO_DOCUMENTO}}</td>
            <td>{{$item->TXT_PRODUCTO}}</td>
            <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
            <td>{{$item->CANTIDAD}}</td>
            <td>{{$item->SUBTOTAL}}</td>
            <td>{{$item->IGV}}</td>
            <td>{{$item->TOTAL}}</td>
            <td>{{$item->TXT_USUARIO_AUTORIZA}}</td>

            <td>{{$item->TXT_EMPRESA_TRABAJADOR}}</td>
            <td>{{$item->EMAIL_USUARIO}}</td>
            <td>{{$item->TXT_USUARIO_AUTORIZA}}</td>
            <td>{{$item->EMAIL_JEFE}}</td>



        </tr>
        @endforeach
    </table>
</html>
