<!DOCTYPE html>
<html lang="es">
<head>
	<title>Planilla de Movilidad (<?php echo e($planillamovilidad->SERIE); ?>-<?php echo e($planillamovilidad->NUMERO); ?>) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="<?php echo e(asset('public/favicon.ico')); ?>"> 
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/pdf.css')); ?> "/>


</head>
<body>
    <header>
<!-- 	<div class="center">
		<h3><?php echo e($planillamovilidad->TXT_EMPRESA); ?></h3>
	</div> -->

	<div class="menu">
	    <div class="left">
				<img src="<?php echo e(public_path('img/logonitido.png')); ?>" style="width: 150px;" alt="Logo">   
	    </div>
	    <div class="cent">
	    		<?php echo e(Session::get('empresas')->NOM_CORTO); ?>

	    		<p style="font-size:8px;"><?php echo e($direccion->DIRECCION); ?></p>
	    </div>

	    <div class="cent2">
	    </div>

	    <div class="right">
	    		<h3>RUC N° <?php echo e($ruc); ?></h3> 
	    		<h4>PLANILLA DE MOVILIDAD.</h4>
	    		<h3>N° <?php echo e($planillamovilidad->SERIE); ?>-<?php echo e($planillamovilidad->NUMERO); ?></h3> 
	    </div>
	</div>
    </header>
    <section>
        <article>
			<div class="top">
			    <div class="det1">

					<table class="tcab">
					    <tr>
					      <td class="primertab"><b>PERIODO</b></td>
					      <td><b> : </b><?php echo e(ucwords(strtolower(preg_replace('/^\(\d+\)\s*/', '', $planillamovilidad->TXT_PERIODO)))); ?></td>
					    </tr>
					    <tr>
					      <td class="primertab"><b>FECHA EMISION</b></td>
					      <td><b> : </b><?php echo e(date_format(date_create($planillamovilidad->FECHA_EMI), 'd/m/Y h:i:s')); ?></td>
					    </tr>
					    <tr>
					      <td class="primertab"><b>NOMBRE Y APELLIDO</b></td>
					      <td><b> : </b><?php echo e(ucwords(strtolower($planillamovilidad->TXT_TRABAJADOR))); ?></td>
					    </tr>
						<tr>
					      <td class="primertab"><b>DNI</b></td>
					      <td><b> : </b><?php echo e($planillamovilidad->DOCUMENTO_TRABAJADOR); ?></td>
					    </tr>	   
						<tr>
					      <td class="primertab"><b>LUGAR DE TRABAJO</b></td>
					      <td><b> : </b><?php echo e(ucwords(strtolower($planillamovilidad->TXT_DIRECCION))); ?></td>
					    </tr>
						<tr>
					      <td class="primertab"><b>GLOSA</b></td>
					      <td><b> : </b><?php echo e(ucwords(strtolower($planillamovilidad->TXT_GLOSA))); ?></td>
					    </tr>

					</table>

			    </div>
			</div>
        </article>

        <article>

		  <table class="tpm">
		    <tr>
		      <th colspan="3" style="border: none !important;"></th>
		      <th colspan="2" class='titulo'>DESPLAZAMIENTO</th>
		      <th colspan="2" class='titulo'>MONTO GASTADO (*)</th>
		    </tr>

		    <tr>
		      <th class='titulo'>ITEM</th>
		      <th class='titulo'>FECHA GASTO</th>
		      <th class='titulo'>MOTIVO</th>
		      <th class='titulo'>PUNTO DE PARTIDA</th>
		      <th class='titulo'>PUNTO DE LLEGADA</th>
		      <th class='titulo'>POR VIAJE (S/)</th>
		      <th class='titulo'>POR DIA (S/)</th>
		    </tr>
			<?php 
			    $totalesPorFecha = [];
			    $ultimaFilaPorFecha = [];

			    foreach ($detplanillamovilidad as $index => $item) {
			        $fecha = date('d/m/Y', strtotime($item->FECHA_GASTO));
			        $totalesPorFecha[$fecha] = ($totalesPorFecha[$fecha] ?? 0) + $item->TOTAL;
			        $ultimaFilaPorFecha[$fecha] = $index; // Reemplaza con el último índice por fecha
			    }
			 ?>

			<?php $__currentLoopData = $detplanillamovilidad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    <?php 
			        $fecha = date('d/m/Y', strtotime($item->FECHA_GASTO));
			     ?>
			    <tr>
			        <td class='titulo'><?php echo e($index + 1); ?></td>
			        <td class='titulo'><?php echo e($fecha); ?></td>
			        <td class=''><?php echo e(mb_convert_case(ucwords(strtolower($item->TXT_MOTIVO)), MB_CASE_TITLE, "UTF-8")); ?></td>
			        <td class=''><?php echo e(ucwords(strtolower($item->TXT_LUGARPARTIDA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_DEPARTAMENTO_PARTIDA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_PROVINCIA_PARTIDA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_DISTRITO_PARTIDA))); ?></td>
			        <td class=''><?php echo e(ucwords(strtolower($item->TXT_LUGARLLEGADA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_DEPARTAMENTO_LLEGADA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_PROVINCIA_LLEGADA))); ?> - <?php echo e(ucwords(strtolower($item->TXT_DISTRITO_LLEGADA))); ?></td>
			        <td class='izquierda'><?php echo e(number_format(round($item->TOTAL, 2), 2, '.', ',')); ?></td>
			        <td class='izquierda'>
			            <?php if($index === $ultimaFilaPorFecha[$fecha]): ?>
			                <?php echo e(number_format(round($totalesPorFecha[$fecha], 2), 2, '.', ',')); ?>

			            <?php endif; ?>
			        </td>
			    </tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			    <tr>			    	
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'><b>TOTAL S/</b></td>
			      <td class='izquierda'><b><?php echo e(number_format(round($detplanillamovilidad->sum('TOTAL'),2),2,'.',',')); ?></b></td>
			    </tr>
		  </table>

        </article>


		<table style="width: 100%; text-align: center; margin-top: 50px; border-collapse: collapse; border: none;">
		    <tr>
		        <td style="width: 50%; text-align: center; border: none;">
		            <!-- <img src="<?php echo e(public_path($imgresponsable)); ?>" style="width: 150px;" alt="Firma 1"> -->
		            <p style="margin-top: 10px;">RESPONSABLE</p>
		            <p style="margin-top: 10px;"><?php echo e($nombre_responsable); ?></p>
		        </td>
		    </tr>
		</table>


        <article>
			<div class="leyenda">
			    <div class="">
	   				<p>	<b>Base legal</b><br>
	   					 Inciso a 1) del articulo 37 del TUO de la ley del impuesto de la Renta <br> Inciso v) del articulo 21º del Reglamneto
	   					de la Ley del Impuesto a la Renta.<br>
	   					(*) El total diario no debe exceder el 4% de la Remuneración minima vital mensual. Siendo a la fecha, RMW: S/.1,130.00, el tope es S/.45.00<br>
	   				</p>  		    		   					   				
			    </div>
			</div>
        </article>




    </section>    
</body>


</footer>

</html>