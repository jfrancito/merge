
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
	  <thead>
	  	<tr>
	      	<th></th>
	      	<th></th>
	      	<th></th>
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
	      	<th>N° CARGO:</th>
	      	<th>{{$folio->FOLIO}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th>FECHA EMISIÓN:</th>
	      	<th>{{date_format(date_create($folio->FECHA_CREA), 'd-m-Y')}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th></th>
	      	<th>RAZON SOCIAL:</th>
	      	<th>{{$empresa->NOM_EMPR}}</th>
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
	      	<th>RUC:</th>
	      	<th>{{$empresa->NRO_DOCUMENTO}}</th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>



	  </thead>
	</table>

</html>