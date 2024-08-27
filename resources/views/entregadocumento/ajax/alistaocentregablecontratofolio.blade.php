<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>NRO OC</th>
      <th>PROVEEDOR</th>
      <th>COMPROBANTE ASOCIADO</th>
      <th>FECHA VENCIMIENTO DOC</th>
      <th>FECHA APROBACION ADMIN</th>
      <th>TIPO</th>
      <th>SUBIO VOUCHER</th>
      <th>ORDEN INGRESO</th>
      <th>OBLIGACION</th>
      <th>DESCUENTO</th>
      <th>TOTAL DESCUENTO</th>
      <th>IMPORTE</th>
      <th>NETO A PAGAR</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_DOCUMENTO_CTBLE}}">
        <td>{{$index + 1}}</td>
        <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>
        <td>{{$item->TXT_EMPR_EMISOR}}</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{$item->CAN_TOTAL}}</td>
        <td><b>{{$item->CAN_TOTAL}}</b></td>
      </tr>                    
    @endforeach
  </tbody>
</table>

