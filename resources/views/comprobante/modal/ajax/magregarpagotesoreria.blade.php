<form method="POST" id='formpedido' action="{{ url('/pago-comprobante-tesoreria/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>

	  <div class="row">
			<div class="col-xs-6">
				ORDEN COMPRA : {{$ordencompra->COD_ORDEN}}
			</div>
			<div class="col-xs-5">
				FECHA : {{date_format(date_create($ordencompra->FEC_EMISION), 'd-m-Y')}}
			</div>	
		</div>

	  <div class="row">
			<div class="col-xs-6">
				PROVEEDOR : {{$ordencompra->TXT_EMPR_CLIENTE}}
			</div>
			<div class="col-xs-6">
				DOCUMENTO : {{$fedocumento->SERIE}} - {{$fedocumento->NUMERO}}
			</div>	
		</div>

	</div>
	<div class="modal-body" style="padding-top: 0px;">
		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
				  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	          <div class="be-checkbox">
	            <input id="check1" type="checkbox" name='partepago'>
	            <label for="check1">Parte del pago</label>
	          </div>
				  </div>
				  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            <div class="row">
	              @foreach($tarchivos as $index => $item) 
	                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                      <div class="form-group sectioncargarimagen">
	                          <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
	                          </label>
	                          <div class="col-sm-12">
	                              <div class="file-loading">
	                                  <input 
	                                  id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
	                                  name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
	                                  class="file-es"  
	                                  type="file" 
	                                  multiple data-max-file-count="1"
	                                  required>
	                              </div>
	                          </div>
	                      </div>
	                    </div>
	              @endforeach
	            </div>
				  </div>
				  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            <div class="row">
						    <div class="panel panel-default panel-contrast">
						      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PARTE DE PAGO
						      </div>
						      <div class="panel-body panel-body-contrast">
						        <table class="table table-condensed table-striped">
						          <thead>
						            <tr>
						              <th>Nro</th>
						              <th>Nombre</th>      
						              <th>Archivo</th>       
						              <th>Opciones</th>
						            </tr>
						          </thead>
						          <tbody>
						              @foreach($archivospp as $index => $item)  
						                <tr>
						                  <td>{{$index + 1}}</td>
						                  <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
						                  <td>{{$item->NOMBRE_ARCHIVO}}</td>

						                  <td class="rigth">
						                    <div class="btn-group btn-hspace">
						                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
						                      <ul role="menu" class="dropdown-menu pull-right">
						                          <li>
						                            <a class="elimnaritem" data_tipoarchivo="{{$item->TIPO_ARCHIVO}}" 
						                            											 data_nombrearchivo="{{$item->NOMBRE_ARCHIVO}}"
						                            											 data_linea="{{$linea}}"
						                            											 data_iddocumento="{{$cod_orden}}"
						                            											 href="#">
						                              Eliminar Item
						                            </a>
						                          </li>
						                      </ul>
						                    </div>
						                  </td>
						                </tr>
						              @endforeach
						          </tbody>
						        </table>
						      </div>
						    </div>
	            </div>
				  </div>



		</div>
	</div>
	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
	</div>
</form>
@if(isset($ajax))
  <script type="text/javascript">
      @foreach($tarchivos as $index => $item) 
         $('#file-{{$item->COD_CATEGORIA_DOCUMENTO}}').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['{{$item->TXT_FORMATO}}'],
          });
      @endforeach
  </script>
@endif




