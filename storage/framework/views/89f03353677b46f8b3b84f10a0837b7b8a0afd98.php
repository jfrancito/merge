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

	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
	  <thead>
	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">N° CARGO:</th>
	      	<th class="border cplomo"><?php echo e($folio->FOLIO); ?></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th class="border cplomo">FECHA EMISIÓN:</th>
	      	<th class="border cplomo"><?php echo e(date_format(date_create($folio->FEC_PAGO), 'd-m-Y')); ?></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">RAZON SOCIAL:</th>
	      	<th class="border cplomo"><?php echo e($empresa->NOM_EMPR); ?></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">RUC:</th>
	      	<th class="border cplomo"><?php echo e($empresa->NRO_DOCUMENTO); ?></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th></th>
	  	</tr>

	  	<tr>
	      	<th class="border cplomo">PROVEEDOR:</th>
	      	<th class="border cplomo"><?php echo e($proveedor->TXT_EMPR_EMISOR); ?></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>
	  	<tr>

	      	<th class="border cplomo">BANCO:</th>
	      	<th class="border cplomo"><?php echo e($fedocumento->TXT_CATEGORIA_BANCO); ?></th>
	      	<th class="border cplomo">CUENTA:</th>
	      	<th class="border cplomo"><b><?php echo e($fedocumento->TXT_NRO_CUENTA_BANCARIA); ?></b></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>

	  	<tr>
	      	<th class="border cplomo">CUENTA DE DETRACCION:</th>
	      	<th class="border cplomo"><b><?php echo e($empresa_item->TXT_DETRACCION); ?></b></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	      	<th></th>
	  	</tr>


	  	<tr>
	      	<th>POR SERVICIO DE TRANSPORTE DE CARGA, UNIDAD DE MEDIDA: SACOS, SEGÚN: GR-R N°</th>
	  	</tr>

	  </thead>
	</table>


	<table class="tabladet">
	  <thead>
	    <tr>
	      <th>CANTIDAD DE SACOS</th>
	      <th>PRECIO POR SACO PROMEDIO</th>
	      <th>FECHA EMISIÓN</th>
	      <th>N° FACTURA</th>
	      <th>IMPORTE (S/)</th>
	      <th>DETRACCIÓN (S/)</th>
	      <th>DETRACCIÓN (S/)</th>
	      <th>OTROS DESCUENTOS (S/)</th>
	      <th>ANTICIPO</th>
	      <th>IMPORTE A CANCELAR (S/)</th>
	    </tr>
	  </thead>
	  <tbody>
		<?php  $monto_total  = 0;  ?>
	    <?php $__currentLoopData = $listadocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e(number_format($item->TOTAL_CAN_SACOS, 2, '.', '')); ?></td>
	        <td><?php echo e(number_format($item->TOTAL_VENTA_ORIG/$item->TOTAL_CAN_SACOS, 2, '.', '')); ?></td>
	        <td><?php echo e(date_format(date_create($item->FEC_EMISION), 'd-m-Y')); ?></td>
	        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
	        <td><?php echo e($item->TOTAL_VENTA_ORIG+$item->CAN_CENTIMO); ?></td>
	        <td><?php echo e($item->MONTO_DETRACCION_XML); ?></td>
	        <td><?php echo e($item->MONTO_DETRACCION_RED); ?></td>
			<td>0.00</td>
	        <td><?php echo e($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS); ?></td>
	        <td><b><?php echo e(number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')); ?></b></td>
	        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO);  ?>
	      </tr>                    
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  </tbody>
	  <tfoot>
	      <tr>
	        <th>TOTAL</th>
	        <th></th>
	        <th></th>
	        <th></th>
	        <th><?php echo e(number_format($listadocumento->SUM('TOTAL_VENTA_ORIG'), 2, '.', '')); ?></th>
	        <th><?php echo e(number_format($listadocumento->SUM('MONTO_DETRACCION_XML'), 2, '.', '')); ?></th>
	        <th><?php echo e(number_format($listadocumento->SUM('MONTO_DETRACCION_RED'), 2, '.', '')); ?></th>
	        <th>0.00</th>
	        <th>0.00</th>
		    <th><b><?php echo e(number_format($monto_total, 4, '.', ',')); ?></b></th>
	      </tr>                    
	  </tfoot>
	</table>
</html>