<!DOCTYPE html>
<html lang="es">
<head>
	<title>LIQUIDACION DE GASTOS (<?php echo e($liquidaciongastos->ID_DOCUMENTO); ?>) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="<?php echo e(asset('public/favicon.ico')); ?>"> 
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/pdf.css')); ?> "/>

</head>
<body>
    <header>
	<div class="center">
		<h3>LIQUIDACION DE GASTOS DE VIAJE</h3>
	</div>
    </header>
    <section>
        <article>
			<div class="top">
			    <div class="det1">
	   				<p>
	   					<strong>CODIGO:</strong> <?php echo e($codigoosiris); ?>

	   				</p> 
	   				<p>
	   					<strong>NOMBRE:</strong> <?php echo e($liquidaciongastos->TXT_EMPRESA_TRABAJADOR); ?>

	   				</p>  		    		   					   				
	   				<p>
	   					<strong>AREA :</strong> <?php echo e($liquidaciongastos->TXT_AREA); ?>   					
	   				</p>
	   				<p>
	   					<strong>LUGAR DE VIAJE :</strong> <?php echo e($lugarviaje); ?>   					
	   				</p>
	   				<p>
	   					<strong>MOTIVO DEL VIAJE :</strong> <?php echo e($motivoviaje); ?>   					
	   				</p>
	   				<p>
	   					<strong>FECHA DE VIAJE:</strong> <?php echo e($cadenaFechas); ?>   					
	   				</p>

			    </div>
			</div>
        </article>

        <article>
			<table class="tabla-pdf">
			    <thead>
			        <tr>
			            <th style="width: 25%;">DESCRIPCIÓN</th>
			            <th style="width: 25%;">DETALLE</th>
			            <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <th style="width: <?php echo e(40 / count($tipos_documento)); ?>%;"><?php echo e($tipo); ?></th>
			            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			            <th style="width: 10%;">TOTAL</th>
			        </tr>
			    </thead>
			    <tbody>

                    <?php 
                      $total    =   0;
                     ?>

			        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $descripcion => $productos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto => $valores): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <tr>
			                    <td class="grupo"><?php echo e(strtoupper($descripcion)); ?></td>
			                    <td><?php echo e(strtoupper($producto)); ?></td>
			                    
			                    <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                        <td style="text-align: center;"><?php echo e($valores[$tipo] ?: ''); ?></td>
			                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                    
			                    <td style="text-align: right;"><?php echo e(number_format($valores['TOTAL'], 2)); ?></td>
			                </tr>

		                    <?php 
		                      $total    =   $total + $valores['TOTAL'];
		                     ?>

			            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				    <tr>			    	
				      	<td>TOTAL DE GASTOS</td>
				      	<td class='titulo'></td>
			            <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <td class='titulo'></td>
			            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				      	<td class='izquierda'><b><?php echo e(number_format(round(  $total ,2),2,'.',',')); ?></b></td>
				    </tr>

				    <tr>			    	
				      	<td>N° DE VALE</td>
				      	<td class='titulo'></td>
			            <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <td class='titulo'></td>
			            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				      	<td class='izquierda'><b><?php if(isset($arendir->CAN_TOTAL_IMPORTE)): ?>
												    <?php echo e(number_format(round($arendir->CAN_TOTAL_IMPORTE, 2), 2, '.', ',')); ?>

												<?php else: ?>
												    
												    0.00
												<?php endif; ?></b></td>
				    </tr>

				    <tr>			    	
				      	<td>TOTAL</td>
				      	<td class='titulo'></td>
			            <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <td class='titulo'></td>
			            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				      	<td class='izquierda'><b><?php if(isset($arendir->CAN_TOTAL_IMPORTE)): ?>
												    <?php echo e(number_format(round($total - $arendir->CAN_TOTAL_IMPORTE, 2), 2, '.', ',')); ?>

												<?php else: ?>
												    <?php echo e($total); ?>

												<?php endif; ?></b></td>
				    </tr>
			    </tbody>
			</table>

        </article>

		<table style="width: 100%; text-align: center; margin-top: 50px; border-collapse: collapse; border: none;">
		    <tr>
		        <td style="width: 50%; text-align: center; border: none;">
		            <img src="<?php echo e(public_path($imgresponsable)); ?>" style="width: 150px;" alt="Firma 1">
		            <p style="margin-top: 10px;">RESPONSABLE</p>
		            <p style="margin-top: 10px;"><?php echo e($nombre_responsable); ?></p>
		        </td>
		    </tr>
		</table>
    </section>  
</body>
</footer>

</html>