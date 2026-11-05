
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Nro</th>
              <th>Nombre</th>      
              <th>Archivo</th>       
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
              @foreach($archivos as $index => $item)  
                @php $color_virtual =  $funcion->funciones->ver_virtual_color($item->ID_DOCUMENTO,$item->TIPO_ARCHIVO) @endphp
                <tr class="{{$color_virtual}}">
                  <td>{{$index + 1}}</td>
                  <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
                  <td>{{$item->NOMBRE_ARCHIVO}}</td>
                  @php 
                    $es_pdf = str_contains(strtolower($item->NOMBRE_ARCHIVO), 'pdf');
                  @endphp

                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="{{ url('/descargar-archivo-requerimiento/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                            Descargar
                          </a>  
                        </li>

                        @if($es_pdf)
                          @if(Session::get('usuario')->id == '1CIX00000001' or Session::get('usuario')->rol_id == '1CIX00000016' or Session::get('usuario')->rol_id == '1CIX00000015')
                            <li>
                              <a class="elimnaritem" href="{{ url('/eliminar-archivo-item/'.$item->TIPO_ARCHIVO.'/'.$item->NOMBRE_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                                Eliminar Item
                              </a>
                            </li>
                          @endif
                        @endif

                        @if($es_pdf)
                          <li>
                              <a href="#" class="modificar-pdf" 
                                 data-tipo="{{$item->TIPO_ARCHIVO}}" 
                                 data-nombre="{{$item->DESCRIPCION_ARCHIVO}}">
                                Modificar
                              </a>
                          </li>
                        @endif
                        
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
