<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>
      <th>DETRACION</th>
      <th>ANTICIPO</th>
      <th>NETO A PAGAR</th>
      <th>
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : </b> {{$item->ID_DOCUMENTO}}  </span>
          <span><b>NRO DOCUMENTO : </b> {{$item->COD_DOCUMENTO_CTBLE}}  </span>
          <span><b>DOCUMENTO : </b> {{$item->SERIE}} - {{$item->NUMERO}}  </span>
          <span><b>PROVEEDOR  :</b> {{$item->TXT_EMPR_EMISOR}}</span>
          <span><b>COMPROBANTE ASOCIADO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FECHA VENCIMIENTO DOC: </b> {{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}  </span>
          <span><b>FECHA APROBACION ADMIN  :</b>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
          <span><b>ESTADO CANJE  :</b>
            @IF($item->NRO_SERIE == '')
              <span class="badge badge-danger" style="width: 100px;">SIN CANJEAR</span>
            @ELSE
              <span class="badge badge-success" style="width: 100px;">CANJEADO</span>
            @ENDIF
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> {{$item->IND_MATERIAL_SERVICIO}}  </span>
          <span><b>BANCO  :</b>{{$item->TXT_EMPR_BANCO}}</span>
          <span><b>SUBIO VOUCHER  :</b>
            @IF($item->COD_ESTADO == 'ETM0000000000008')
              SI
            @ELSE
              NO
            @ENDIF
          </span>
          <span><b>CUENTA DETRACCION: </b> {{$item->CTA_DETRACCION}}  </span>
          <span><b>VALOR DETRACCION  :</b>{{$item->VALOR_DETRACCION}}</span>
          <span><b>PAGO DETRACCION: </b> {{$item->TXT_PAGO_DETRACCION}}  </span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <span><b>{{ number_format(round($item->TOTAL_VENTA_ORIG, 4), 4, '.', ',') }}  </b></span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b>{{$item->MONTO_DETRACCION_RED}}</b>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b>{{ number_format(round($item->MONTO_ANTICIPO_DESC, 4), 4, '.', ',') }}</b>
        </td>
        <td class="center neto_pagar"><b>{{number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')}}</b></td>
        <td>
            @IF($item->NRO_SERIE != '' && 0<=0)
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="{{$item->ID_DOCUMENTO}} input_asignar selectfolio"
                id="{{$item->ID_DOCUMENTO}}" 
                @if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO) checked @endif>
              <label  for="{{$item->ID_DOCUMENTO}}"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="{{$item->ID_DOCUMENTO}}"
              ></label>
            </div>
            @ENDIF
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