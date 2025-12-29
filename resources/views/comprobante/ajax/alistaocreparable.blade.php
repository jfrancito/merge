<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ORDEN COMPRA</th>
      <th>FACTURA</th>
      <th>ESTADO</th>
      <th></th>

      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)

      @php 
        $cantidadi_reparados    =   $funcion->funciones->cantidad_reparados($item->ID_DOCUMENTO);
      @endphp


      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : {{$item->COD_ORDEN}} </b> </span>
          <span><b>FECHA  : {{$item->FEC_ORDEN}}</b></span>
          <span><b>PROVEEDOR : </b>({{$item->RUC_PROVEEDOR}}) {{$item->TXT_EMPR_CLIENTE}} </span>
          <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
          <span><b>LINEA : </b> {{$item->DOCUMENTO_ITEM}}</span>
          @include('comprobante.ajax.areparable')
          <span><b>TIPO ARCHIVO : </b> {{$item->MODO_REPARABLE}}</span>
          <span><b>CANTIDAD ARCHIVO : </b> {{$cantidadi_reparados}}</span>
          <span><b>TIPO ARCHIVO HIBRIDO: </b> {{$item->MODO_REPARABLE_HIBRIDO}}</span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>
        @include('comprobante.ajax.estados')
        <td>  
          @if($item->MODO_REPARABLE == 'ARCHIVO_VIRTUAL' && $cantidadi_reparados ==1)
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="{{$item->ID_DOCUMENTO}} input_check_pe_re check{{$item->ID_DOCUMENTO}}" 
                    id="{{$item->ID_DOCUMENTO}}">
            <label  for="{{$item->ID_DOCUMENTO}}"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="{{$item->ID_DOCUMENTO}}"
            ></label>
          </div>
          @endif
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/reparable-comprobante-uc/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">Reparable</a>  
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