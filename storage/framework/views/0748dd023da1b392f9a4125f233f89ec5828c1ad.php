<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<style type="text/css">
		.tabladet tr th{
			border: 1px solid;
		}	
		.tabladet tr td{
			border: 1px solid;
		}	
		.border{
			border: 1px solid;
		}
		.cplomo{
			background-color: #eeeeee;
		}
	</style>
	<?php echo $__env->make('entregadocumento.excel.ajax.cabecera', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<table class="tabladet">
	  <thead>
	    <tr>
	      <th>RUC PROVEEDOR</th>
	      <th>RAZON SOCIAL</th>
	      <th>FORMA DE PAGO</th>
	      <th>CUENTA</th>
	      <th>CCI</th>
	      <th>IMPORTE</th>
	      <th>PAGO UNICO</th>
	      <th>TIPO DOCUMENTO</th>
	      <th>NUMERO DOCUMENTO</th>
	      <th>FECHA EMISION</th>
	      <th>CORREO ELECTRONICO</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php  $monto_total =  0;  ?>

	    <?php $__currentLoopData = $listadocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
	        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
	        <td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>
	        <td></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
	        <td>NO</td>
	        <td><?php echo e($item->TXT_CATEGORIA_TIPO_DOC); ?></td>
	        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
	        <td><?php echo e(date_format(date_create($item->FEC_EMISION), 'd-m-Y')); ?></td>
	        <td></td>
	        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO);  ?>

	        
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
		        <td><b><?php echo e(number_format($monto_total, 4, '.', ',')); ?></b></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		      </tr>                    
		</tfoot>

	</table>
</html>