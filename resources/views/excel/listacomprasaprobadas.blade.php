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
	<table class="tabladet">
	  <thead>
	    <tr>
	      <th>OPERACION</th>
	      <th>N° DE ORDEN DE COMPRA</th>
	      <th>EMPRESA</th>
	      <th>PROVEEDOR</th>
	      <th>N° COMPROBANTE</th>
	      <th>IMPORTE TOTAL</th>
	      <th>IMPORTE NETO</th>
	      <th>GENERO OC</th>
	      <th>FECHA DE APROBACION</th>
	      <th>APROBACION JEFATURA</th>
	      <th>FECHA DE APROBACION</th>

	      <th>CONTABILIDAD</th>
	      <th>FECHA DE APROBACION</th>     
	      <th>ADMINISTRACION</th>
	      <th>FECHA DE APROBACION</th>  
	    </tr>
	  </thead>
	  <tbody>
	    @foreach($listadocumentos as $index => $item)
	      <tr>
	        <td>{{$item->OPERACION}}</td>
	        <td>{{$item->ID_DOCUMENTO}}</td>
	        <td>{{$item->NOMBRE_CLIENTE}}</td>
	        <td>{{$item->RZ_PROVEEDOR}}</td>
	        <td>{{$item->SERIE}} - {{ str_pad($item->NUMERO, 10, '0', STR_PAD_LEFT) }}</td>
	        <td>{{$item->TOTAL_VENTA_ORIG}}</td>      
	        <td>{{$item->SUB_TOTAL_VENTA_ORIG}}</td>
	        <td>{{$item->nombre}}</td>
	        <td>{{$item->fecha_uc}}</td>
	        <td>{{$item->TXT_NOMBRES}}</td>
	        <td>{{$item->fecha_uc}}</td>

	        <td>{{$item->nombreconta}}</td>
	        <td>{{$item->fecha_pr}}</td>
	        <td>{{$item->nombreadmin}}</td>      
	        <td>{{$item->fecha_ap}}</td>

	      </tr>                    
	    @endforeach
	  </tbody>
	</table>
</html>