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
	@include('entregadetraccion.excel.ajax.cabecera')
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
		      <th>NETO A PAGAR</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@php $monto_total =  0; @endphp
		    @foreach($listadatos as $index => $item)
			  @php $monto_total  = $monto_total + $item->MONTO_DETRACCION_RED; @endphp

		      <tr>
		        <td>{{$index + 1}}</td>
		        <td>{{$item->OPERACION}}</td>
		        <td>{{$item->ID_DOCUMENTO}}</td>
		        <td>{{$item->RUC_PROVEEDOR}}</td>
		        <td>{{$item->RZ_PROVEEDOR}}</td>
		        <td>BANCO DE LA NACION</td>
		        <td><b>{{$item->CTA_DETRACCION}}</b></td>
		        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
		        <td><b>{{number_format($item->MONTO_DETRACCION_RED, 2, '.', ',')}}</b></td>
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
		        <td><b>{{$simbolo}} {{number_format($monto_total, 2, '.', ',')}}</b></td>
		      </tr>                    
		  </tfoot>
		</table>

</html>