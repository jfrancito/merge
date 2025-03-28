<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th></th>
      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
          data_linea = "{{$item->DOCUMENTO_ITEM}}"
          data_orden_compra = "{{$item->ID_DOCUMENTO}}"
          data_proveedor = "{{$item->RZ_PROVEEDOR}}"
          data_serie = "{{$item->SERIE}}"
          data_numero = "{{$item->NUMERO}}"
          data_total = "{{$item->TOTAL_VENTA_ORIG}}"
          class='dobleclickpcestiba seleccionar'
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
          <span><b>LOTE : {{$item->ID_DOCUMENTO}} </b> </span>
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>PROVEEDOR : </b>{{$item->RZ_PROVEEDOR}} </span>
          
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FOLIO : </b> {{$item->FOLIO}}</span>
          <span><b>H. OBSERVACION : </b> {{$item->TXT_OBSERVADO}}</span>
          <span><b>H. REPARABLE : </b> {{$item->TXT_REPARABLE}}</span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          <span><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
        </td>
        @include('comprobante.ajax.estadosfe')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
<!--             <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-comprobante-administracion-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                  Aprobar Comprobante
                </a>  
              </li>
            </ul> -->
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