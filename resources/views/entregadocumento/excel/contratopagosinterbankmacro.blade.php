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
	<table class="tabladet">
	  <thead>
	    <tr>
	      <th>Tipo de Documento</th>
	      <th>Número de Documento</th>
	      <th>Nombre del Beneficiario</th>
	      <th>Correo Electrónico</th>
	      <th>N° Celular</th>
	      <th>Tipo de doc. de pago</th>
	      <th>N° de doc. de pago</th>
	      <th>Fecha de Vencimiento del documento</th>
	      <th>Tipo de Abono</th>
	      <th>Tipo de Cuenta</th>
	      <th>Moneda de Cuenta</th>
	      <th>N° Cuenta</th>
	      <th>Moneda de Abono</th>
	      <th>Monto de Abono</th>
	    </tr>
	  </thead>
	  <tbody>
	    @foreach($listadocumento as $index => $item)
	      <tr>
	        <td>{{$item->TXT_GLOSA_INTER}}</td>
	        <td>{{$item->NRO_DOCUMENTO}}</td>
	        <td>{{$item->TXT_EMPR_EMISOR}}</td>
	        <td></td>
	        <td></td>
	        <td>{{substr($item->TXT_CATEGORIA_TIPO_DOC,0,1)}}</td>
	        <td>{{$item->NRO_SERIE}}{{$item->NRO_DOC}}</td>
	        <td>{{date_format(date_create($item->FEC_VENCIMIENTO), 'Ymd')}}</td>
	        <td>09</td>
	        <td>{{$item->TIPO_CUENTA}}</td>
	        <td>{{$item->TIPO_MONEDA}}</td>
	        <td><div>{{$item->TXT_NRO_CUENTA_BANCARIA}}</div></td>
	        <td>{{$item->TIPO_MONEDA_ABONO}}</td>
	        <td>{{number_format($item->TOTAL_VENTA_ORIG - $item->MONTO_DETRACCION_RED, 2, '.', '')}}</td>
	      </tr>                    
	    @endforeach
	  </tbody>


	</table>
</html>