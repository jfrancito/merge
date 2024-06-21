
<div class="modal-header" style="padding: 12px 20px;">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<div class="col-xs-12">
		<h5 class="modal-title" style="font-size: 1.2em;">
			CERITIFICADO
		</h5>
	</div>
</div>
<div class="modal-body">

	<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
	<table class="table table-condensed table-striped">
	    <tbody>
	      	<tr>
	      	   <td><b>NRO ORDEN</b></td>
	      	   <td>FALTA</td>
	      	</tr>    
	      	<tr>
	      	   <td><b>REGION</b></td>
	      	   <td>{{$institucion->departamento}}</td>
	      	</tr>  
	      	<tr>
	      	   <td><b>PROVINCIA</b></td>
	      	   <td>{{$institucion->provincia}}</td>
	      	</tr>  
	      	<tr>
	      	   <td><b>DISTRITO/P.J/CENTRO POBLADO </b></td>
	      	   <td>{{$institucion->distrito}}</td>
	      	</tr>  
	      	<tr>
	      	   <td><b>INSTITUCIÓN EDUCATIVA </b></td>
	      	   <td>{{$institucion->nombre}}</td>
	      	</tr>  
	      	<tr>
	      	   <td><b>DIRECTORA </b></td>
	      	   <td>{{$director->nombres}}</td>
	      	</tr>  
	      	<tr>
	      	   <td><b>DIRECCION </b></td>
	      	   <td>{{$institucion->direccion}}</td>
	      	</tr>  
	    </tbody>
	</table>

	<table class="table table-condensed table-striped">
	    <tbody>
	      	<tr>
	      	   <td colspan="3" style="text-align: center;"><b>CONSEJO DIRECTIVO </b></td>
	      	</tr>  
	      	<tr>
	      	   <td class="center"><b>NOMBRES Y APELLIDOS </b></td>
	      	   <td class="center"><b>INTEGRANTES </b></td>
	      	   <td class="center"><b>DNI </b></td>
	      	</tr> 

          @foreach($data_o as $index => $item)
            <tr>
            	<td>{{$item['_i_tipodocumento_id']}}</td>
            	<td>{{$item['_i_documento']}}</td>
              <td>{{$item['_i_nombres']}}</td>
            </tr>
          @endforeach


          @foreach($array_detalle_producto as $index => $item)
            <tr>
            	<td>{{$item['dcargoni']}}</td>
            	<td>{{$item['nombresg']}}</td>
              	<td>{{$item['documentog']}}</td>
            </tr>
          @endforeach



	    </tbody>
	</table>




	</div>
</div>

<div class="modal-footer">

	<button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button>
	<button type="submit" data-dismiss="modal" class="btn btn-success btn-confirmar">Confirmar</button>


</div>




