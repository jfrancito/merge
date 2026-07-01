    <div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#acumulado" data-toggle="tab">ACUMULADO</a></li> 
        </ul>

        <div class="tab-content">
          	<div id="registro" class="tab-pane active cont">

								<div class="modal-header">
									<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
									<h3 class="modal-title">
										<span><?php echo e(date_format(date_create($fecha_inicio), 'd/m/Y')); ?> - <?php echo e(date_format(date_create($fecha_fin), 'd/m/Y')); ?></span>
									</h3>
								</div>
								<div class="modal-body">
									<div  class="row regla-modal">
										<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
														<table id="nsop" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
					                    <thead>
					                      <tr>
					                      	<th>ITEM</th>
					                      	<th>FECHA</th>
					                      	<th>TOTAL</th>
					                      </tr>
					                    </thead>
					                    <tbody>
														     <?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								                      <tr >
								                      	<td><?php echo e($index + 1); ?></td>
								                        <td><?php echo e(date_format(date_create($item->FECHA_GASTO), 'd/m/Y')); ?></td>
								                        <td><?php echo e($item->TOTAL); ?></td>
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





