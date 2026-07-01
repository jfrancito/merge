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
	      	<th class="border cplomo">DATOS GENERALES</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Código de Cliente</th>
	      	<th class="border cplomo">Tipo de Planilla</th>
	  	</tr>
	  	<tr>
	      	<th>000000</th>
	      	<th>PROV</th>
	  	</tr>
	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">DATOS DEL CARGO</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Tipo de Registro</th>
	      	<th class="border cplomo">Cantidad de abonos de la planilla</th>
	      	<th class="border cplomo">Fecha de proceso</th>
	      	<th class="border cplomo">Tipo de Cuenta de cargo</th>
	      	<th class="border cplomo">Cuenta de cargo</th>
	      	<th class="border cplomo">Monto total de la planilla</th>
	      	<th class="border cplomo">Referencia de la planilla</th>
	  	</tr>
	  	<tr>
	      	<th>C</th>
	      	<th><?php echo e($countfedocu); ?></th>
	      	<th><?php echo e(date_format(date_create($folio->FEC_PAGO), 'Ymd')); ?></th>
	      	<th>C</th>
	      	<th></th>
	     	<th><b><?php echo e(number_format($listadocumento->sum('TOTAL_PAGAR'), 4, '.', ',')); ?></b></th>
	     	<th></th>
	  	</tr>
	  	<tr>
	      	<th></th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">"DATOS DEL ABONO A CUENTA</th>
	  	</tr>
	  	<tr>
	      	<th class="border cplomo">Tipo de Registro</th>
	      	<th class="border cplomo">Tipo de Moneda de Abono</th>
	      	<th class="border cplomo">Monto del Abono</th>
	      	<th class="border cplomo">Tipo de Documento de Identidad</th>
	      	<th class="border cplomo">Número de Documento de Identidad</th>
	      	<th class="border cplomo">Validación IDC del proveedor vs Cuenta</th>
	      	<th class="border cplomo">Nombre del proveedor</th>
	      	<th class="border cplomo">Cantidad  Documentos relacionados al abono con Cheque de Gerencia</th>
	      	<th class="border cplomo">Tipo de Documento a pagar</th>
	      	<th class="border cplomo">Nro. del Documento</th>
	      	<th class="border cplomo">Moneda Documento</th>
	      	<th class="border cplomo">Monto del Documento</th>

	  	</tr>
	  </thead>
	  <tbody class="tabladet">
	    <?php $__currentLoopData = $listadocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <tr>
	      	<td>A</td>
	        <td><b><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></b></td>
	        <td>S</td>
	        <td><b><?php echo e(number_format($item->TOTAL_PAGAR, 4, '.', ',')); ?></b></td>
	        <td><?php echo e($item->CODIGO_SUNAT); ?></td>
	        <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
	        <td>S</td>
	        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>


		    <td>0000</td>	        
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        
	      </tr>                    
	    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  </tbody>
	</table>



</html>