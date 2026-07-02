
<div class="modal-header" style="padding: 12px 20px;">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<div class="col-xs-12">
		<h5 class="modal-title" style="font-size: 1.2em;">
			Deuda <?php echo e($empresa->NOM_EMPR); ?>

		</h5>
	</div>
</div>
<div class="modal-body">
	<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
<table id="nso_f" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>

    <tr>
      <th>NOM_CLIENTE</th>
      <th>NRO_CONTRATO</th>
      <th>TIPO_CONTRATO</th>
      <th>CENTRO</th>
      <th>TIPO DOCUMENTO</th>
      <th>NRO DOCUMENTO</th>
      <th>JEFE_VENTA</th>
      <th>SALDO</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="<?php if($item->TIPO_CONTRATO<> 'PROVEEDOR'): ?> colordeuda <?php endif; ?>">
        <td><?php echo e($item->NOM_CLIENTE); ?></td>
        <td><?php echo e($item->NRO_CONTRATO); ?></td>
        <td><?php echo e($item->TIPO_CONTRATO); ?></td>
        <td><?php echo e($item->Centro); ?></td>
        <td><?php echo e($item->TipoDocumento); ?></td>
        <td><?php echo e($item->NroDocumento); ?></td>
        <td><?php echo e($item->JEFE_VENTA); ?></td>
        <td><b><?php echo e($item->SALDO); ?></b></td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>

  <tfoot>
  	
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b><?php echo e($listadatos->sum('SALDO')); ?></b></td>
      </tr>  

  </tfoot>
</table>




	</div>
</div>
<div class="modal-footer">

	<button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button>
</div>




<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){


      $("#nso_f").dataTable({
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