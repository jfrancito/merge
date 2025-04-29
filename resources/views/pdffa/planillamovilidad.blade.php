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
		      <th class='titulo'>LUGAR PARTIDA</th>
		      <th class='titulo'>LUGAR LLEGADA</th>
		      <th class='titulo'>TOTAL</th>
		    </tr>
		    @foreach($detplanillamovilidad  as $index=>$item)
			    <tr>			    	
			      <td class='titulo'>{{$index+1}}</td>
			      <td class='titulo'>{{date_format(date_create($item->FECHA_GASTO), 'd/m/Y h:i:s')}}</td>
			      <td class='titulo'>{{$item->TXT_MOTIVO}}</td>
			      <td class='titulo'>{{$item->TXT_LUGARPARTIDA}}</td>
			      <td class='titulo'>{{$item->TXT_LUGARLLEGADA}}</td>
			      <td class='izquierda'>{{number_format(round($item->TOTAL,2),2,'.',',')}}</td>
			    </tr>
		    @endforeach		    
			    <tr>			    	
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='titulo'></td>
			      <td class='izquierda'>{{number_format(round($detplanillamovilidad->sum('TOTAL'),2),2,'.',',')}}</td>
			    </tr>
		  </table>

        </article>


    </section>    
</body>
</html>