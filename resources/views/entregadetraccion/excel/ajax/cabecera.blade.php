
<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
  <thead>
  	<tr>
      	<th></th>
  	</tr>
  	<tr>
        <th></th>
      	<th class="border cplomo">N° FOLIO:</th>
      	<th class="border cplomo">{{$folio->FOLIO}}</th>
  	</tr>

  	<tr>
        <th></th>
      	<th class="border cplomo">EMPRESA:</th>
      	<th class="border cplomo">{{Session::get('empresas')->NOM_EMPR}}</th>
  	</tr>

  	<tr>
        <th></th>
      	<th class="border cplomo">BANCO:</th>
      	<th class="border cplomo">{{$folio->TXT_CATEGORIA_BANCO}}</th>
  	</tr>
  	<tr>
        <th></th>
      	<th class="border cplomo">GLOSA:</th>
      	<th class="border cplomo">{{$folio->TXT_GLOSA}}</th>
  	</tr>
    
  	<tr>
        <th></th>
      	<th class="border cplomo">FECHA PAGO:</th>
      	<th class="border cplomo">{{date_format(date_create($folio->FEC_PAGO), 'd-m-Y')}}</th>
  	</tr>

  	<tr>
        <th></th>
      	<th class="border cplomo">USUARIO CREACION:</th>
      	<th class="border cplomo">{{$folio->nombre}}</th>
  	</tr>
  </thead>
</table>