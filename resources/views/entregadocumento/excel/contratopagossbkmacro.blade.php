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
	      <th>RUC PROVEEDOR</th>
	      <th>RAZON SOCIAL</th>
	      <th>FORMA DE PAGO</th>
	      <th>CUENTA</th>
	      <th>CCI</th>
	      <th>IMPORTE</th>
	      <th>PAGO UNICO</th>
	      <th>TIPO DOCUMENTO</th>
	      <th>NUMERO DOCUMENTO</th>
	      <th>FECHA EMISION</th>
	      <th>CORREO ELECTRONICO</th>
	    </tr>
	  </thead>
	  <tbody>
	    @foreach($listadocumento as $index => $item)
	      <tr>
	        <td>{{$item->NRO_DOCUMENTO}}</td>
	        <td>{{$item->TXT_EMPR_EMISOR}}</td>
	        <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
	        <td><b>{{$item->TXT_NRO_CUENTA_BANCARIA}}</b></td>
	        <td></td>
	        <td>{{number_format($item->TOTAL_VENTA_ORIG - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO), 2, '.', '')}}</td>
	        <td>NO</td>
	        <td>{{$item->TXT_CATEGORIA_TIPO_DOC}}</td>
	        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
	        <td>{{date_format(date_create($item->FEC_EMISION), 'd-m-Y')}}</td>
	        <td></td>
	      </tr>                    
	    @endforeach
	  </tbody>


	</table>
</html>