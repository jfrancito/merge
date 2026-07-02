<form method="POST" id='formpedido' action="<?php echo e(url('/pago-comprobante-tesoreria/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
<?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>

	  <div class="row">
			<div class="col-xs-6">
				ORDEN COMPRA : <?php echo e($ordencompra->COD_ORDEN); ?>

			</div>
			<div class="col-xs-5">
				FECHA : <?php echo e(date_format(date_create($ordencompra->FEC_EMISION), 'd-m-Y')); ?>

			</div>	
		</div>

	  <div class="row">
			<div class="col-xs-6">
				PROVEEDOR : <?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?>

			</div>
			<div class="col-xs-6">
				DOCUMENTO : <?php echo e($fedocumento->SERIE); ?> - <?php echo e($fedocumento->NUMERO); ?>

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
	              <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
	                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                      <div class="form-group sectioncargarimagen">
	                          <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b> 
	                          </label>
	                          <div class="col-sm-12">
	                              <div class="file-loading">
	                                  <input 
	                                  id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
	                                  name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
	                                  class="file-es"  
	                                  type="file" 
	                                  multiple data-max-file-count="1"
	                                  required>
	                              </div>
	                          </div>
	                      </div>
	                    </div>
	              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
						              <?php $__currentLoopData = $archivospp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
						                <tr>
						                  <td><?php echo e($index + 1); ?></td>
						                  <td><?php echo e($item->DESCRIPCION_ARCHIVO); ?></td>
						                  <td><?php echo e($item->NOMBRE_ARCHIVO); ?></td>

						                  <td class="rigth">
						                    <div class="btn-group btn-hspace">
						                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
						                      <ul role="menu" class="dropdown-menu pull-right">
						                          <li>
						                            <a class="elimnaritem" data_tipoarchivo="<?php echo e($item->TIPO_ARCHIVO); ?>" 
						                            											 data_nombrearchivo="<?php echo e($item->NOMBRE_ARCHIVO); ?>"
						                            											 data_linea="<?php echo e($linea); ?>"
						                            											 data_iddocumento="<?php echo e($cod_orden); ?>"
						                            											 href="#">
						                              Eliminar Item
						                            </a>
						                          </li>
						                      </ul>
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
	</div>
	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
	</div>
</form>
<?php if(isset($ajax)): ?>
  <script type="text/javascript">
      <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
         $('#file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>').fileinput({
            theme: 'fa5',
            language: 'es',
            allowedFileExtensions: ['<?php echo e($item->TXT_FORMATO); ?>'],
          });
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </script>
<?php endif; ?>




