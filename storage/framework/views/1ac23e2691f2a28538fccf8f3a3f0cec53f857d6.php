    <div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#registro" data-toggle="tab">REGISTRO</a></li>
          <li><a href="#partida" data-toggle="tab">PARTIDA</a></li>
          <li><a href="#llegada" data-toggle="tab">LLEGADA</a></li>  
        </ul>

        <div class="tab-content">
          	<div id="registro" class="tab-pane active cont">
				<?php if(isset($dplanillamovilidad)): ?>
					<form method="POST" id ='agregarpmd' class="form2" action="<?php echo e(url('/modificar-detalle-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8)).'/'.$dplanillamovilidad->ITEM )); ?>">
				<?php else: ?>
					<form method="POST" id ='agregarpmd' class="form2" action="<?php echo e(url('/guardar-detalle-planilla-movilidad/'.$idopcion.'/'.Hashids::encode(substr($planillamovilidad->ID_DOCUMENTO, -8)))); ?>">
				<?php endif; ?>
					<?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

					<div class="modal-header">
						<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
						<h3 class="modal-title">
							<?php echo e($planillamovilidad->TXT_TRABAJADOR); ?><span>: <?php echo e($planillamovilidad->SERIE); ?> - <?php echo e($planillamovilidad->NUMERO); ?></span>
						</h3>
					</div>
					<div class="modal-body">
						<div  class="row regla-modal">
						<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
						        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte">
						          <div class="form-group ">
						            <label class="col-sm-12 control-label labelleft negrita" >FECHA DEL GASTO  <span class="obligatorio">(*)</span>:</label>
						            <div class="col-sm-12 abajocaja" >
						              <div data-min-view="2" 
						                     data-date-format="dd-mm-yyyy"  
						                     class="input-group date datetimepicker02 pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
						                     <input size="16" type="text" 
						                            value="<?php if(isset($dplanillamovilidad)): ?><?php echo e(old('fecha_gasto' ,date_format(date_create(date($dplanillamovilidad->FECHA_GASTO)), 'd-m-Y'))); ?><?php else: ?><?php echo e(old('fecha_gasto')); ?><?php endif; ?>" 
						                            placeholder="FECHA DEL GASTO"
						                            id='fecha_gasto' 
						                            name='fecha_gasto' 
						                            class="form-control input-sm"/>
						                      <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
						                </div>
						            </div>
						          </div>
						        </div> 

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
									  <label class="col-sm-12 control-label labelleft negrita" >MOTIVO <span class="obligatorio">(*)</span> :</label>
									  <div class="col-sm-12">
									      <?php echo Form::select( 'motivo_id', $combomotivo, $motivo_id,
							                              [
							                                'class'       => 'select3 form-control control input-xs' ,
							                                'id'          => 'motivo_id',        
							                              ]); ?>

									  </div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-sm-12" >
										<p style="text-align: center;margin-top: 11px;margin-bottom: 11px;background: #34a853;color: #fff;cursor: pointer;" class="selpartida"><b>PARTIDA</b></p>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
									  <label class="col-sm-12 control-label labelleft negrita" >DEPARTAMENTO PARTIDA <span class="obligatorio">(*)</span> :</label>
									  <div class="col-sm-12">
									      <?php echo Form::select( 'departamentopartida_id', $combodepartamento, $departamento_id,
							                              [
							                                'class'       => 'select3 form-control control input-xs' ,
							                                'id'          => 'departamentopartida_id',        
							                              ]); ?>

									  </div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group ajax_provincia_partida">
										<?php echo $__env->make('general.ajax.comboprovinciapartida', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>


								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group ajax_distrito_partida">
										<?php echo $__env->make('general.ajax.combodistritopartida', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label class="col-sm-12 control-label labelleft negrita" >DIRECCION PARTIDA<span class="obligatorio">(*)</span>: </label>
										<div class="col-sm-12">
												<input  type="text"
																id="lugarpartida" 
																name='lugarpartida' 
																value="<?php if(isset($dplanillamovilidad)): ?><?php echo e(old('lugarpartida' ,$dplanillamovilidad->TXT_LUGARPARTIDA)); ?><?php else: ?><?php echo e(old('lugarpartida')); ?><?php endif; ?>" 
																placeholder="Lugar de Partida"
																autocomplete="off" 
																class="form-control input-sm validarmayusculas"/>
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-sm-12" >
										<p style="text-align: center;margin-top: 11px;margin-bottom: 11px;background: #cc0000;color: #fff;cursor: pointer;" class="selllegada"><b>LLEGADA</b></p>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
									  <label class="col-sm-12 control-label labelleft negrita" >DEPARTAMENTO LLEGADA <span class="obligatorio">(*)</span> :</label>
									  <div class="col-sm-12">
									      <?php echo Form::select( 'departamentollegada_id', $combodepartamentoll, $departamento_idll,
							                              [
							                                'class'       => 'select3 form-control control input-xs' ,
							                                'id'          => 'departamentollegada_id',        
							                              ]); ?>

									  </div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group ajax_provincia_llegada">
										<?php echo $__env->make('general.ajax.comboprovinciallegada', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>


								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group ajax_distrito_llegada">
										<?php echo $__env->make('general.ajax.combodistritollegada', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label class="col-sm-12 control-label labelleft negrita" >DIRECCION DE LLEGADA <span class="obligatorio">(*)</span>: </label>
										<div class="col-sm-12">
												<input  type="text"
																id="lugarllegada" 
																name='lugarllegada' 
																value="<?php if(isset($dplanillamovilidad)): ?><?php echo e(old('lugarllegada' ,$dplanillamovilidad->TXT_LUGARLLEGADA)); ?><?php else: ?><?php echo e(old('lugarllegada')); ?><?php endif; ?>" 
																placeholder="Lugar de Llegada"
																autocomplete="off" 
																class="form-control input-sm validarmayusculas"/>
										</div>
									</div>
								</div>




								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label class="col-sm-12 control-label labelleft negrita" >TOTAL : </label>
										<div class="col-sm-12">
												<input  type="text"
																id="total" 
																name='total'
																value="<?php if(isset($dplanillamovilidad)): ?><?php echo e(old('total' ,$dplanillamovilidad->TOTAL)); ?><?php else: ?><?php echo e(old('total')); ?><?php endif; ?>" 
																placeholder="Total"
																autocomplete="off" 
																class="form-control input-sm importe"/>
										</div>
									</div>
								</div>	

								<?php if(isset($dplanillamovilidad)): ?>

											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group">
												  <label class="col-sm-12 control-label labelleft negrita" >ACTIVO <span class="obligatorio">(*)</span> :</label>
												  <div class="col-sm-12">
												      <?php echo Form::select( 'activo', $comboestado, $activo,
										                              [
										                                'class'       => 'select3 form-control control input-xs' ,
										                                'id'          => 'activo',        
										                                'required'    => ''
										                              ]); ?>

												  </div>
												</div>
											</div>
								<?php endif; ?>
						</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-detalle-planilla">Guardar</button>
					</div>
				</form>
          	</div>
	        <div id="partida" class="tab-pane cont">
						<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
										<table id="nsop" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
	                    <thead>
	                      <tr>
	                      	<th>DIRECCION</th>
	                      	<th></th>
	                      </tr>
	                    </thead>
	                    <tbody>
										     <?php $__currentLoopData = $ldirecciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
						                      <tr >
																		<td class="cell-detail">
														          <span style="display: block;"><b><?php echo e($item->location); ?></b></span>
														          <span style="display: block;"><?php echo e($item->department_name); ?> - <?php echo e($item->province_name); ?> - <?php echo e($item->district_name); ?></span>
														        </td>
						                        <td>
						                            <div class="icon iconoentregable">
						                              <span class="mdi mdi-select-all mdiselp" location='<?php echo e($item->location); ?>'
						                              	department_code='<?php echo e($item->department_code); ?>'
						                              	province_code='<?php echo e($item->province_code); ?>'
						                              	district_code='<?php echo e($item->district_code); ?>'
						                              	></span>
						                            </div>
						                        </td>
						                      </tr>
										    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                    </tbody>
	                  </table>
	            </div>
	        </div>
	        <div id="llegada" class="tab-pane cont">
	        	
						<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
										<table id="nsol" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
	                    <thead>
	                      <tr>
	                      	<th>DIRECCION</th>
	                      	<th></th>
	                      </tr>
	                    </thead>
	                    <tbody>
										     <?php $__currentLoopData = $ldirecciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
						                      <tr >
																		<td class="cell-detail">
														          <span style="display: block;"><b><?php echo e($item->location); ?></b></span>
														          <span style="display: block;"><?php echo e($item->department_name); ?> - <?php echo e($item->province_name); ?> - <?php echo e($item->district_name); ?></span>
														        </td>
						                        <td>
						                            <div class="icon iconoentregable">
						                              <span class="mdi mdi-select-all mdisell" location='<?php echo e($item->location); ?>'
						                              	department_code='<?php echo e($item->department_code); ?>'
						                              	province_code='<?php echo e($item->province_code); ?>'
						                              	district_code='<?php echo e($item->district_code); ?>'
						                              	></span>
						                            </div>
						                        </td>
						                      </tr>
										    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                    </tbody>
	                  </table>
	            </div>


	        </div>

        </div>
       </div>
	</div>
<?php if(isset($ajax)): ?>
	<script type="text/javascript">
		$(document).ready(function(){

		    $(".datetimepicker02").datetimepicker({
		    	autoclose: true,
		      	pickerPosition: "bottom-left",
		    	componentIcon: '.mdi.mdi-calendar',
		    	navIcons:{
		    		rightIcon: 'mdi mdi-chevron-right',
		    		leftIcon: 'mdi mdi-chevron-left'
		    	}
		    });
			$(".select3").select2({
		      width: '100%'
		    });
        	$('.form2').parsley();

			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});

	        $("#nsop").dataTable({
	            dom: 'Bfrtip',
	            buttons: [
	                'csv', 'excel', 'pdf'
	            ],
	            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
	            columnDefs:[{
	                targets: "_all",
	                sortable: false
	            }]
	        });

	        $("#nsol").dataTable({
	            dom: 'Bfrtip',
	            buttons: [
	                'csv', 'excel', 'pdf'
	            ],
	            "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
	            columnDefs:[{
	                targets: "_all",
	                sortable: false
	            }]
	        });

		});
	</script>
<?php endif; ?>





