<form method="POST" id='formpedido' action="{{ url('/pago-comprobante-tesoreria-masivo/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
{{ csrf_field() }}

	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				INTEGRACION MASIVA
			</div>
		</div>
	</div>
	<div class="modal-body" style="padding-top: 0px;">
		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
				  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            <div class="row">


	            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	            	<br>
								<table class="table table-striped table-hover">
                    <thead>
                      <tr>
                      	<th>ORDEN COMPRA</th>
                      	<th>PROVEEDOR</th>
                      	<th>DOCUMENTO</th>
                      	<th>TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
				              @foreach($datastring as $index => $item) 
                      <tr>
                        <td>
                        	<span>{{$item->data_orden_compra}}</span>
                        </td>
                        <td>
                        	<span>{{$item->data_proveedor}}</span>
                        </td>
                        <td>
                        	<span>{{$item->data_serie}} - {{$item->data_numero}}</span>
                        </td>
                        <td>
                        	<span>{{$item->data_total}}</span>
                        </td>
                      </tr>
				              @endforeach
                    </tbody>
                  </table>
	            </div>


	              @foreach($tarchivos as $index => $item) 
	                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
		</div>
	</div>

	<div class="modal-footer">
		<input type="hidden" name="datastring" id='datastring' value='{{$datastring_n}}' >
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




