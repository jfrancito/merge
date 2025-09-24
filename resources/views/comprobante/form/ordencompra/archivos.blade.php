
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
                <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
                  <td>{{$item->NOMBRE_ARCHIVO}}</td>

                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="{{ url('/descargar-archivo-requerimiento/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                            Descargar
                          </a>  
                        </li>

                        @if(Session::get('usuario')->id == '1CIX00000001' or Session::get('usuario')->rol_id == '1CIX00000016')
                          <li>
                            <a class="elimnaritem" href="{{ url('/eliminar-archivo-item/'.$item->TIPO_ARCHIVO.'/'.$item->NOMBRE_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                              Eliminar Item
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
