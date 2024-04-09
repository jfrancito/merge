<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CODIGO ORDEN</th>
      <th>FECHA ORDEN</th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->id}}">
        <td>{{$item->COD_ORDEN}}</td>
        <td>{{$item->FEC_ORDEN}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
        <td>{{$item->CAN_TOTAL}}</td>
        <td>
          @if($item->COD_ESTADO == 'ETM0000000000001') 
              <span class="badge badge-default">{{$item->TXT_ESTADO}}</span> 
          @else
            @if(is_null($item->COD_ESTADO)) 
                <span class="badge badge-default">GENERADO</span>
            @else
              @if($item->COD_ESTADO == 'ETM0000000000002') 
                  <span class="badge badge-success">{{$item->TXT_ESTADO}}</span>
              @else
                  <span class="badge badge-danger">{{$item->TXT_ESTADO}}</span>
              @endif
            @endif
          @endif
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                    Detalle de Registro
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