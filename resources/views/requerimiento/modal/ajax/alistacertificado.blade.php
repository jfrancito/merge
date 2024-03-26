
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
	      	<tr>
	      	   <td>DIRECTOR</td>
	      	   <td>{{$i_nombre_director}}</td>
	      	   <td>{{$i_dni_director}}</td>
	      	</tr>

	      	<tr>
	      	   <td>SUBDIRECTOR </td>
	      	   <td>{{$i_nombre_subdirector}}</td>
	      	   <td>{{$i_dni_subdirector}}</td>
	      	</tr> 

	      	<tr>
	      	   <td>REPRESENTANTE DE DOCENTE </td>
	      	   <td>{{$i_nombre_representantedocente}}</td>
	      	   <td>{{$i_dni_representantedocente}}</td>
	      	</tr> 
	  
	      	<tr>
	      	   <td>REPRESENTANTE DE APAFA </td>
	      	   <td>{{$i_nombre_representanteapafa}}</td>
	      	   <td>{{$i_dni_representanteapafa}}</td>
	      	</tr>

	      	<tr>
	      	   <td>OTRO REPRESENTANTE DE LA COMUNIDAD </td>
	      	   <td>{{$i_nombre_otrorepresentatecomunidad}}</td>
	      	   <td>{{$i_dni_otrorepresentatecomunidad}}</td>
	      	</tr>

	      	@if($i_nombre_representanteadministrativo != '')
	      	<tr>
	      	   <td>REPRESENTANTE DE ADMINISTRATIVO </td>
	      	   <td>{{$i_nombre_representanteadministrativo}}</td>
	      	   <td>{{$i_dni_representanteadministrativo}}</td>
	      	</tr>
	      	@endif


	      	@if($i_nombre_representanteestudiante != '')
	      	<tr>
	      	   <td>REPRESENTANTE DE ADMINISTRATIVO </td>
	      	   <td>{{$i_nombre_representanteestudiante}}</td>
	      	   <td>{{$i_dni_representanteestudiante}}</td>
	      	</tr>
	      	@endif

	      	@if($i_nombre_representanteexalumno != '')
	      	<tr>
	      	   <td>REPRESENTANTE DE ADMINISTRATIVO </td>
	      	   <td>{{$i_nombre_representanteexalumno}}</td>
	      	   <td>{{$i_dni_representanteexalumno}}</td>
	      	</tr>
	      	@endif


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




