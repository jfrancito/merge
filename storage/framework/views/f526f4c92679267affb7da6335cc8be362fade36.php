
<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		 LISTA DOCUMENTOS DE <?php echo e($data_cliente); ?>

	</h3>
</div>
<div class="modal-body">
	<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

  	<table id="tableRR" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
          <tr>
            <th>RESULTADO</th>
            <th>ANEXO</th>
            <th>CENTRO</th>
            <th>MES</th>
            <th>FECHA</th>
            <th>CODIGO</th>
            <th>TIPO_VENTA</th>
            <th>CLIENTE</th>
            <th>IMPORTE</th>
            <th>CONCEPTO_CENTRO_COSTO</th>
          </tr>
        </thead>
        <tbody>
          	<?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->RESULTADO); ?></td>
                    <td><?php echo e($item->ANEXO); ?></td>
                    <td><?php echo e($item->CENTRO); ?></td>
                    <td><?php echo e($item->MES); ?></td>
                    <td><?php echo e($item->FECHA); ?></td>
                    <td><?php echo e($item->CODIGO); ?></td>
                    <td><?php echo e($item->TIPO_VENTA); ?></td>
                    <td><?php echo e($item->CLIENTE); ?></td>
                    <td><?php echo e($item->IMPORTE); ?></td>
                    <td><?php echo e($item->CONCEPTO_CENTRO_COSTO); ?></td>
                </tr>                    
          	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
  	</table>



  	<table id="tableRRD" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
          <tr>
            <th>RESULTADO OTROS</th>
            <th>ANEXO OTROS</th>
            <th>CENTRO OTROS</th>
            <th>MES OTROS</th>
            <th>CODIGO OTROS</th>
            <th>TIPO_VENTA OTROS</th>
            <th>CLIENTE OTROS</th>
            <th>IMPORTE OTROS</th>
            <th>CONCEPTO_CENTRO_COSTO_OTROS</th>

            <th>RESULTADO</th>
            <th>ANEXO</th>
            <th>CENTRO</th>
            <th>MES</th>
            <th>CODIGO</th>
            <th>TIPO_VENTA</th>
            <th>CLIENTE</th>
            <th>IMPORTE</th>
            <th>CONCEPTO_CENTRO_COSTO</th>

          </tr>
        </thead>
        <tbody>
          	<?php $__currentLoopData = $resultado02; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->RESULTADO_O); ?></td>
                    <td><?php echo e($item->ANEXO_O); ?></td>
                    <td><?php echo e($item->CENTRO_O); ?></td>
                    <td><?php echo e($item->MES_O); ?></td>
                    <td><?php echo e($item->CODIGO_O); ?></td>
                    <td><?php echo e($item->TIPO_VENTA_O); ?></td>
                    <td><?php echo e($item->CLIENTE_O); ?></td>
                    <td><?php echo e($item->IMPORTE_O); ?></td>
                    <td><?php echo e($item->CONCEPTO_CENTRO_COSTO_O); ?></td>


                    <td><?php echo e($item->RESULTADO); ?></td>
                    <td><?php echo e($item->ANEXO); ?></td>
                    <td><?php echo e($item->CENTRO); ?></td>
                    <td><?php echo e($item->MES); ?></td>
                    <td><?php echo e($item->CODIGO); ?></td>
                    <td><?php echo e($item->TIPO_VENTA); ?></td>
                    <td><?php echo e($item->CLIENTE); ?></td>
                    <td><?php echo e($item->IMPORTE); ?></td>
                    <td><?php echo e($item->CONCEPTO_CENTRO_COSTO); ?></td>
                </tr>                    
          	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
  	</table>




	</div>

</div>

<div class="modal-footer">
  <button type="submit" data-dismiss="modal" class="btn btn-success btn-asigna-asiento-pc">Asignar</button>
</div>
<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $("#tableRR").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 0, "asc" ]]
    });
    $("#tableRRD").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 0, "asc" ]]
    });

  </script> 
<?php endif; ?>



