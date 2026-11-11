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
	      <th>DOI Tipo</th>
	      <th>DOI Número</th>
	      <th>Tipo Abono</th>
	      <th>N° Cuentas a Abonar</th>
	      <th>Nombre de Beneficiario</th>
	      <th>Importe Abonar</th>
	      <th>Tipo Recibo</th>
	      <th>N° Documento</th>
	      <th>Abono agrupado</th>
	      <th>Referencia</th>
	      <th>Indicador Aviso</th>
	      <th>Medio de aviso</th>
	      <th>Persona Contacto</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@php $monto_total =  0; @endphp

	    @foreach($listadocumento as $index => $item)
	      <tr>
	        <td>{{$item->TXT_TIPO_REFERENCIA}}</td>
	        <td>{{$item->NRO_DOCUMENTO}}</td>
	        <td>P</td>
	        <td><div>{{$item->TXT_NRO_CUENTA_BANCARIA}}</div></td>
	        <td>{{$item->TXT_EMPR_EMISOR}}</td>
	        <td><b>{{number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')}}</b></td>
	        <td>{{substr($item->NRO_SERIE,0,1)}}</td>
	        <td>{{substr($item->NRO_SERIE,1)}} - {{$item->NRO_DOC}}</td>
	        <td>N</td>
	       	<td></td> 
	        <td>E</td>
	        <td></td>
	        <td>{{$item->TXT_CONTACTO}}</td>
	        @php $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO); @endphp
	        
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
		        <td><b>{{number_format($monto_total, 4, '.', ',')}}</b></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		       	<td></td>
		      </tr>                    
		</tfoot>

	</table>
</html>