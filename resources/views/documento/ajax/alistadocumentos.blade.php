<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>FACTURA</th>
      <th>PROVEEDOR</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>RUC : {{$item->RUC_PROVEEDOR}} </b> </span>
          <span><b>PROVEEDOR  : {{$item->RZ_PROVEEDOR}}</b></span>
        </td>
        @include('documento.ajax.estados')

        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-documentos-subidos/'.$idopcion.'/1CIX/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Detalle de Registro
                </a>
                @if(ltrim(rtrim($item->COD_ESTADO)) == 'ETM0000000000001') 
                    <a href="{{ url('/detalle-documentos/'.$procedencia.'/'.$idopcion.'/1CIX/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                      Completar Registro XML
                    </a>
                @endif
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