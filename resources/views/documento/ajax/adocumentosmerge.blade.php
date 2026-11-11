<input type="hidden" name="array_detalle_merge" id='array_detalle_merge' value='{{json_encode($array_detalle_merge)}}'>

@if(count($array_detalle_merge)<=0)
  <div class='ajaxvacio'>
  Agrege documentos ...
  </div>
@endif


<table class="table listaservicios" style='font-size: 11px;' id="" >
<thead>
  <tr>
      <th>SERIE - NUMERO</th>
      <th>FECCHA</th>
      <th>FORMA PAGO</th>
      <th>RUC</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
  </tr>
</thead>
<tbody>
@foreach($array_detalle_merge as $index => $item)
      <tr class='fila_servicio'>
          <td>{{$item['SERIE']}} - {{$item['NUMERO']}}</td>
          <td>{{$item['FEC_VENTA']}}</td>
          <td>{{$item['FORMA_PAGO']}}</td>
          <td>{{$item['RUC_PROVEEDOR']}}</td>
          <td>{{$item['RZ_PROVEEDOR']}}</td>
          <td>{{$item['TOTAL_VENTA_ORIG']}}</td>
      </tr>                    
@endforeach
</tbody>
</table>







