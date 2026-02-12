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
	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7" >
		  <thead>
		    <tr>
		      <th>TIPO</th>
		      <th>RUC</th>
		      <th>RAZON SOCIAL</th>
		      <th>DOC</th>
		      <th>CODIGO BYS</th>
		      <th>CUENTA PROVEEDOR</th>
		      <th>IMPORTE</th>
		      <th>TIPO OPERACION</th>
		      <th>PERIODO</th>
		      <th>TIPO DOC</th>
		      <th>SERIE</th>
		      <th>NUMERO</th>

		    </tr>
		  </thead>
		  <tbody>

		    @foreach($listadatos as $index => $item)

			@php
			    $fecha = $item->FEC_EMISION;
			    $carbonFecha = \Carbon\Carbon::parse($fecha);
			    
			    $anio = $carbonFecha->year;
			    $mes = str_pad($carbonFecha->month, 2, '0', STR_PAD_LEFT);
			   
			@endphp
		      <tr>
		        <td>6</td>
		        <td>{{$item->RUC_PROVEEDOR}}</td>
		        <td>{{$item->RZ_PROVEEDOR}}</td>
		        <td>00</td>
		        <td>00</td>
		        <td>{{$item->CTA_DETRACCION}}</td>
		        <td>{{$item->MONTO_DETRACCION_RED}}</td>
		        <td>01</td>
		        <td>{{$anio}}{{$mes}}</td>
		        <td>01</td>
		        <td>{{$item->NRO_SERIE}}</td>
		        <td>{{$item->NRO_DOC}}</td>
		      </tr>                    
		    @endforeach
		  </tbody>
		</table>

</html>