<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>
      <th>DESCUENTO</th>
      <th>PERCEPCCION</th>
      <th>NETO A PAGAR</th>
      <th>
<!--         <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input  type="checkbox"
                  class="todo_asignar input_asignar"
                  id="todo_asignar"
          >
          <label  for="todo_asignar"
                  data-atr = "todas_asignar"
                  class = "checkbox_asignar"                    
                  name="todo_asignar"
            ></label>
        </div> -->
      </th>
    </tr>
  </thead>
  <tbody>

    @foreach($listadatos as $index => $item)
      <tr 
        data_requerimiento_id = "{{$item->COD_ORDEN}}"
        class="toptable" 
        >
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>NRO OC : </b> {{$item->COD_ORDEN}}  </span>
          <span><b>PROVEEDOR  :</b> {{$item->TXT_EMPR_CLIENTE}}</span>
          <p style="margin-bottom: 1px;"><b>COMPROBANTE ASOCIADO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}} 
            <span style="display: inline;color: #34a853;cursor: pointer;font-size: 18px;" class="mdi mdi-eye mdidetdoc" data_doc="{{$item->COD_ORDEN}}"></span> </p>
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FECHA VENCIMIENTO DOC: </b> {{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}  </span>
          <span><b>FECHA APROBACION ADMIN  :</b>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
          <span><b>MONEDA  :</b>{{$item->TXT_CATEGORIA_MONEDA}}</span>

          @if($permiso_editar_cuenta==1)
            <div class="tools ver_cuenta_bancaria_oc select" 
              data_prefijo_id = "{{substr($item->COD_ORDEN, 0,6)}}"
              data_orden_id = "{{Hashids::encode(substr($item->COD_ORDEN, -10))}}"
              style="cursor: pointer;width: 100px;margin-bottom: 12px;"> 
              <span class="label label-success">Ver Cuenta</span>
            </div>
            <div class="tools agregar_cuenta_bancaria_oc select" 
              data_prefijo_id = "{{substr($item->COD_ORDEN, 0,6)}}"
              data_orden_id = "{{Hashids::encode(substr($item->COD_ORDEN, -10))}}"
              style="cursor: pointer;width: 100px;"> 
              <span class="label label-success">Agregar Cuenta</span>
            </div>
          @endif



        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>TIPO: </b> {{$item->IND_MATERIAL_SERVICIO}}  </span>
          <span><b>BANCO  :</b>{{$item->TXT_BANCO}}</span>
          <span><b>CUENTA  :</b>{{$item->TXT_NRO_CUENTA_BANCARIA}}</span>

          <span><b>SUBIO VOUCHER  :</b>
            @IF($item->COD_ESTADO_VOUCHER == 'ETM0000000000008')
              SI
            @ELSE
              NO
            @ENDIF
          </span>
          <span><b>ORDEN INGRESO  :</b>{{$item->COD_TABLA_ASOC}}</span>
          <span><b>PAGO DETRACCION  :</b>{{$item->TXT_PAGO_DETRACCION}}</span>
          <span><b>AVISO NOTA CREDITO  :
            @IF($item->NC_PROVEEDOR > 0)
              {{$item->NC_PROVEEDOR}}
            @ELSE
              0
            @ENDIF</b>
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>IMPORTE: </b> {{$item->CAN_TOTAL}}  </span>
          <span><b>ANTICIPO  :</b>{{round($item->MONTO_ANTICIPO_DESC,4) + round($item->MONTO_ANTICIPO_DESC_OTROS,4)}}</span>
          <span><b>NOTA CREDITO  :</b>{{round($item->MONTO_NC,4)}}</span>
          <span><b>COMPENSACION  :</b>{{round($item->COMPENSACION,2)}}</span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>OBLIGACION: </b>           
            @IF($item->CAN_DETRACCION>0)
              DETRACION
            @ELSE
              @IF($item->CAN_RETENCION>0)
                RETENCION IGV
              @ELSE
                @IF($item->CAN_IMPUESTO_RENTA>0)
                  RETENCION 4TA CATEGORIA
                @ENDIF
              @ENDIF
            @ENDIF  
          </span>
          <span><b>DESCUENTO: </b> {{$item->CAN_DSCTO}}</span>
          <span><b>TOTAL DESCUENTO: </b>           
            @IF($item->CAN_DETRACCION>0)
              {{$item->CAN_DETRACCION}}
            @ELSE
              @IF($item->CAN_RETENCION>0)
                {{$item->CAN_RETENCION}}
              @ELSE
                @IF($item->CAN_IMPUESTO_RENTA>0)
                  {{$item->CAN_IMPUESTO_RENTA}}
                @ELSE
                  0.00                
                @ENDIF
              @ENDIF
            @ENDIF
          </span>
        </td>
        <td>
          <b>
            {{number_format(round($item->PERCEPCION,4), 4, '.', ',')}}
          </b>
        </td>
        <td class="center neto_pagar">
          <b>
            {{number_format($funcion->funciones->neto_pagar_documento($item->ID_DOCUMENTO), 4, '.', ',')}}
          </b>
        </td>
        <td>
            @IF($item->NC_PROVEEDOR<=0)
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="{{$item->COD_ORDEN}} input_asignar selectfolio"
                id="{{$item->COD_ORDEN}}"
                @if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO) checked @endif>

              <label  for="{{$item->COD_ORDEN}}"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="{{$item->COD_ORDEN}}"
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