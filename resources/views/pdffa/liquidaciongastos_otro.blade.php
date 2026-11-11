<!DOCTYPE html>
<html lang="es">
<head>
	<title>LIQUIDACION DE GASTOS ({{$liquidaciongastos->ID_DOCUMENTO}}) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>

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
	   					<strong>NOMBRE:</strong> {{$liquidaciongastos->TXT_EMPRESA_TRABAJADOR}}
	   				</p>  		    		   					   				
	   				<p>
	   					<strong>AREA :</strong> {{$liquidaciongastos->TXT_AREA}}   					
	   				</p>
			    </div>
			</div>
        </article>

        <article>
		  <table>
		    <tr>
		      <th class='titulo'></th>
		      <th class='titulo'>TIPO COMPROBANTE</th>
		      <th class='titulo'>FECHA</th>
		      <th class='titulo'>COMPROBANTE</th>
		      <th class='titulo'>CANTIDAD</th>
		      <th class='titulo'>MONTO</th>
		      <th class='titulo'>TOTAL</th>
		    </tr>
			@php
			    $prevDescription = null; // Variable para rastrear el valor anterior
			@endphp

			@foreach($productosagru as $index => $item)
			    @if($item->TXT_DESCRIPCION != $prevDescription)
			        <tr style="background-color: #f0f0f0;"> <!-- Estilo opcional para resaltar -->
			            <td colspan="7" class="derecha">
			                <strong>{{ $item->TXT_DESCRIPCION }}</strong> <!-- Campo agrupador -->
			            </td>
			        </tr>
			        @php
			            $prevDescription = $item->TXT_DESCRIPCION; // Actualizar el valor anterior
			        @endphp
			    @endif
			    <tr>			    	
			        <td class='titulo'></td>
			        <td class='derecha'>{{ $item->TXT_TIPODOCUMENTO }}</td>
			        <td class='titulo'>{{ date_format(date_create($item->FECHA_EMISION), 'd/m/Y') }}</td>
			        <td class='titulo'>{{ $item->SERIE }}-{{ $item->NUMERO }}</td>
			        <td class='titulo'>{{ $item->CANTIDAD }}</td>
			        <td class='titulo'>{{ $item->CAN_TOTAL_DETALLE }}</td>
			        <td class='izquierda'>{{ number_format(round($item->CAN_TOTAL_DETALLE, 2), 2, '.', ',') }}</td>
			    </tr>
			@endforeach	    
			    <tr>			    	
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='izquierda'>{{number_format(round($productosagru->sum('CAN_TOTAL_DETALLE'),2),2,'.',',')}}</td>
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
		    </tr>
		</table>
    </section>  
</body>
</footer>

</html>