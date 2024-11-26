<table id="" class="table table-striped table-borderless table-hover td-color-borde td-padding-7" >
	  <thead>
	    <tr>
	      <th>ITEM</th>
	      <th>NRO OC</th>
	      <th>RUC</th>
	      <th>PROVEEDOR</th>
	      <th>BANCO</th>
	      <th>COMPROBANTE ASOCIADO</th>
	      <th>FECHA VENCIMIENTO DOC</th>
	      <th>FECHA APROBACION ADMIN</th>
	      <th>TIPO</th>
	      <th>SUBIO VOUCHER</th>
	      <th>ORDEN INGRESO</th>
	      <th>OBLIGACION</th>
	      <th>DESCUENTO</th>
	      <th>TOTAL DESCUENTO</th>
	      <th>PERCEPCION</th>

	      <th>IMPORTE</th>
	      <th>NETO A PAGAR</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@php $monto_total =  0; @endphp
	    @foreach($listadatos as $index => $item)
	      <tr>
	        <td>{{$index + 1}}</td>
	        <td>{{$item->COD_ORDEN}}</td>
	        <td>{{$item->RUC_PROVEEDOR}}</td>
	        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
	        <td>{{$item->TXT_CATEGORIA_BANCO}}</td>
	        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
	        <td>{{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}</td>
	        <td>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</td>
	        <td>{{$item->IND_MATERIAL_SERVICIO}}</td>
	        <td>
	            @IF($item->COD_ESTADO_VOUCHER == 'ETM0000000000008')
	              SI
	            @ELSE
	              NO
	            @ENDIF
	        </td>
	        <td>{{$item->COD_TABLA_ASOC}}</td>
	        <td>
	          @IF($item->CAN_DETRACCION>0)
	            DETRACION
	          @ELSE
	            @IF($item->CAN_RETENCION>0)
	              RETENCION              
	            @ENDIF
	          @ENDIF
	        </td>
	        <td>{{$item->CAN_DSCTO}}</td>

	        <td>
	          @IF($item->CAN_DETRACCION>0)
	            {{$item->CAN_DETRACCION}}
	          @ELSE
	            @IF($item->CAN_RETENCION>0)
	              {{$item->CAN_RETENCION}}
	            @ELSE
	              0.00                
	            @ENDIF
	          @ENDIF
	        </td>
	        <td>{{round($item->PERCEPCION,2)}}</td>
	        <td>{{$item->CAN_TOTAL}}</td>
	        <td>
	        	{{$funcion->funciones->neto_pagar_oc($item)}}
		        @php $monto_total  = $monto_total + $funcion->funciones->neto_pagar_oc($item); @endphp
	        </td>
	      </tr>                    
	    @endforeach
	  </tbody>
	  <tfoot>
	      <tr>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	        <td></td>
	       	<td></td>
	        <td></td>
	        <td></td>
	        <td></td>

	        <td>{{number_format($monto_total, 2, '.', '')}}</td>
	      </tr>                    
	  </tfoot>
	</table>

