<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #cc0000;color: #fff;">ARCHIVOS OBSERVADOS
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
          @foreach($archivosanulados as $index => $item)  
            <tr>
              <td>{{$index + 1}}</td>
              <td>{{$item->DESCRIPCION_ARCHIVO}}</td>
              <td>{{$item->NOMBRE_ARCHIVO}}</td>

              <td class="rigth">
                <div class="btn-group btn-hspace">
                  <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                  <ul role="menu" class="dropdown-menu pull-right">
                    <li>
                      <a href="{{ url('/descargar-archivo-requerimiento-anulado/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}">
                        Descargar
                      </a>  
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>
</div>