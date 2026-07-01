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
											<td><?php echo e($ordencompra->COD_ORDEN); ?></td>
											<td><?php echo e($ordencompra->FEC_ORDEN); ?></td>
											<td><?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?></td>
											<td><?php echo e($ordencompra->CAN_TOTAL); ?></td>
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

										 <?php $__currentLoopData = $detalleordencompraaf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
											<tr>
											  <td><?php echo e($item->COD_PRODUCTO); ?></td>
											  <td><?php echo e($item->TXT_NOMBRE_PRODUCTO); ?></td>
											  <td><?php echo e($item->UNID_MED); ?></td>

											  <td><?php echo e(number_format($item->CAN_PRODUCTO, 4, '.', ',')); ?></td>
											  <td><?php echo e(number_format($item->CAN_PRECIO_UNIT_IGV, 4, '.', ',')); ?></td>
											  <td><?php echo e(number_format($item->CAN_VALOR_VENTA_IGV, 4, '.', ',')); ?></td>
											  <td class="tdopcionesordaf" style="	display: flex;align-content: center;flex-wrap: nowrap;flex-direction: row;justify-content: center;align-items: baseline;">
													 	<input 
											                type="checkbox" 
											                id="checkboxcataf<?php echo e($index); ?>" 
											                class="checkboxcataf"
											                attd="<?php echo e(json_encode($item)); ?>"
											                attcodprod="<?php echo e($item->COD_PRODUCTO); ?>"
																		  attcantprod="<?php echo e($item->CAN_PRODUCTO); ?>"
																		  attcodlote="<?php echo e($item->COD_LOTE); ?>"
																		  attnrolinea="<?php echo e($item->NRO_LINEA); ?>"
																		  atttxtdetprod="<?php echo e($item->TXT_DETALLE_PRODUCTO); ?>"
																		  atttxtnombprod="<?php echo e($item->TXT_NOMBRE_PRODUCTO); ?>"
											                style="accent-color: green;width: 15px;height:15px;border-radius: 5px; transform: scale(1.5);cursor: not-allowed;margin-right: 5px;" 
											                <?php echo e($funciones->DPAF($idoc,$item->COD_PRODUCTO) ? 'checked' : ''); ?>

											                >

													   <button 
												        type="button" 
												        name="btnActivoFijo"
												        class="btn btn-xs btn-primary btnActivoFijo"
												        attcodprod="<?php echo e($item->COD_PRODUCTO); ?>"
												        attcantprod="<?php echo e($item->CAN_PRODUCTO); ?>"
												        attcodlote="<?php echo e($item->COD_LOTE); ?>"
												  			attnrolinea="<?php echo e($item->NRO_LINEA); ?>"
														  	atttxtdetprod="<?php echo e($item->TXT_DETALLE_PRODUCTO); ?>"
												  			atttxtnombprod="<?php echo e($item->TXT_NOMBRE_PRODUCTO); ?>"
												        id="btnActivoFijo<?php echo e($index); ?>"
												        idcheckbox="checkboxcataf<?php echo e($index); ?>"
												        title="Asignar categoría de Activo Fijo"
																style="font-size: 24px !important;border-radius: 5px; margin-top: -10px;"
												        >
												        <span class="mdi mdi-assignment" ></span>
												    </button>
													  
												</td>

											</tr>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
											<td><?php echo e($fedocumento->SERIE); ?></td>
											<td><?php echo e($fedocumento->NUMERO); ?></td>
											<td><?php echo e($fedocumento->FEC_VENTA); ?></td>
											<td><?php echo e($fedocumento->FORMA_PAGO); ?></td>
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
										 <?php $__currentLoopData = $detallefedocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
											<tr>
											  <td><?php echo e($item->CODPROD); ?></td>
											  <td><?php echo e($item->PRODUCTO); ?></td>
											  <td><?php echo e($item->UND_PROD); ?></td>
											  <td><?php echo e(number_format($item->CANTIDAD, 4, '.', ',')); ?></td>
											  <td><?php echo e(number_format($item->PRECIO_ORIG, 4, '.', ',')); ?></td>
											  <td><?php echo e(number_format($item->VAL_VENTA_ORIG, 4, '.', ',')); ?></td>
											</tr>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

