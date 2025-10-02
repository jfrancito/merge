	<div class="panel panel-default panel-contrast">
	  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
	  </div>
	  <div class="panel-body panel-body-contrast">

						  <div class="tab-container">
							<ul class="nav nav-tabs">
							  <li class="active"><a href="#oc" data-toggle="tab">ORDEN COMPRA</a></li>
							  <li><a href="#xml" data-toggle="tab">XML</a></li>
							</ul>
							<div class="tab-content">
							  <div id="oc" class="tab-pane active cont">

									<table class="table table-condensed table-striped">
									  <thead>
										<tr>
										  <th>Codigo Orden</th>
										  <th>Fecha Orden</th>      
										  <th>Proveedor</th>       
										  <th>Total</th>
										</tr>
									  </thead>
									  <tbody>
										  <tr>
											<td>{{$ordencompra->COD_ORDEN}}</td>
											<td>{{$ordencompra->FEC_ORDEN}}</td>
											<td>{{$ordencompra->TXT_EMPR_CLIENTE}}</td>
											<td>{{$ordencompra->CAN_TOTAL}}</td>
										  </tr>
									  </tbody>
									</table>


								  
								  <table class="table table-condensed table-striped tablainformacion">
									  <thead>
										<tr>
										  <th>Codigo Producto</th>
										  <th>Nombre Producto</th>
										  <th>Unidad</th>
										  <th>Cantidad</th>
										  <th>Precio</th>
										  <th>Total</th>
										  <th>Opciones</th>
										</tr>
									  </thead>
									  <tbody>

										 @foreach($detalleordencompraaf as $index => $item)  
											<tr>
											  <td>{{$item->COD_PRODUCTO}}</td>
											  <td>{{$item->TXT_NOMBRE_PRODUCTO}}</td>
											  <td>{{$item->UNID_MED}}</td>

											  <td>{{number_format($item->CAN_PRODUCTO, 4, '.', ',')}}</td>
											  <td>{{number_format($item->CAN_PRECIO_UNIT_IGV, 4, '.', ',')}}</td>
											  <td>{{number_format($item->CAN_VALOR_VENTA_IGV, 4, '.', ',')}}</td>
											  <td class="tdopcionesordaf" style="	display: flex;align-content: center;flex-wrap: nowrap;flex-direction: row;justify-content: center;align-items: baseline;">
													 	<input 
							                type="checkbox" 
							                id="checkboxcataf{{$index}}" 
							                class="checkboxcataf"
							                attcodprod="{{ $item->COD_PRODUCTO }}"
														  attcantprod="{{ $item->CAN_PRODUCTO }}"
														  attcodlote="{{ $item->COD_LOTE }}"
														  attnrolinea="{{ $item->NRO_LINEA }}"
														  atttxtdetprod="{{ $item->TXT_DETALLE_PRODUCTO }}"
														  atttxtnombprod="{{ $item->TXT_NOMBRE_PRODUCTO }}"
							                style="accent-color: green;width: 15px;height:15px;border-radius: 5px; transform: scale(1.5);cursor: not-allowed;margin-right: 5px;" 
							                {{ $funciones->DPAF($idoc,$item->COD_PRODUCTO) ? 'checked' : '' }}
							                >

													   <button 
												        type="button" 
												        name="btnActivoFijo"
												        class="btn btn-xs btn-primary btnActivoFijo"
												        attcodprod="{{ $item->COD_PRODUCTO }}"
												        attcantprod="{{ $item->CAN_PRODUCTO }}"
												        attcodlote="{{ $item->COD_LOTE }}"
												  			attnrolinea="{{ $item->NRO_LINEA }}"
														  	atttxtdetprod="{{ $item->TXT_DETALLE_PRODUCTO }}"
												  			atttxtnombprod="{{ $item->TXT_NOMBRE_PRODUCTO }}"
												        id="btnActivoFijo{{ $index }}"
												        idcheckbox="checkboxcataf{{$index}}"
												        title="Asignar categoría de Activo Fijo"
																style="font-size: 24px !important;border-radius: 5px; margin-top: -10px;"
												        >
												        <span class="mdi mdi-assignment" ></span>
												    </button>
													  {{-- <span class="mdi mdi-assignment-o"></span> --}}
												</td>

											</tr>
										  @endforeach

									  </tbody>
								  </table>

							  </div>
							  <div id="xml" class="tab-pane cont">

									<table class="table table-condensed table-striped">
									  <thead>
										<tr>
										  <th>Serie</th>
										  <th>Numero</th>      
										  <th>Fecha Emision</th>       
										  <th>Forma Pago</th>
										</tr>
									  </thead>
									  <tbody>
										  <tr>
											<td>{{$fedocumento->SERIE}}</td>
											<td>{{$fedocumento->NUMERO}}</td>
											<td>{{$fedocumento->FEC_VENTA}}</td>
											<td>{{$fedocumento->FORMA_PAGO}}</td>
										  </tr>
									  </tbody>
									</table>


								  <table class="table table-condensed table-striped">
									  <thead>
										<tr>
										  <th>Codigo Producto</th>
										  <th>Nombre Producto</th>
										  <th>Unidad</th>
										  <th>Cantidad</th>
										  <th>Precio</th>
										  <th>Total</th>
										</tr>
									  </thead>
									  <tbody>
										 @foreach($detallefedocumento as $index => $item)  
											<tr>
											  <td>{{$item->CODPROD}}</td>
											  <td>{{$item->PRODUCTO}}</td>
											  <td>{{$item->UND_PROD}}</td>
											  <td>{{number_format($item->CANTIDAD, 4, '.', ',')}}</td>
											  <td>{{number_format($item->PRECIO_ORIG, 4, '.', ',')}}</td>
											  <td>{{number_format($item->VAL_VENTA_ORIG, 4, '.', ',')}}</td>
											</tr>
										  @endforeach
									  </tbody>
								  </table>


							  </div>

							</div>
						  </div>


	  </div>
	</div>

	<div id="modal-content-categoria-af" class="modal-dialog modal-container colored-header colored-header-warning modal-effect-6" style="margin-top: -40px;">
		<div class="modal-content ">
			<div class='modal-content-categoria-af-container'>
			</div>
		</div>
	</div>

