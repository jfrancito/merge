<input type="hidden" name="array_detalle_osiris" id='array_detalle_osiris' value='{{json_encode($array_detalle_osiris)}}'>

@if(count($array_detalle_osiris)<=0)
  <div class='ajaxvacio'>
  Agrege documentos para cnje ...
  </div>
@endif


<table class="table listaservicios" style='font-size: 11px;' id="" >
<thead>
  <tr>
      <th>Documento</th>
      <th>Fecha Emision</th>
      <th>Emisor</th>
      <th>Moneda</th>
      <th>Subtotal</th>
      <th>Impuesto</th>
      <th>Total</th>
  </tr>
</thead>
<tbody>
@foreach($array_detalle_osiris as $index => $item)
      <tr class='fila_servicio'>
          <td>{{$item['NRO_SERIE']}} - {{$item['NRO_DOC']}}</td>
          <td>{{$item['FEC_EMISION']}}</td>
          <td>{{$item['TXT_EMPR_EMISOR']}}</td>
          <td>{{$item['TXT_CATEGORIA_MONEDA']}}</td>
          <td>{{$item['CAN_SUB_TOTAL']}}</td>
          <td>{{$item['CAN_IMPUESTO_VTA']}}</td>
          <td>{{$item['CAN_TOTAL']}}</td>
      </tr>                    
@endforeach
</tbody>
</table>
