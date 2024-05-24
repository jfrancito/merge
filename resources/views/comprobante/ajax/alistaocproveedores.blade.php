<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CODIGO ORDEN</th>
      <th>FECHA ORDEN</th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>

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

        <td>{{$item->COD_USUARIO_CREA_AUD}}</td>

        @include('comprobante.ajax.estados')

        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>

                @if(ltrim(rtrim($item->COD_ESTADO)) == '') 
                    <a href="{{ url('/detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                      Registro XML
                    </a>
                @else

                  @if(is_null($item->COD_ESTADO)) 
                      <a href="{{ url('/detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                        Registro XML
                      </a>
                  @else
                    @if($item->COD_ESTADO != 'ETM0000000000001')
                      @if($item->COD_ESTADO != 'ETM0000000000006')
                        <a href="{{ url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                          Detalle de Registro
                        </a>
                      @else
                        <a href="{{ url('/detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                          Registro XML
                        </a>
                      @endif
                    @else
                        <a href="{{ url('/detalle-comprobante-oc-proveedor/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                          Registro XML
                        </a>
                    @endif
                  @endif
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