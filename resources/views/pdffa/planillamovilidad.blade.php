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

			    </div>
			</div>
        </article>

        <article>

		  <table>
		    <tr>
		      <th class='titulo'>ITEM</th>
		      <th class='titulo'>FECHA GASTO</th>
		      <th class='titulo'>MOTIVO</th>
		      <th class='titulo'>DESTINO</th>
		      <th class='titulo'>TOTAL (S/)</th>
		    </tr>
		    @foreach($detplanillamovilidad  as $index=>$item)
			    <tr>			    	
			      <td class='titulo'>{{$index+1}}</td>
			      <td class='titulo'>{{date_format(date_create($item->FECHA_GASTO), 'd/m/Y')}}</td>
			      <td class='titulo'>{{$item->TXT_MOTIVO}}</td>
			      <td class='titulo'>{{$item->TXT_LUGARLLEGADA}}</td>
			      <td class='izquierda'>{{number_format(round($item->TOTAL,2),2,'.',',')}}</td>
			    </tr>
		    @endforeach		    
			    <tr>			    	
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
	   				<p>
	   					Base legal Inciso a 1) del articulo 37 del TUO de la ley del impuesto de la Renta e Inciso v) del articulo 21º del Reglamneto
	   					de la Ley del Impuesto a la Renta.<br>
	   					(*) El total diario no debe exceder el 4% del sueldo minimo.<br>
	   					(**) La falta de consignación de alguno de estos datos inhabilita la planilla para la sustentación del gasto que corresponde a tal 
	   					desplazamiento.
	   				</p>  		    		   					   				
			    </div>
			</div>
        </article>




    </section>    
</body>


</footer>

</html>