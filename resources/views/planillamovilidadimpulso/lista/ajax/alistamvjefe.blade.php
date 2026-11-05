<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>SEMANA</th>
      <th>AREA</th>
      <th>CENTRO</th>
      <th>FECHA CREACION </th>
      <th>TRABAJADOR</th>
      <th>MONTO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index+1}}</td>
        <td>{{$item->FECHA_INICIO}} / {{$item->FECHA_FIN}}</td>
        <td>{{$item->AREA_TXT}}</td>
        <td>{{$item->CENTRO_TXT}}</td>
        <td>{{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</td>
        <td>{{$item->TXT_EMPRESA_TRABAJADOR}}</td>
        <td>{{$item->MONTO}}</td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-movilidad-impulso-jefe/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Revisar Movilidad
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>