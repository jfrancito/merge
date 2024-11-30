
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


	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
	  <thead>
	    <tr>
	      <th>ITEM</th>
	      <th>NRO CONTRATO</th>
	      <th>DOCUMENTO</th>

	      <th>PROVEEDOR</th>
	      <th>BANCO</th>
	      <th>COMPROBANTE ASOCIADO</th>
	      <th>FECHA VENCIMIENTO DOC</th>
	      <th>FECHA APROBACION ADMIN</th>
	      <th>TIPO</th>
	      <th>SUBIO VOUCHER</th>
	      <th>ORDEN INGRESO</th>
	      <th>PAGO DETRACCION</th>

	      <th>IMPORTE</th>
	      <th>DETRACCION</th>
	      <th>ANTICIPO</th>

	      <th>NETO A PAGAR</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@php $monto_total =  0; @endphp
	    @foreach($listadatos as $index => $item)



	      <tr>
	        <td>{{$index + 1}}</td>
	        <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>
	        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}<</td>
	        <td>{{$item->TXT_EMPR_EMISOR}}</td>
	        <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
	        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
	        <td>{{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}</td>
	        <td>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</td>
	        <td>{{$item->IND_MATERIAL_SERVICIO}}</td>
	        <td>
	            @IF($item->COD_ESTADO_VOUCHER == 'ETM0000000000008')
	              SI
	            @ELSE
	              NO
	            @ENDIF
	        </td>
	        <td>{{$item->COD_TABLA_ASOC}}</td>

	        <td>{{$item->TXT_PAGO_DETRACCION}}</td>

	        <td>{{$item->TOTAL_VENTA_ORIG}}</td>
	        <td>
	          {{$funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)}}
	        </td>
	        <td>{{ISNULL($item->MONTO_ANTICIPO_DESC,0)}}</td>

	        <td>
				{{$item->TOTAL_VENTA_ORIG - ISNULL($item->MONTO_ANTICIPO_DESC,0) - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)}}
				@php $monto_total  = $monto_total + ($item->TOTAL_VENTA_ORIG - ISNULL($item->MONTO_ANTICIPO_DESC,0) - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)); @endphp
	        </td>
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
	        <td>{{number_format($monto_total, 2, '.', '')}}</td>
	      </tr>                    
	  </tfoot>
	</table>


</html>