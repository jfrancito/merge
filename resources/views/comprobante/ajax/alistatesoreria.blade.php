<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th></th>

      <th>ORDEN COMPRA</th>
      <th>FACTURA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
          data_linea = "{{$item->DOCUMENTO_ITEM}}"
          data_orden_compra = "{{$item->COD_ORDEN}}"
          data_proveedor = "{{$item->TXT_EMPR_CLIENTE}}"
          data_serie = "{{$item->SERIE}}"
          data_numero = "{{$item->NUMERO}}"
          data_total = "{{$item->CAN_TOTAL}}"


          class='dobleclickpc seleccionar'
        >
        <td>{{$index+1}}</td>
        <td>  
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="{{$item->ID_DOCUMENTO}} input_check_pe_ln check{{$item->ID_DOCUMENTO}}" 
                    id="{{$item->ID_DOCUMENTO}}">
            <label  for="{{$item->ID_DOCUMENTO}}"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="{{$item->ID_DOCUMENTO}}"
            ></label>
          </div>
        </td>

  
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : {{$item->COD_ORDEN}} </b> </span>
          <span><b>FECHA  : {{$item->FEC_ORDEN}}</b></span>
          <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_CLIENTE}}</span>
          <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
          <span><b>ORSERVACION : </b>               
              @if($item->ind_observacion == 1) 
                  <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
              @else
                @if($item->ind_observacion == 0) 
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                @else
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                @endif
              @endif
          </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          <span><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
        </td>

        @include('comprobante.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/pago-comprobante-tesoreria/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                  Comprobante Pago
                </a>  
              </li>
            </ul>
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