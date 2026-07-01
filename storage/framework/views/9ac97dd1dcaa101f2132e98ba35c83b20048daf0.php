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
	      <th>Tipo de Documento</th>
	      <th>Número de Documento</th>
	      <th>Nombre del Beneficiario</th>
	      <th>Correo Electrónico</th>
	      <th>N° Celular</th>
	      <th>Tipo de doc. de pago</th>
	      <th>N° de doc. de pago</th>
	      <th>Fecha de Vencimiento del documento</th>
	      <th>Tipo de Abono</th>
	      <th>Tipo de Cuenta</th>
	      <th>Moneda de Cuenta</th>
	      <th>N° Cuenta</th>
	      <th>Moneda de Abono</th>
	      <th>Monto de Abono</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php  $monto_total =  0;  ?>
	    <?php $__currentLoopData = $listadocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->TXT_GLOSA_INTER); ?></td>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo e(substr($item->TXT_CATEGORIA_TIPO_DOC,0,1)); ?></td>
	        <td><?php echo e($item->NRO_SERIE); ?><?php echo e($item->NRO_DOC); ?></td>
	        <td><?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'Ymd')); ?></td>
	        <td>09</td>
	        <td><?php echo e($item->TIPO_CUENTA); ?></td>
	        <td><?php echo e($item->TIPO_MONEDA); ?></td>
	        <td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>
	        <td><?php echo e($item->TIPO_MONEDA_ABONO); ?></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
	        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO);  ?>

	      </tr>                    
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	    <?php $__currentLoopData = $listaotros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->TXT_GLOSA_INTER); ?></td>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
	        <td></td>
	        <td></td>
	        <td><?php echo e(substr($item->TXT_CATEGORIA_TIPO_DOC,0,1)); ?></td>
	        <td><?php echo e($item->NRO_SERIE); ?><?php echo e($item->NRO_DOC); ?></td>
	        <td><?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'Ymd')); ?></td>
	        <td>09</td>
	        <td><?php echo e($item->TIPO_CUENTA); ?></td>
	        <td><?php echo e($item->TIPO_MONEDA); ?></td>
	        <td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>
	        <td><?php echo e($item->TIPO_MONEDA_ABONO); ?></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
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
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td><b><?php echo e(number_format($monto_total, 4, '.', ',')); ?></b></td>

		      </tr>                    
		</tfoot>

	</table>
</html>