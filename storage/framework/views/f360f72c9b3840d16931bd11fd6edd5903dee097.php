	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" class="close modal-close" ><b><span style="color: white;font-size: 20px;margin-top: -15px;" class="mdi mdi-close"></span></b></button>
		<div class="row">
			<div class="col-xs-12">
				<h3>PRUDUCTO <?php echo e($oeProducto->TXT_NOMBRE_PRODUCTO); ?></h3>
			</div>
		</div>
	</div>
	<form 
		action="<?php echo e(url('/registrar-activo-fijo-categoria/'.$idopcion.'/'.$idoc.'/'.$COD_PRODUCTO)); ?>" 
		method="POST" 
		class="frmAgregarCategoriaActivoFijo" 
		name="frmAgregarCategoriaActivoFijo"
		id="frmAgregarCategoriaActivoFijo"
	>    
	<?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>


		<div class="modal-body loteestiba" style="padding-top: 0px;">
			
			<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
							<div class="form-group">
								<label>Código</label>
								<input type="text" class="form-control" id="codprod" readonly value="<?php echo e($oeProducto->COD_PRODUCTO); ?>">
								<input type="hidden" name="COD_TABLA" id="COD_TABLA" value="<?php echo e($oeProducto->COD_TABLA); ?>">
								<input type="hidden" name="COD_PRODUCTO" id="COD_PRODUCTO" value="<?php echo e($oeProducto->COD_PRODUCTO); ?>">
								<input type="hidden" name="NRO_LINEA" id="NRO_LINEA" value="<?php echo e($NRO_LINEA); ?>">
								<input type="hidden" name="COD_LOTE" id="COD_LOTE" value="<?php echo e($COD_LOTE); ?>">
								<input type="hidden" name="CAN_PRODUCTO" id="CAN_PRODUCTO" value="<?php echo e($CAN_PRODUCTO); ?>">
								<input type="hidden" name="TXT_DETALLE_PRODUCTO" id="TXT_DETALLE_PRODUCTO" value="<?php echo e($TXT_DETALLE_PRODUCTO); ?>">
								<input type="hidden" name="TXT_NOMBRE_PRODUCTO" id="TXT_NOMBRE_PRODUCTO" value="<?php echo e($oeProducto->TXT_NOMBRE_PRODUCTO); ?>">
								<input type="hidden" name="idcheckbox" id="idcheckbox" value="<?php echo e($idcheckbox); ?>">
							</div>

							<div class="form-group">
								<label>Cantidad</label>
								<input type="text" class="form-control" id="cantprod" readonly value="<?php echo e($oeProducto->CAN_PRODUCTO); ?>">
							</div>
							<div class="form-group">
								
			                            <label >CATEGORIA :</label>
			                                <?php echo Form::select( 'COD_CATEGORIA_AF', $combo_categoria_activo_fijo, $select_categoria_id,
			                                                  [
																'class'       => 'form-control control input-sm select2 select3' ,
			                                                    'id'          => 'COD_CATEGORIA_AF',
			                                                    'data-aw'     => '1',
			                                                    'required'    => true,
			                                                  ]); ?>

			                        

							</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
        	<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
            <button type="submit" id='btnGuardarCatAF' class="btn btn-success btnGuardarCatAF">Guardar</button>
        </div>
	</form>
<?php if(isset($ajax)): ?>


	<script type="text/javascript">
		$(document).ready(function(){
			App.init();
			$('.select3').select2();
		});
	</script>
<?php endif; ?>


