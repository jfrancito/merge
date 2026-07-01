<form method="POST" id='formpedido' action="<?php echo e(url('/pago-comprobante-tesoreria-pagado-contrato/'.$idopcion.'/'.$linea.'/'.$fedocumento->ID_DOCUMENTO)); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
<?php echo e(csrf_field()); ?>


	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>

	  <div class="row">
			<div class="col-xs-6">
				ORDEN COMPRA : <?php echo e($fedocumento->ID_DOCUMENTO); ?>

			</div>
			<div class="col-xs-5">
				FECHA : <?php echo e(date_format(date_create($fedocumento->FEC_VENTA), 'd-m-Y')); ?>

			</div>	
		</div>

	  <div class="row">
			<div class="col-xs-6">
				PROVEEDOR : <?php echo e($fedocumento->RZ_PROVEEDOR); ?>

			</div>
			<div class="col-xs-6">
				DOCUMENTO : <?php echo e($fedocumento->SERIE); ?> - <?php echo e($fedocumento->NUMERO); ?>

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
	                                  >
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
            var nombre_archivo = '<?php echo e($archivo->NOMBRE_ARCHIVO); ?>';
         		$('#file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>').fileinput({
              theme: 'fa5',
              language: 'es',
              initialPreview: ["<?php echo e(route('serve-filepago', ['file' => ''])); ?>" + nombre_archivo],
              initialPreviewAsData: true,
              initialPreviewFileType: 'pdf',
              initialPreviewConfig: [
                  {type: "pdf", caption: nombre_archivo, downloadUrl: "<?php echo e(route('serve-filepago', ['file' => ''])); ?>" + nombre_archivo} // Para mostrar el botón de descarga
              ]
            });

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      
  </script>
<?php endif; ?>




