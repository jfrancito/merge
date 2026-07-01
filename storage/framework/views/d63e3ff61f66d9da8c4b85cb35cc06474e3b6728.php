<form method="POST" id='formpedido' action="<?php echo e(url('/guardar-comprobante-consolidado/'.$idopcion.'/'.$feplanillaentrega->ID_DOCUMENTO)); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
<?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>

	  <div class="row">
			<div class="col-xs-6">
				ID : <?php echo e($feplanillaentrega->ID_DOCUMENTO); ?>

			</div>
			<div class="col-xs-5">
				FECHA EMISION : <?php echo e(date_format(date_create($feplanillaentrega->FEC_EMISION), 'd-m-Y')); ?>

			</div>	
		</div>

	  <div class="row">
			<div class="col-xs-6">
				PERIODO : <?php echo e($feplanillaentrega->TXT_PERIODO); ?>

			</div>
			<div class="col-xs-6">
				DOCUMENTO : <?php echo e($feplanillaentrega->SERIE); ?> - <?php echo e($feplanillaentrega->NUMERO); ?>

			</div>	
		</div>

	</div>
	<div class="modal-body" style="padding-top: 0px;">
		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
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




