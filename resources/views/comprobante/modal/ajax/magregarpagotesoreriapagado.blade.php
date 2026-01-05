<form method="POST" id='formpedido' action="{{ url('/pago-comprobante-tesoreria-pagado/'.$idopcion.'/'.$linea.'/'.substr($fedocumento->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($fedocumento->ID_DOCUMENTO, -10))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>


	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>

	  <div class="row">
			<div class="col-xs-6">
				ORDEN COMPRA : {{$fedocumento->ID_DOCUMENTO}}
			</div>
			<div class="col-xs-5">
				FECHA : {{date_format(date_create($fedocumento->FEC_VENTA), 'd-m-Y')}}
			</div>	
		</div>

	  <div class="row">
			<div class="col-xs-6">
				PROVEEDOR : {{$fedocumento->RZ_PROVEEDOR}}
			</div>
			<div class="col-xs-6">
				DOCUMENTO : {{$fedocumento->SERIE}} - {{$fedocumento->NUMERO}}
			</div>	
		</div>

	</div>
	<div class="modal-body" style="padding-top: 0px;">

		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

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
	                                  >
	                              </div>
	                          </div>
	                      </div>
	                    </div>
	              @endforeach
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
            var nombre_archivo = '{{$archivo->NOMBRE_ARCHIVO}}';
         		$('#file-{{$item->COD_CATEGORIA_DOCUMENTO}}').fileinput({
              theme: 'fa5',
              language: 'es',
              initialPreview: ["{{ route('serve-filepago', ['file' => '']) }}" + nombre_archivo],
              initialPreviewAsData: true,
              initialPreviewFileType: 'pdf',
              initialPreviewConfig: [
                  {type: "pdf", caption: nombre_archivo, downloadUrl: "{{ route('serve-filepago', ['file' => '']) }}" + nombre_archivo} // Para mostrar el botón de descarga
              ]
            });

      @endforeach

      
  </script>
@endif




