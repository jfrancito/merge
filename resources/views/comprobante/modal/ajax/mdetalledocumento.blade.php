	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				DOCUMENTO {{$data_doc}}
			</div>
		</div>
	</div>
	<div class="modal-body loteestiba" style="padding-top: 0px;">
		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
				  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            <div class="row">
	            	<br>
								<table class="table table-striped table-hover tablalote" width="100%">
                    <thead>
                      <tr>
                      	<th>COD PRODUCTO</th>
                      	<th>NOMBRE PRODUCTO</th>
                      	<th>CANTIDAD</th>
                      </tr>
                    </thead>
                    <tbody>
				              @foreach($detalledocumento as $index => $item) 
                      <tr >
                        <td>{{$item->COD_PRODUCTO}}</td>
                        <td>{{$item->TXT_NOMBRE_PRODUCTO}}</td>
                        <td>{{$item->CAN_PRODUCTO}}</td>
                      </tr>
				              @endforeach
                    </tbody>
                  </table>

	            </div>
				    </div>
		</div>
	</div>





