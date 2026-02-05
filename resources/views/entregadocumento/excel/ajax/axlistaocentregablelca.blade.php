<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<style type="text/css">
		.tabladet tr th{
			border: 1px solid;
		}	
		.tabladet tr td{
			border: 1px solid;
		}	
		.border{
			border: 1px solid;
		}
		.cplomo{
			background-color: #eeeeee;
		}
	</style>
	@include('entregadocumento.excel.ajax.cabecera')
	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7" >
		  <thead>
		    <tr>
		      <th>ITEM</th>
		      <th>OPERACION</th>
		      <th>DOCUMENTO</th>
		      <th>RUC</th>
		      <th>PROVEEDOR</th>
		      <th>BANCO</th>
		      <th>CUENTA ABONO</th>
		      <th>COMPROBANTE ASOCIADO</th>
		      <th>FECHA APROBACION ADMIN</th>
		      <th>SUBIO VOUCHER</th>

		      <th>IMPORTE</th>
		      <th>OBLIGACION</th>
		      <th>DESCUENTO</th>
		      <th>TOTAL DESCUENTO</th>
		      <th>PERCEPCION</th>
		      <th>ANTICIPO</th>
		      <th>NOTA CREDITO</th>
		      <th>COMPENSACION</th>
		      <th>NETO A PAGAR</th>
		      <th>CUENTA OSIRIS</th>

		    </tr>
		  </thead>
		  <tbody>
		  	@php $monto_total =  0; @endphp
		    @foreach($listadatos as $index => $item)
		       @php $NOMBRE_OSIRIS =  $funcion->funciones->cuenta_osiris_lca($item->ID_DOCUMENTO) @endphp
		      <tr>
		        <td>{{$index + 1}}</td>
		        <td>{{$item->OPERACION}}</td>
		        <td>{{$item->ID_DOCUMENTO}}</td>
		        <td>{{$item->RUC_PROVEEDOR}}</td>
		        <td>{{$item->RZ_PROVEEDOR}}</td>
		        <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
		        <td><b>{{$item->TXT_NRO_CUENTA_BANCARIA}}</b></td>
		        <td>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</td>

		        <td>
		            @IF($item->COD_ESTADO_VOUCHER == 'ETM0000000000008')
		              SI
		            @ELSE
		              NO
		            @ENDIF
		        </td>

		        <td><b>{{$item->TOTAL_VENTA_ORIG}}</b></td>
		        <td>
		          @IF($item->MONTO_DETRACCION_RED>0)
		            DETRACION
		          @ELSE
		            @IF($item->MONTO_RETENCION>0)
		              RETENCION IGV  
		            @ELSE
			            @IF($item->CAN_IMPUESTO_RENTA>0)
			              RETENCION 4TA         
			            @ENDIF
		            @ENDIF
		          @ENDIF
		        </td>
		        <td><b>{{number_format($item->CAN_DSCTO, 4, '.', ',')}}</b></td>
		        <td><b>
		          @IF($item->MONTO_DETRACCION_RED>0)
		            {{number_format(round($item->MONTO_DETRACCION_RED, 4),4, '.', ',')}}
		          @ELSE
		            @IF($item->MONTO_RETENCION>0)
		              {{number_format(round($item->MONTO_RETENCION, 4),4, '.', ',')}}
		            @ELSE
			            @IF($item->CAN_IMPUESTO_RENTA>0)
			              {{number_format(round($item->CAN_IMPUESTO_RENTA, 4),4, '.', ',')}}
			            @ELSE
			              0.00                
			            @ENDIF             
		            @ENDIF
		          @ENDIF
		          </b>
		        </td>
		        <td><b>{{ number_format(round($item->PERCEPCION, 4), 4, '.', ',') }}</b></td>
		        <td><b>{{ number_format(round($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',') }}</b></td>
		        <td><b>{{ number_format(round($item->MONTO_NC, 4), 4, '.', ',') }}</b></td>
		        <td><b>{{ number_format(round($item->COMPENSACION, 4), 4, '.', ',') }}</b></td>
		        <td><b>
		        	{{$simbolo}} {{number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 2, '.', ',')}}
			        @php $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO); @endphp
			        </b>
		        </td>
		        <td>{{$NOMBRE_OSIRIS}}</td>
		      </tr>                    
		    @endforeach

		  </tbody>
		  <tfoot>
		      <tr>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		       	<td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td><b>{{$simbolo}} {{number_format($monto_total, 2, '.', ',')}}</b></td>
		      </tr>                    
		  </tfoot>
		</table>

</html>