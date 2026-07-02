	<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				DOCUMENTO <?php echo e($data_doc); ?>

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
				              <?php $__currentLoopData = $detalledocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                      <tr >
                        <td><?php echo e($item->COD_PRODUCTO); ?></td>
                        <td><?php echo e($item->TXT_NOMBRE_PRODUCTO); ?></td>
                        <td><?php echo e($item->CAN_PRODUCTO); ?></td>
                      </tr>
				              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>

	            </div>
				    </div>
		</div>
	</div>





