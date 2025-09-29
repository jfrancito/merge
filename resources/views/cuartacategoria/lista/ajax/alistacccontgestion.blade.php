<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CONSTANCIA</th>
      <th>FECHA CADUCIDAD</th>
      <th>RUC</th>
      <th>PROVEEDOR</th>
      <th>NUMERO OPERACION</th>
      <th>OBSERVACION</th>
      <th>ESTADO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lrentacuartacategoria as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index + 1}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{date_format(date_create($item->FECHA_CONSTANCIA), 'd-m-Y')}}</td>
        <td>{{date_format(date_create($item->FECHA_CADUCIDAD), 'd-m-Y')}}</td>   
        <td>{{$item->RUC}}</td>
        <td>{{$item->RAZON_SOCIAL}}</td>
        <td>{{$item->NUMERO_OPERACION}}</td>
        <td>{{$item->OBSERVACION}}</td>
        @include('cuartacategoria.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/gestion-renta-cuarta-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Gestion Renta Cuarta
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>