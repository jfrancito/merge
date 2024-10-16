<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>

      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>

      <th>NETO A PAGAR</th>
      <th>

      </th>

    </tr>
  </thead>
  <tbody>

    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_DOCUMENTO_CTBLE}}">
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>NRO OC : </b> {{$item->COD_DOCUMENTO_CTBLE}}  </span>
          <span><b>PROVEEDOR  :</b> {{$item->TXT_EMPR_EMISOR}}</span>
          <span><b>COMPROBANTE ASOCIADO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FECHA VENCIMIENTO DOC: </b> {{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}  </span>
          <span><b>FECHA APROBACION ADMIN  :</b>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> {{$item->IND_MATERIAL_SERVICIO}}  </span>
          <span><b>BANCO  :</b>{{$item->TXT_BANCO}}</span>
          <span><b>SUBIO VOUCHER  :</b>
            @IF($item->COD_ESTADO_VOUCHER == 'ETM0000000000008')
              SI
            @ELSE
              NO
            @ENDIF
          </span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>IMPORTE: </b> {{$item->CAN_TOTAL}}  </span>
        </td>

        <td><b>{{$item->CAN_TOTAL}}</b></td>
        <td>

            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="{{$item->COD_DOCUMENTO_CTBLE}} input_asignar"
                id="{{$item->COD_DOCUMENTO_CTBLE}}" >

              <label  for="{{$item->COD_DOCUMENTO_CTBLE}}"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="{{$item->COD_DOCUMENTO_CTBLE}}"
              ></label>
            </div>

        </td>

      </tr>                    
    @endforeach
  </tbody>
</table>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif

@if(isset($mensaje))
  <script type="text/javascript">
    alertajax("{{$mensaje}}");
  </script> 
@endif