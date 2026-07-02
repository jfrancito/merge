<div class="modal-header" style="background: #1d3a6d;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	  <div class="row">
			<div class="col-xs-12">
				HITORIAL ORDEN EXTORNADA <?php echo e($data_cod_extorno); ?>

			</div>
		</div>
	</div>
	<div class="modal-body" style="padding-top: 0px;">
		<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
	    <div class="panel panel-default panel-contrast" style="margin-top:15px;">
	      <div class="panel-body panel-body-contrast">

	        <div class='long-text' id="longText">
	          <table class="table table-condensed table-striped">
	            <thead>
	              <tr>
	                <th>SEGUIMIENTO</th>
	              </tr>
	            </thead>
	            <tbody>
	              <?php $__currentLoopData = $documentohistorial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
	                <tr>
	                  <td>
	                    <span class="cell-detail-description"><b>FECHA : </b> <?php echo e(date_format(date_create($item->FECHA), 'd-m-Y H:i:s')); ?></span><br>
	                    <span class="cell-detail-description"><b>USUARIO : </b> <?php echo e($item->USUARIO_NOMBRE); ?></span><br>
	                    <span class="cell-detail-description"><b>TIPO : </b> <?php echo e($item->TIPO); ?></span><br>
	                    <span class="cell-detail-description"><b>MENSAJE : </b> <?php echo e($item->MENSAJE); ?></span>
	                  </td>
	                </tr>
	              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	          </table>
	        </div>
	      <p style="margin-top: 20px;">
	        <a id="toggleButton" onclick="toggleContent()" class="read-more" style="cursor: pointer; font-size: 1.2em;">+ Ver Más</a>
	      </p>
	      </div>
	    </div>

		</div>
	</div>
	<div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button>
	</div>





