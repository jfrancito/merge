	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				LISTA DE PLANILLA DE MOVILIDAD
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
                      	<th>CODIGO</th>
                      	<th>SERIE</th>
                      	<th>NUMERO</th>
                      	<th>TRABAJADOR</th>
                      	<th>FECHA_EMI</th>
                      	<th>TOTAL</th>
                      	<th>SEL</th>
                      </tr>
                    </thead>
                    <tbody>
				              @foreach($lpmovilidades as $index => $item) 
                      <tr >
                        <td>{{$item->CODIGO}}</td>
                        <td>{{$item->SERIE}}</td>
												<td>{{$item->NUMERO}}</td>
												<td>{{$item->TXT_TRABAJADOR}}</td>
												<td>{{$item->FECHA_EMI}}</td>
												<td>{{$item->TOTAL}}</td>
                        <td>
                            <div class="icon iconoentregable">
                              <span class="mdi mdi-select-all mdisel" data_documento_planilla='{{$item->ID_DOCUMENTO}}' data_iddocumento='{{$iddocumento}}'></span>
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








