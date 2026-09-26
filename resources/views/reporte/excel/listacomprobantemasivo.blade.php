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
            <th class= 'tabladp'>FECHA EMISIÓN DE LA ORDEN</th>
			<th class= 'tabladp'>FECHA EMISIÓN DE COMPROBANTE</th>
            <th class= 'tabladp'>FECHA REVISION CONTABILIDAD</th>

            <th class= 'tabladp'>FECHA AUTORIZACION</th>
            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>CODIGO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>

            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN FACTURA</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN ORDEN DE COMPRA</th>

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
            <th class= 'tabladp'>NUMERO DE CUENTA CONTABLE</th>

            <th class= 'tabladp'>USUARIO CONTACTO</th>
            <th class= 'tabladp'>REPARABLE</th>
            <th class= 'tabladp'>MENSAJE REPARABLE</th>
            <th class= 'tabladp'>FECHA SE LEVANTO REPARABLE (USUARIO)</th>
            <th class= 'tabladp'>FECHA SE LEVANTO REPARABLE (CONTA)</th>

            <th class= 'tabladp'>OBSERVACION</th>


            <th class= 'tabladp'>MEDIO PAGO</th>
            <th class= 'tabladp'>FECHA PAGO</th>
            <th class= 'tabladp'>NOMBRE BANCO</th>
            <th class= 'tabladp'>IMPORTE PAGADO</th>
            <th class= 'tabladp'>PDF PAGO MERGE</th>

        </tr>
        @foreach($listadatos as $index => $item) 
        <tr>
			<td>{{date_format(date_create($item->FEC_ORDEN), 'd-m-Y')}}</td>
            <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
            <td>{{date_format(date_create($item->fecha_pr), 'd-m-Y')}}</td>
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
            <td>{{$item->PRODUCTO}}</td>
            <td>{{$item->productos_cabecera2}}</td>

            <td>{{$item->IND_MATERIAL_SERVICIO}}</td>
            <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
            <td>{{$item->CAN_TIPO_CAMBIO}}</td>
            
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->CANTIDAD}}
                @else
                    1
                @endif
            </td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->VAL_SUBTOTAL_ORIG}}
                @else
                    {{$item->SUB_TOTAL_VENTA_ORIG}}
                @endif
            </td>
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->VAL_IGV_ORIG}}
                @else
                    {{$item->VALOR_IGV_ORIG}}
                @endif
            <td>
                @if($item->ID_TIPO_DOC == '01')
                    {{$item->VAL_VENTA_ORIG}}
                @else
                    {{$item->TOTAL_VENTA_ORIG}}
                @endif
            </td>


            @php
                $es_tipo_det_valido = (!empty($item->TIPO_DETRACCION) && !in_array(trim($item->TIPO_DETRACCION), ['Credito', 'Contado']));
                $tiene_detraccion = (((float)$item->MONTO_DETRACCION_RED > 0) || (!empty($item->CTA_DETRACCION)) || $es_tipo_det_valido);
                $monto_detraccion = $tiene_detraccion ? (((float)$item->MONTO_DETRACCION_RED > 0) ? (float)$item->MONTO_DETRACCION_RED : (((float)$item->CAN_DETRACCION > 0) ? (float)$item->CAN_DETRACCION : 0)) : 0;
                $tiene_constancia = (!empty($item->FOLIO_DETRACCION) || !empty($item->FOLIO_DETRACCION_RESERVA) || !empty($item->COD_PAGO_DETRACCION));
                $nro_constancia = !empty($item->FOLIO_DETRACCION) ? $item->FOLIO_DETRACCION : (!empty($item->FOLIO_DETRACCION_RESERVA) ? $item->FOLIO_DETRACCION_RESERVA : (!empty($item->COD_PAGO_DETRACCION) ? $item->COD_PAGO_DETRACCION : '-'));
                $nro_cuenta = !empty($item->NRO_CUENTA) ? $item->NRO_CUENTA : '-';
            @endphp
            <td>{{ $tiene_detraccion ? 'SI' : 'NO' }}</td>
            <td>{{ $es_tipo_det_valido ? trim($item->TIPO_DETRACCION) : '-' }}</td>
            <td>{{ $monto_detraccion }}</td>
            <td>{{ $tiene_constancia ? 'SI' : 'NO' }}</td>
            <td>{{ $nro_constancia }}</td>
            <td>{{ $nro_cuenta }}</td>
            <td>{{$item->TXT_CONTACTO_N}}</td>
            <td>          
                @IF(count($item->productos_reparable)>0)
                    SI
                @ELSE
                    NO
                @ENDIF
            </td>
            <td>{{$item->productos_reparable}}</td>
            <td>{{$item->fecha_reparable}}</td>
            <td>{{$item->fecha_reparable_conta}}</td>
            

            <td>{{$item->TXT_GLOSA_ORDEN}}</td>
            
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
