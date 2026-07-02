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
	      <th>DOI Tipo</th>
	      <th>DOI Número</th>
	      <th>Tipo Abono</th>
	      <th>N° Cuentas a Abonar</th>
	      <th>Nombre de Beneficiario</th>
	      <th>Importe Abonar</th>
	      <th>Tipo Recibo</th>
	      <th>N° Documento</th>
	      <th>Abono agrupado</th>
	      <th>Referencia</th>
	      <th>Indicador Aviso</th>
	      <th>Medio de aviso</th>
	      <th>Persona Contacto</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php  $monto_total =  0;  ?>
	    <?php $__currentLoopData = $listadocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->TXT_TIPO_REFERENCIA); ?></td>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td>P</td>
	        <td><div><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></div></td>
	        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
	        <td><?php echo e(substr($item->NRO_SERIE,0,1)); ?></td>
	        <td><?php echo e(substr($item->NRO_SERIE,1)); ?> - <?php echo e($item->NRO_DOC); ?></td>
	        <td>N</td>
	       	<td></td> 
	        <td>E</td>
	        <td></td>
	        <td><?php echo e($item->TXT_CONTACTO); ?></td>
	        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO);  ?>
	      </tr>                    
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	    <?php $__currentLoopData = $listaotros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->TXT_TIPO_REFERENCIA); ?></td>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td>P</td>
	        <td><div><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></div></td>
	        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
	        <td><?php echo e(substr($item->NRO_SERIE,0,1)); ?></td>
	        <td><?php echo e(substr($item->NRO_SERIE,1)); ?> - <?php echo e($item->NRO_DOC); ?></td>
	        <td>N</td>
	       	<td></td> 
	        <td>E</td>
	        <td></td>
	        <td><?php echo e($item->TXT_CONTACTO); ?></td>
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
		        <td></td>
		       	<td></td>
		      </tr>                    
		</tfoot>


	</table>
</html>