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
	<table class="tabladet">
	  <thead>
	    <tr>
	      <th>OPERACION</th>
	      <th>N° DE ORDEN DE COMPRA</th>
	      <th>EMPRESA</th>
	      <th>PROVEEDOR</th>
	      <th>N° COMPROBANTE</th>
	      <th>IMPORTE TOTAL</th>
	      <th>IMPORTE NETO</th>
	      <th>GENERO OC</th>
	      <th>FECHA DE APROBACION</th>
	      <th>APROBACION JEFATURA</th>
	      <th>FECHA DE APROBACION</th>

	      <th>CONTABILIDAD</th>
	      <th>FECHA DE APROBACION</th>     
	      <th>ADMINISTRACION</th>
	      <th>FECHA DE APROBACION</th>  
	    </tr>
	  </thead>
	  <tbody>
	    <?php $__currentLoopData = $listadocumentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	        <td><?php echo e($item->OPERACION); ?></td>
	        <td><?php echo e($item->ID_DOCUMENTO); ?></td>
	        <td><?php echo e($item->NOMBRE_CLIENTE); ?></td>
	        <td><?php echo e($item->RZ_PROVEEDOR); ?></td>
	        <td><?php echo e($item->SERIE); ?> - <?php echo e(str_pad($item->NUMERO, 10, '0', STR_PAD_LEFT)); ?></td>
	        <td><?php echo e($item->TOTAL_VENTA_ORIG); ?></td>      
	        <td><?php echo e($item->SUB_TOTAL_VENTA_ORIG); ?></td>
	        <td><?php echo e($item->nombre); ?></td>
	        <td><?php echo e($item->fecha_uc); ?></td>
	        <td><?php echo e($item->TXT_NOMBRES); ?></td>
	        <td><?php echo e($item->fecha_uc); ?></td>

	        <td><?php echo e($item->nombreconta); ?></td>
	        <td><?php echo e($item->fecha_pr); ?></td>
	        <td><?php echo e($item->nombreadmin); ?></td>      
	        <td><?php echo e($item->fecha_ap); ?></td>

	      </tr>                    
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  </tbody>
	</table>
</html>