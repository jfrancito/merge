<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>FOLIO</th>
      <th>PERIODO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>CENTRO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index + 1}}</td>
        <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
        <td>{{$item->FOLIO}}</td>
        <td>{{$item->TXT_PERIODO}}</td>
        <td>{{$item->TXT_GLOSA}}</td>
        <td>{{$item->CAN_FOLIO}}</td>
        <td>{{$item->TXT_CENTRO}}</td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-planilla-movilidad-contabilidad/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Revisar Planilla Movilidad
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>