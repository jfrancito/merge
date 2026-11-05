<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>

      <th>CODIGO</th>
      <th>DOCUMENTO</th>
      
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>CUENTA OSIRIS</th>
      <th>PROVEEDOR</th>

      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      @php $NOMBRE_OSIRIS =  $funcion->funciones->cuenta_osiris_lca($item->COD_AUTORIZACION) @endphp
      <tr data_requerimiento_id = "{{$item->id}}">
        <td><b>LIQUIDACION DE COMPRA ANTICIPO</b></td>
        <td>{{$item->COD_AUTORIZACION}}</td>
        <td>{{$item->TXT_SERIE}} - {{$item->TXT_NUMERO}}</td>
        <td>{{$funcion->funciones->estorno_referencia($item->COD_AUTORIZACION)}}</td>
        <td>{{$item->FEC_AUTORIZACION}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPRESA}}</td>
        <td>{{$NOMBRE_OSIRIS}}</td>        
        <td>{{$item->CAN_TOTAL}}</td>
        <td>{{$item->COD_USUARIO_CREA_AUD}}</td>
        @include('comprobante.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                @if(ltrim(rtrim($item->COD_ESTADO)) == '') 
                    <a href="{{ url('/detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($item->COD_AUTORIZACION, -10))) }}">
                      Registro XML
                    </a>
                @else
                  @if(is_null($item->COD_ESTADO)) 
                      <a href="{{ url('/detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($item->COD_AUTORIZACION, -10))) }}">
                        Registro XML
                      </a>
                  @else
                    @if($item->COD_ESTADO != 'ETM0000000000001')
                      @if($item->COD_ESTADO != 'ETM0000000000006')
                        <!-- <a href="{{ url('/detalle-comprobante-liquidacion-compra-anticipo-validado/'.$idopcion.'/'.substr($item->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($item->COD_AUTORIZACION, -10))) }}">
                          Detalle de Registro
                        </a> -->
                      @else
                        <a href="{{ url('/detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($item->COD_AUTORIZACION, -10))) }}">
                          Registro XML
                        </a>
                      @endif
                    @else
                        <a href="{{ url('/detalle-comprobante-liquidacion-compra-anticipo-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_AUTORIZACION, 0,6).'/'.Hashids::encode(substr($item->COD_AUTORIZACION, -10))) }}">
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