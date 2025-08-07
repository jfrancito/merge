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
	   					<strong>CODIGO:</strong> {{$codigoosiris}}
	   				</p> 
	   				<p>
	   					<strong>NOMBRE:</strong> {{$liquidaciongastos->TXT_EMPRESA_TRABAJADOR}}
	   				</p>  		    		   					   				
	   				<p>
	   					<strong>AREA :</strong> {{$liquidaciongastos->TXT_AREA}}   					
	   				</p>
	   				<p>
	   					<strong>LUGAR DE VIAJE :</strong> {{$lugarviaje}}   					
	   				</p>
	   				<p>
	   					<strong>MOTIVO DEL VIAJE :</strong> {{$motivoviaje}}   					
	   				</p>
	   				<p>
	   					<strong>FECHA DE VIAJE:</strong> {{$cadenaFechas}}   					
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
			            @foreach($tipos_documento as $tipo)
			                <th style="width: {{ 40 / count($tipos_documento) }}%;">{{ $tipo }}</th>
			            @endforeach
			            <th style="width: 10%;">TOTAL</th>
			        </tr>
			    </thead>
			    <tbody>

                    @php
                      $total    =   0;
                    @endphp

			        @foreach($datos as $descripcion => $productos)
			            @foreach($productos as $producto => $valores)
			                <tr>
			                    <td class="grupo">{{ strtoupper($descripcion) }}</td>
			                    <td>{{ strtoupper($producto) }}</td>
			                    
			                    @foreach($tipos_documento as $tipo)
			                        <td style="text-align: center;">{{ $valores[$tipo] ?: '' }}</td>
			                    @endforeach
			                    
			                    <td style="text-align: right;">{{ number_format($valores['TOTAL'], 2) }}</td>
			                </tr>

		                    @php
		                      $total    =   $total + $valores['TOTAL'];
		                    @endphp

			            @endforeach
			        @endforeach

				    <tr>			    	
				      	<td>TOTAL DE GASTOS</td>
				      	<td class='titulo'></td>
			            @foreach($tipos_documento as $tipo)
			                <td class='titulo'></td>
			            @endforeach
				      	<td class='izquierda'><b>{{number_format(round(  $total ,2),2,'.',',')}}</b></td>
				    </tr>

				    <tr>			    	
				      	<td>N° DE VALE</td>
				      	<td class='titulo'></td>
			            @foreach($tipos_documento as $tipo)
			                <td class='titulo'></td>
			            @endforeach
				      	<td class='izquierda'><b>@if(isset($arendir->CAN_TOTAL_IMPORTE))
												    {{ number_format(round($arendir->CAN_TOTAL_IMPORTE, 2), 2, '.', ',') }}
												@else
												    {{-- Valor por defecto o dejar vacío --}}
												    0.00
												@endif</b></td>
				    </tr>

				    <tr>			    	
				      	<td>TOTAL</td>
				      	<td class='titulo'></td>
			            @foreach($tipos_documento as $tipo)
			                <td class='titulo'></td>
			            @endforeach
				      	<td class='izquierda'><b>@if(isset($arendir->CAN_TOTAL_IMPORTE))
												    {{ number_format(round($total - $arendir->CAN_TOTAL_IMPORTE, 2), 2, '.', ',') }}
												@else
												    {{$total}}
												@endif</b></td>
				    </tr>
			    </tbody>
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