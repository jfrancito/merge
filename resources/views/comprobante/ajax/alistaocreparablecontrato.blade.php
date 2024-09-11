<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CONTRATO</th>
      <th>FACTURA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->id}}">
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : {{$item->COD_DOCUMENTO_CTBLE}} </b> </span>
          <span><b>FECHA  : {{$item->FEC_EMISION}}</b></span>
          <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}</span>
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

          <span><b>REPARABLE : </b>               
              @if($item->IND_REPARABLE == 1) 
                  <span class="badge badge-warning" style="display: inline-block;">EN PROCESO</span>
              @else
                @if($item->IND_REPARABLE == 0) 
                    <span class="badge badge-default" style="display: inline-block;">-</span>
                @else
                    <span class="badge badge-default" style="display: inline-block;">-</span>
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
                <a href="{{ url('/reparable-comprobante-uc-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">Reparable</a>  
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