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
	<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7" >
		  <thead>
		    <tr>
		      <th>ITEM</th>
		      <th>OPERACION</th>

		      <th>RUC</th>
		      <th>PROVEEDOR</th>
		      <th>BANCO</th>
		      <th>CUENTA ABONO</th>

		      <th>FECHA VENCIMIENTO DOC</th>
		      <th>FECHA APROBACION ADMIN</th>
		      <th>TIPO</th>
		      <th>SUBIO VOUCHER</th>
		      <th>ORDEN INGRESO</th>
		      <th>IMPORTE</th>
		      <th>OBLIGACION</th>
		      <th>DESCUENTO</th>
		      <th>TOTAL DESCUENTO</th>
		      <th>PERCEPCION</th>
		      <th>ANTICIPO</th>
		      <th>NOTA CREDITO</th>
		      <th>COMPENSACION</th>
		      <th>NETO A PAGAR</th>
		      <th>CUENTA OSIRIS</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php  $monto_total =  0;  ?>
		    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		    	<?php  $NOMBRE_OSIRIS =  $funcion->funciones->cuenta_osiris_lic($item->ID_DOCUMENTO)  ?>
		      <tr>
		        <td><?php echo e($index + 1); ?></td>
		        <td><?php echo e($item->OPERACION); ?></td>
		        <td><?php echo e($item->RUC_PROVEEDOR); ?></td>
		        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>
		        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
		        <td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>

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
		        <td><b><?php echo e(number_format($item->CAN_TOTAL, 2, '.', ',')); ?></b></td>
		        <td>
		          <?php if($item->MONTO_DETRACCION_RED>0): ?>
		            DETRACION
		          <?php else: ?>
		            <?php if($item->MONTO_RETENCION>0): ?>
		              RETENCION IGV  
		            <?php else: ?>
			            <?php if($item->CAN_IMPUESTO_RENTA>0): ?>
			              RETENCION 4TA         
			            <?php endif; ?>
		            <?php endif; ?>
		          <?php endif; ?>
		        </td>
		        <td><b><?php echo e(number_format($item->CAN_DSCTO, 4, '.', ',')); ?></b></td>
		        <td><b>
		          <?php if($item->MONTO_DETRACCION_RED>0): ?>
		            <?php echo e(number_format(round($item->MONTO_DETRACCION_RED, 4),4, '.', ',')); ?>

		          <?php else: ?>
		            <?php if($item->MONTO_RETENCION>0): ?>
		              <?php echo e(number_format(round($item->MONTO_RETENCION, 4),4, '.', ',')); ?>

		            <?php else: ?>
			            <?php if($item->CAN_IMPUESTO_RENTA>0): ?>
			              <?php echo e(number_format(round($item->CAN_IMPUESTO_RENTA, 4),4, '.', ',')); ?>

			            <?php else: ?>
			              0.00                
			            <?php endif; ?>             
		            <?php endif; ?>
		          <?php endif; ?>
		          </b>
		        </td>
		        <td><b><?php echo e(number_format(round($item->PERCEPCION, 4), 4, '.', ',')); ?></b></td>
		        <td><b><?php echo e(number_format(round($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',')); ?></b></td>
		        <td><b><?php echo e(number_format(round($item->MONTO_NC, 4), 4, '.', ',')); ?></b></td>
		        <td><b><?php echo e(number_format(round($item->COMPENSACION, 4), 4, '.', ',')); ?></b></td>
		        <td><b>
		        	<?php echo e($simbolo); ?> <?php echo e(number_format($funcion->funciones->neto_pagar_documento_consolidado($item), 2, '.', ',')); ?>

			        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento_consolidado($item);  ?>
			        </b>
		        </td>
		        <td><?php echo e($NOMBRE_OSIRIS); ?></td>
		      </tr>                    
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		    <?php $__currentLoopData = $listadatosotro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		      	<?php  $MONTO_DETRACCION =  0  ?>
		      	<?php  $NOMBRE_OSIRIS =  $funcion->funciones->cuenta_osiris_lic($item->ID_DOCUMENTO)  ?>
			    <tr>
			        <td><?php echo e(count($listadatos) + $index + 1); ?></td>
			        <td><?php echo e($item->OPERACION); ?></td>
			        <td><?php echo e($item->RUC_PROVEEDOR); ?><</td>
			        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
			        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
		        	<td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>
			        <td><?php echo e(date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')); ?></td>
			        <td><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></td>
			        <td><?php echo e($item->IND_MATERIAL_SERVICIO); ?></td>
			        <td>
			            <?php if($item->COD_ESTADO == 'ETM0000000000008'): ?>
			              SI
			            <?php else: ?>
			              NO
			            <?php endif; ?>
			        </td>
			        <td></td>
			        <td><b><?php echo e(number_format(round($item->TOTAL_VENTA_ORIG+$item->CAN_CENTIMO, 4), 4, '.', ',')); ?></b></td>
			        <td><?php if($MONTO_DETRACCION > 0): ?> DETRACCION <?php endif; ?></td>
			        <td>-</td>
			        <td><b><?php echo e(number_format(round($MONTO_DETRACCION, 4), 4, '.', ',')); ?></b></td>
			        <td><b><?php echo e(number_format(round($item->PERCEPCION, 4), 4, '.', ',')); ?></b></td>
			        <td><b><?php echo e(number_format(round($item->MONTO_ANTICIPO_DESC + $item->MONTO_ANTICIPO_DESC_OTROS, 4), 4, '.', ',')); ?></b></td>
			        <td><b>0.00</b></td>
			        <td><b>0.00</b></td>

			        <td><b><?php echo e($simbolo); ?> <?php echo e(number_format($funcion->funciones->neto_pagar_documento_consolidado($item), 2, '.', ',')); ?></b></td>
			        <td><?php echo e($NOMBRE_OSIRIS); ?></td>
			        <?php  $monto_total  = $monto_total + $funcion->funciones->neto_pagar_documento_consolidado($item);  ?>
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
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>

		        <td><b><?php echo e($simbolo); ?> <?php echo e(number_format($monto_total, 2, '.', ',')); ?></b></td>
		        <td></td>
		      </tr>                    
		  </tfoot>
		</table>

</html>