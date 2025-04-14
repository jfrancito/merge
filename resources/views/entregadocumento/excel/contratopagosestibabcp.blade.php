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

	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
	  <thead>
	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">N° CARGO:</th>
	      	<th class="border cplomo">{{$folio->FOLIO}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th class="border cplomo">FECHA EMISIÓN:</th>
	      	<th class="border cplomo">{{date_format(date_create($folio->FECHA_CREA), 'd-m-Y')}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">RAZON SOCIAL:</th>
	      	<th class="border cplomo">{{$empresa->NOM_EMPR}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">RUC:</th>
	      	<th class="border cplomo">{{$empresa->NRO_DOCUMENTO}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th></th>
	  	</tr>

	  	<tr>
	      	<th class="border cplomo">PROVEEDOR:</th>
	      	<th class="border cplomo">{{$proveedor->TXT_EMPR_EMISOR}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>

	      	<th class="border cplomo">BANCO:</th>
	      	<th class="border cplomo">{{$fedocumento->TXT_CATEGORIA_BANCO}}</th>
	      	<th class="border cplomo">CUENTA:</th>
	      	<th class="border cplomo"><b>{{$fedocumento->TXT_NRO_CUENTA_BANCARIA}}</b></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>

	  	<tr>
	      	<th class="border cplomo">CUENTA DE DETRACCION:</th>
	      	<th class="border cplomo"><b>{{$empresa_item->TXT_DETRACCION}}</b></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>


	  	<tr>
	      	<th>POR SERVICIO DE TRANSPORTE DE CARGA, UNIDAD DE MEDIDA: SACOS, SEGÚN: GR-R N°</th>
	  	</tr>

	  </thead>
	</table>


	<table class="tabladet">
	  <thead>
	    <tr>

	      <th>FECHA EMISIÓN</th>
	      <th>N° FACTURA</th>
	      <th>IMPORTE (S/)</th>
	      <th>DETRACCIÓN (S/)</th>
	      <th>DETRACCIÓN (S/)</th>
	      <th>OTROS DESCUENTOS (S/)</th>
	      <th>ANTICIPO</th>
	      <th>IMPORTE A CANCELAR (S/)</th>
	    </tr>
	  </thead>
	  <tbody>
		@php $monto_total  = 0; @endphp
	    @foreach($listadocumento as $index => $item)
	      <tr>

	        <td>{{date_format(date_create($item->FEC_EMISION), 'd-m-Y')}}</td>
	        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
	        <td>{{$item->TOTAL_VENTA_ORIG}}</td>
	        <td>{{$item->MONTO_DETRACCION_XML}}</td>
	        <td>{{$item->MONTO_DETRACCION_RED}}</td>
			<td>0.00</td>
	        <td>{{$item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS}}</td>

	        <td>
	        	{{$item->TOTAL_VENTA_ORIG - $item->MONTO_ANTICIPO_DESC - $item->MONTO_ANTICIPO_DESC_OTROS - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)}}
				@php $monto_total  = $monto_total + ($item->TOTAL_VENTA_ORIG - $item->MONTO_ANTICIPO_DESC - $item->MONTO_ANTICIPO_DESC_OTROS - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)); @endphp
	        </td>
	      </tr>                    
	    @endforeach
	  </tbody>
	  <tfoot>
	      <tr>
	        <th>TOTAL</th>
	        <th></th>

	        <th>{{number_format($listadocumento->SUM('TOTAL_VENTA_ORIG'), 2, '.', '')}}</th>
	        <th>{{number_format($listadocumento->SUM('MONTO_DETRACCION_XML'), 2, '.', '')}}</th>
	        <th>{{number_format($listadocumento->SUM('MONTO_DETRACCION_RED'), 2, '.', '')}}</th>
	        <th>0.00</th>
	        <th>0.00</th>
	        <th>{{$monto_total}}</th>
	      </tr>                    
	  </tfoot>


	</table>
</html>