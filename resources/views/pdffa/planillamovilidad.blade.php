<!DOCTYPE html>
<html lang="es">
<head>
	<title>Planilla de Movilidad ({{$planillamovilidad->SERIE}}-{{$planillamovilidad->NUMERO}}) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>


</head>
<body>
    <header>
	<div class="center">
		<h3>PLANILLA POR GASTO DE MOVILIDAD SIN COMPROBANTE</h3>
	</div>

	<div class="menu">
	    <div class="left">
				<img src="{{ public_path('img/logonitido.png') }}" style="width: 200px;" alt="Logo">   
	    </div>
	    <div class="right">
	    		<h3>R.U.C. {{$ruc}}</h3> 
	    		<h4>{{$planillamovilidad->TXT_EMPRESA}}</h4>
	    		<h3>{{$planillamovilidad->SERIE}}-{{$planillamovilidad->NUMERO}}</h3> 
	    </div>
	</div>
    </header>
    <section>
        <article>
			<div class="top">
			    <div class="det1">
	   				<p>
	   					<strong>Periodo:</strong> {{$planillamovilidad->TXT_PERIODO}}
	   				</p>  		    		   					   				
	   				<p>
	   					<strong>Fecha Emision :</strong> {{date_format(date_create($planillamovilidad->FECHA_EMI), 'd/m/Y h:i:s')}}   					
	   				</p>
	   				<p>
	   					<strong>Nombre y Apellidos :</strong> {{$planillamovilidad->TXT_TRABAJADOR}}
	   				</p>	
	   				<p>
	   					<strong>DNI :</strong> {{$planillamovilidad->DOCUMENTO_TRABAJADOR}}
	   				</p>
	   				<p>
	   					<strong>GLOSA :</strong> {{$planillamovilidad->TXT_GLOSA}}
	   				</p>

			    </div>
			</div>
        </article>

        <article>

		  <table class="tpm">
		    <tr>
		      <th colspan="2"></th>
		      <th colspan="3">DESPLAZAMIENTO</th>
		      <th colspan="2">MONTO GASTADO POR (*)</th>
		    </tr>

		    <tr>
		      <th class='titulo'>ITEM</th>
		      <th class='titulo'>FECHA GASTO</th>
		      <th class=''>MOTIVO</th>
		      <th class=''>PUNTO DE PARTIDA</th>
		      <th class=''>PUNTO DE LLEGADA</th>
		      <th class='titulo'>POR VIAJE (S/)</th>
		      <th class='titulo'>POR DIA (S/)</th>
		    </tr>
			@php
			    $totalesPorFecha = [];
			    $ultimaFilaPorFecha = [];

			    foreach ($detplanillamovilidad as $index => $item) {
			        $fecha = date('d/m/Y', strtotime($item->FECHA_GASTO));
			        $totalesPorFecha[$fecha] = ($totalesPorFecha[$fecha] ?? 0) + $item->TOTAL;
			        $ultimaFilaPorFecha[$fecha] = $index; // Reemplaza con el último índice por fecha
			    }
			@endphp

			@foreach($detplanillamovilidad as $index => $item)
			    @php
			        $fecha = date('d/m/Y', strtotime($item->FECHA_GASTO));
			    @endphp
			    <tr>
			        <td class='titulo'>{{ $index + 1 }}</td>
			        <td class='titulo'>{{ $fecha }}</td>
			        <td class=''>{{ $item->TXT_MOTIVO }}</td>
			        <td class=''>{{ $item->TXT_LUGARPARTIDA }} - {{ $item->TXT_DEPARTAMENTO_PARTIDA }} - {{ $item->TXT_PROVINCIA_PARTIDA }} - {{ $item->TXT_DISTRITO_PARTIDA }}</td>
			        <td class=''>{{ $item->TXT_LUGARLLEGADA }} - {{ $item->TXT_DEPARTAMENTO_LLEGADA }} - {{ $item->TXT_PROVINCIA_LLEGADA }} - {{ $item->TXT_DISTRITO_LLEGADA }}</td>
			        <td class='izquierda'>{{ number_format(round($item->TOTAL, 2), 2, '.', ',') }}</td>
			        <td class='izquierda'>
			            @if ($index === $ultimaFilaPorFecha[$fecha])
			                {{ number_format(round($totalesPorFecha[$fecha], 2), 2, '.', ',') }}
			            @endif
			        </td>
			    </tr>
			@endforeach

			    <tr>			    	
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'><b>TOTAL S/</b></td>
			      <td class='izquierda'><b>{{number_format(round($detplanillamovilidad->sum('TOTAL'),2),2,'.',',')}}</b></td>
			    </tr>
		  </table>

        </article>


		<table style="width: 100%; text-align: center; margin-top: 50px; border-collapse: collapse; border: none;">
		    <tr>
		        <td style="width: 50%; text-align: center; border: none;">
		            <img src="{{ public_path($imgresponsable) }}" style="width: 150px;" alt="Firma 1">
		            <p style="margin-top: 10px;">RESPONSABLE</p>
		            <p style="margin-top: 10px;">{{$nombre_responsable}}</p>
		        </td>
		        <td style="width: 50%; text-align: center; border: none;">
		            <img src="{{ public_path($imgaprueba) }}" style="width: 150px;" alt="Firma 2">
		            <p style="margin-top: 10px;">APROBADO POR</p>
		            <p style="margin-top: 10px;">{{$nombre_aprueba}}</p>
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