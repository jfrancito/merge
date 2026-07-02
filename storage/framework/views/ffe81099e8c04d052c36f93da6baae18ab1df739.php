	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				LOTES DE <?php echo e($operacion_id); ?>

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
                      	<th>LOTE</th>
                      	<th>FECHA CREACION</th>
                      	<th>SEL</th>
                      	<th>X</th>
                      </tr>
                    </thead>
                    <tbody>
				              <?php $__currentLoopData = $feasoc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                      <tr >
                        <td><?php echo e($item->LOTE); ?></td>
                        <td><?php echo e($item->FECHA_CREA); ?></td>
                        <td class=""><div class="icon"><span data_lote = '<?php echo e($item->LOTE); ?>' class="mdi mdi-eye verlote" style="font-size: 22px;color: #1d3a6d; cursor: pointer;"></span></div></td>
                        <td class=""><div class="icon"><span data_lote = '<?php echo e($item->LOTE); ?>' class="mdi mdi-close-circle eliminarlote" style="font-size: 22px;color: #cc0000;cursor: pointer;"></span></div></td>
                      </tr>
				              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>

	            </div>
				    </div>
		</div>
	</div>

	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
	</div>






