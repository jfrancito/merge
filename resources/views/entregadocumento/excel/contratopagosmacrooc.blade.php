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
	      	<th class="border cplomo">DATOS GENERALES</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Código de Cliente</th>
	      	<th class="border cplomo">Tipo de Planilla</th>
	      	<th class="border cplomo">Entidad Bancaria</th>
	      	<th class="border cplomo">Empresa</th>
	  	</tr>
	  	<tr>
	      	<th>000000</th>
	      	<th>PROV</th>
	      	<th>{{$txt_banco}}</th>
	      	<th>{{$empresa->NOM_EMPR}}</th>
	  	</tr>
	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">DATOS DEL CARGO</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Tipo de Registro</th>
	      	<th class="border cplomo">Cantidad de abonos de la planilla</th>
	      	<th class="border cplomo">Fecha de proceso</th>
	      	<th class="border cplomo">Tipo de Cuenta de cargo</th>
	      	<th class="border cplomo">Cuenta de cargo</th>
	      	<th class="border cplomo">Monto total de la planilla</th>
	      	<th class="border cplomo">Referencia de la planilla</th>

	  	</tr>
	  	<tr>
	      	<th>C</th>
	      	<th>{{$countfedocu}}</th>
	      	<th>{{date_format(date_create($folio->FECHA_CREA), 'Ymd')}}</th>
	      	<th>C</th>
	      	<th></th>
	     	<th>{{number_format($listadocumento->sum('TOTAL_PAGAR'), 2, '.', '')}}</th>
	     	<th>FLETES</th>
	  	</tr>

	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">"DATOS DEL ABONO A CUENTA</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Tipo de Registro</th>
	      	<th class="border cplomo">Tipo de Cuenta de Abono</th>
	      	<th class="border cplomo">Cuenta de Abono</th>
	      	<th class="border cplomo">Tipo de Documento de Identidad</th>
	      	<th class="border cplomo">Número de Documento de Identidad</th>
	      	<th class="border cplomo">Correlativo de Documento de Identidad</th>
	      	<th class="border cplomo">Nombre del proveedor</th>
	      	<th class="border cplomo">Tipo de Moneda de Abono</th>
	      	<th class="border cplomo">Monto del Abono</th>
	      	<th class="border cplomo">Validación IDC del proveedor vs Cuenta</th>
	      	<th class="border cplomo">Cantidad Documentos</th>

	  	</tr>
	  </thead>
	  <tbody class="tabladet">
	    @foreach($listadocumento as $index => $item)
	      <tr>
	      	<td>A</td>
	        <td><b>{{$item->TXT_NRO_CUENTA_BANCARIA}}</b></td>
	        <td>{{$item->TXT_ABREVIATURA}}</td>
	        <td>{{$item->CODIGO_SUNAT}}</td>
	        <td>{{$item->NRO_DOCUMENTO}}</td>
		    <td></td>	        
	        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
	        <td>{{$item->TIPO_MONEDA}}</td>
	        <td>{{number_format($item->TOTAL_PAGAR, 2, '.', '')}}</td>
	        <td>S</td>
	        <td>0000</td>
	      </tr>                    
	    @endforeach
	  </tbody>
	</table>



</html>