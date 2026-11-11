<!DOCTYPE html>

<html lang="es">

<head>
	<title>Factura ({{$doc->serie}}-{{$doc->numero}}) </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}"> 
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/pdf.css') }} "/>


</head>

<body>
    <header>
	<div class="menu">
	    <div class="left">
	    		<h1>{{$razonsocial}}</h1> 
	    		<h3>{{$direccion}} {{$departamento}} - {{$provincia}} - {{$distrito}}</h3>
	    		<h4>Teléfono : {{$telefono}}</h4>    
	    </div>
	    <div class="right">
	    		<h3>R.U.C. {{$ruc}}</h3> 
	    		<h3>{{$titulo}}</h3>
	    		<h3>{{$doc->serie}}-{{$doc->numero}}</h3> 

	    </div>
	</div>
    </header>
    <section>
        <article>

			<div class="top">
			    <div class="det1">
	   				<p>
	   					<strong>Señor (es) :</strong> {{$doc->proveedor_nombre}}
	   				</p>  		    		   					   				
	   				<p>
	   					<strong>RUC :</strong> {{$doc->proveedor->numerodocumento}}	   					
	   				</p>
	   				<p>
	   					<strong>Dirección :</strong> {{$doc->proveedor->direccion}}
	   				</p>					
			    </div>

			    <div class="det2">

	   				<p class="d1">
	   					<strong>Fecha de Emisión :</strong> {{date_format(date_create($doc->fecha), 'd/m/Y')}}
	   				</p>  		    	
	   				<p class="d2">
	   					<strong>Fecha de Vencimiento :</strong> {{date_format(date_create($doc->fecha), 'd/m/Y')}}
	   				</p>
	   				<p class="d3">
	   					<strong>Condición de Pago  :</strong> Contado
	   				</p>
	


			    </div>
			</div>
        </article>
        <article>

		  <table>
		    <tr>
		      <th class='titulo codigo'>CODIGO</th>
		      <th class='descripcion'>DESCRIPCIÓN</th>
		      <th class='titulo unidad'>UNIDAD</th>
		      <th class='titulo cantidad'>CANTIDAD</th>
		      <th class='titulo precio'>PRECIO</th>
		      <th class='titulo importe'>IMPORTE</th>
		    </tr>


		    @foreach($doc->detalle as $item)
			    <tr>			    	
			      <td class='titulo'>{{$item->producto->codigo}}</td>
			      <td>{{$item->producto_nombre}}</td>
			      <td class='titulo'>{{$item->producto->unidad_medida_nombre}}</td>
			      <td class='titulo'>{{number_format(round($item->cantidad,2),2,'.','')}}</td>
			      <td class='titulo'>{{number_format(round($item->preciounitario,2),2,'.','')}}</td>
			      <td class='izquierda'>{{number_format(round($item->total,2),2,'.',',')}}</td>
			    </tr>
		    @endforeach		    

		    <tr>
		      <td  colspan="6">SON : {{$letras}}</td>
		    </tr>

		  </table>

        </article>

        <article>
			<div class="totales">
				<div class="left">			    	
			    </div>
			    <div class="right">
			    		<p class='descripcion izquierda'>
			    			SUB TOTAL S/
			    		</p>
			    		<p class='monto izquierda'>
			    			{{number_format(round($subtotal,2),2,'.',',')}}
			    		</p>
			    		<br>			    		
			    		<p class='descripcion izquierda'>
			    			IMPORTE TOTAL  S/
			    		</p>
			    		<p class='monto izquierda'>
			    			{{number_format(round($subtotal,2),2,'.',',')}}
			    		</p>
			    </div>
			</div>
        </article>
    </section>    
</body>
</html>