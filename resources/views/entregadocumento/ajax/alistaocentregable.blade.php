<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>UC</th>
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
      <th>

      </th>

    </tr>
  </thead>
  <tbody>

    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_ORDEN}}"
        >
        <td>{{$index + 1}}</td>
        <td>{{$item->TXT_CONTACTO}}</td>

        <td>{{$item->COD_ORDEN}}</td>
        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
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
        <td>{{$item->CAN_TOTAL}}</td>

        <td><b>
          @IF($item->CAN_DETRACCION>0)
            {{$item->CAN_TOTAL - $item->CAN_DETRACCION}}
          @ELSE
            @IF($item->CAN_RETENCION>0)
              {{$item->CAN_TOTAL - $item->CAN_RETENCION}}
            @ELSE
              {{$item->CAN_TOTAL}}               
            @ENDIF
          @ENDIF</b>
        </td>

        <td>

            <div class="text-center be-checkbox be-checkbox-sm has-primary">
              <input  type="checkbox"
                class="{{$item->COD_ORDEN}} input_asignar"
                id="{{$item->COD_ORDEN}}" >

              <label  for="{{$item->COD_ORDEN}}"
                    data-atr = "ver"
                    class = "checkbox checkbox_asignar"                    
                    name="{{$item->COD_ORDEN}}"
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