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
	<?php echo $__env->make('entregadetraccion.excel.ajax.cabecera', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7" >
		  <thead>
		    <tr>
		      <th>ITEM</th>
		      <th>OPERACION</th>
		      <th>DOCUMENTO</th>
		      <th>FECHA</th>

		      <th>RUC</th>
		      <th>PROVEEDOR</th>
		      <th>BANCO</th>
		      <th>CUENTA ABONO</th>
		      <th>COMPROBANTE ASOCIADO</th>
		      <th>NETO A PAGAR</th>
		      <th>MONEDA</th>

		    </tr>
		  </thead>
		  <tbody>
		  	<?php  $monto_total =  0;  ?>
		    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			  <?php  $monto_total  = $monto_total + $item->MONTO_CONVERTIDO;  ?>

		      <tr>
		        <td><?php echo e($index + 1); ?></td>
		        <td><?php echo e($item->OPERACION); ?></td>
		        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
		        <td><?php echo e($item->FEC_VENTA); ?></td>
		        
		        <td><?php echo e($item->RUC_PROVEEDOR); ?></td>
		        <td><?php echo e($item->RZ_PROVEEDOR); ?></td>
		        <td>BANCO DE LA NACION</td>
		        <td><b><?php echo e($item->CTA_DETRACCION); ?></b></td>
		        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
		        <td><b><?php echo e(number_format($item->MONTO_CONVERTIDO, 2, '.', ',')); ?></b></td>
		        <td><?php echo e($item->MONEDA); ?></td>
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
		        <td><b><?php echo e($simbolo); ?> <?php echo e(number_format($monto_total, 2, '.', ',')); ?></b></td>
		      </tr>                    
		  </tfoot>
		</table>

</html>