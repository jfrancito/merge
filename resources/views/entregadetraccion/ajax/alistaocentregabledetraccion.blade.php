<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>COMPROBANTE</th>
      <th>DOCUMENTO</th>
      <th>PAGO</th>
      <th>NETO A PAGAR</th>
      <th></th>
    </tr>
  </thead>
  <tbody>

    @foreach($listadatos as $index => $item)
      <tr 
        data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
        class="toptable" 
        >
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>COMPROBANTE : </b> {{$item->ID_DOCUMENTO}}  </span>
          <span><b>OPERACION  :</b> {{$item->OPERACION}}</span>
          <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}  </span>

          <span><b>PAGO DETRACCION  :</b> {{$item->TXT_PAGO_DETRACCION}}</span>
          <span><b>MONTO DETRACCION  :</b> {{$item->MONTO_DETRACCION_RED}}</span>
          <span><b>TOTAL  :</b> {{$item->TOTAL_VENTA_ORIG}}</span>
          <span><b>ESTADO  :</b> {{$item->TXT_ESTADO}}</span>
          <span><b>FOLIO DETRACCION  :</b> {{$item->FOLIO_DETRACCION}}</span>
          <span><b>CUENTA DETRACCION  :</b> {{$item->CTA_DETRACCION}}</span>

        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>DOCUMENTO : </b> {{$item->COD_DOCUMENTO_CTBLE}}  </span>
          <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}  </span>
          <span><b>FECHA EMISION  :</b> {{$item->FEC_EMISION}}</span>
          <span><b>SERIE  :</b> {{$item->NRO_SERIE}}</span>
          <span><b>NRO  :</b> {{$item->NRO_DOC}}</span>
          <span><b>MONEDA  :</b> {{$item->TXT_CATEGORIA_MONEDA}}</span>
          <span><b>PAGO DETRACCION : </b> {{$item->TXT_PAGO_DETRACCION}}  </span>
          
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">

          <span><b>PAGO TOTAL (OSIRIS) : </b> {{$item->TOTAL_PAGADO}}  </span>
          <span><b>MONTO ACUMULADO PAGO (OSIRIS) : </b> {{$item->TOTAL_PAGOS_ACUMULADOS}}  </span>

          <span><b>DETRACCION PAGADA (OSIRIS) : </b> {{$item->DETRACCION_PAGADA}}  </span>
          <span><b>MONTO DETRACION PAGO (OSIRIS) : </b> {{$item->MONTO_DETRACCION_PAGADO}}  </span>
          <span><b>HABILITACION (OSIRIS) : </b> {{$item->COD_HABILITACION_DETRACCION}}  </span>

          <span><b>PAGO SUNAT : </b> {{$item->mto_deposito_desc}}  </span>
          <span><b>USUARIO SUNAT : </b> {{$item->cod_usuario_sol}}  </span>

        </td>

        <td>
          <b>
            {{number_format(round($item->MONTO_DETRACCION_RED,4), 4, '.', ',')}}
          </b>
        </td>

        <td>
            @IF($item->CREAR_FOLIO=='NO')
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="{{$item->ID_DOCUMENTO}} input_asignar selectfolio"
                id="{{$item->ID_DOCUMENTO}}"
                @if(isset($entregable_sel)  && $item->FOLIO_DETRACCION_RESERVA==$entregable_sel->FOLIO) checked @endif>

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