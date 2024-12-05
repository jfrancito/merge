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
      <tr data_requerimiento_id = "{{$item->COD_DOCUMENTO_CTBLE}}">
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>NRO CONTRATO : </b> {{$item->COD_DOCUMENTO_CTBLE}}  </span>
          <span><b>DOCUMENTO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}  </span>
          <span><b>PROVEEDOR  :</b> {{$item->TXT_EMPR_EMISOR}}</span>
          <span><b>COMPROBANTE ASOCIADO : </b> {{$item->NRO_SERIE_DOC}} - {{$item->NRO_DOC_DOC}}</span>
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FECHA VENCIMIENTO DOC: </b> {{date_format(date_create($item->FEC_VENCIMIENTO), 'd-m-Y h:i:s')}}  </span>
          <span><b>FECHA APROBACION ADMIN  :</b>{{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>

          <span><b>ESTADO CANJE  :</b>
            @IF($item->NRO_SERIE_DOC == '')
              <span class="badge badge-danger" style="width: 100px;">SIN CANJEAR</span>
            @ELSE
              <span class="badge badge-success" style="width: 100px;">CANJEADO</span>
            @ENDIF
          </span>

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
          <span><b>CUENTA DETRACCION: </b> {{$item->CTA_DETRACCION}}  </span>
          <span><b>VALOR DETRACCION  :</b>{{$item->VALOR_DETRACCION}}</span>
          <span><b>PAGO DETRACCION: </b> {{$item->TXT_PAGO_DETRACCION}}  </span>
          <span><b>NOTA CREDITO  :
            @IF($item->NC_PROVEEDOR > 0)
              {{$item->NC_PROVEEDOR}}
            @ELSE
              0
            @ENDIF</b>
          </span>

          <span>
            <b>DEUDA:
              @IF($item->CAN_DEUDA > 0)
               <span data_id_doc = '{{$item->COD_EMPR_EMISOR}}' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;display: inline-block;">DEUDA</span>
              @ELSE
                <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
              @ENDIF
            </b>
          </span>


        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <span><b>{{round($item->TOTAL_VENTA_ORIG,2)}}  </b></span>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b>{{$item->MONTO_DETRACCION_RED}}</b>
        </td>
        <td class="cell-detail sorting_1 center" style="position: relative;">
          <b>{{round($item->MONTO_ANTICIPO_DESC,2)}}</b>
        </td>

        <td class="center"><b>{{$item->TOTAL_VENTA_ORIG - $item->MONTO_ANTICIPO_DESC - $funcion->funciones->se_paga_detraccion_contrato($item->ID_DOCUMENTO)}}</b></td>
        <td>

            @IF($item->NRO_SERIE_DOC != '' && $item->NC_PROVEEDOR<=0)

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