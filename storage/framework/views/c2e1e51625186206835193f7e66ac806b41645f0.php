
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


	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
	  <thead>
	    <tr>
	      <th>ITEM</th>
	      <th>NRO CONTRATO</th>
	      <th>DOCUMENTO</th>

	      <th>PROVEEDOR</th>
	      <th>BANCO</th>
	      <th>COMPROBANTE ASOCIADO</th>
	      <th>FECHA VENCIMIENTO DOC</th>
	      <th>FECHA APROBACION ADMIN</th>
	      <th>TIPO</th>
	      <th>SUBIO VOUCHER</th>
	      <th>ORDEN INGRESO</th>
	      <th>PAGO DETRACCION</th>

	      <th>IMPORTE</th>
	      <th>DETRACCION</th>
	      <th>ANTICIPO</th>

	      <th>NETO A PAGAR</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php  $monto_total =  0;  ?>
	    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php  $MONTO_DETRACCION =  $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)  ?>
		    <tr>
		        <td><?php echo e($index + 1); ?></td>
		        <td><?php echo e($item->COD_DOCUMENTO_CTBLE); ?></td>
		        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?><</td>
		        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
		        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
		        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
		        <td><?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?></td>
		        <td><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></td>
		        <td><?php echo e($item->IND_MATERIAL_SERVICIO); ?></td>
		        <td>
		            <?php if($item->COD_ESTADO_VOUCHER == 'ETM0000000000008'): ?>
		              SI
		            <?php else: ?>
		              NO
		            <?php endif; ?>
		        </td>
		        <td><?php echo e($item->COD_TABLA_ASOC); ?></td>
		        <td><?php echo e($item->TXT_PAGO_DETRACCION); ?></td>
				<td><b><?php echo e(number_format(round($item->TOTAL_VENTA_ORIG, 4), 4, '.', ',')); ?></b></td>
				<td><b><?php echo e(number_format(round($MONTO_DETRACCION, 4), 4, '.', ',')); ?></b></td>
				<td><b><?php echo e(number_format(round($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',')); ?></b></td>
				<td><b><?php echo e($simbolo); ?> <?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 2, '.', ',')); ?></b></td>
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
	        <td></td>
	       	<td></td>
		    <td><b><?php echo e($simbolo); ?> <?php echo e(number_format($monto_total, 2, '.', ',')); ?></b></td>
	      </tr>                    
	  </tfoot>
	</table>


</html>