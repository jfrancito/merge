<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID</th>
      <th>FECHA EMISION</th>
      <th>FECHA CREACION</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th>TRABAJADOR</th>
      <th>CENTRO</th>
      <th>MONEDA</th>
      <th>ESTADO</th>
      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index+1}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{date_format(date_create($item->FECHA_EMI), 'd/m/Y')}}</td>
        <td>{{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</td>
        <td>{{$item->TXT_PERIODO}}</td>
        <td>{{$item->TOTAL}}</td>
        <td>{{$item->TXT_EMPRESA_TRABAJADOR}}</td>
        <td>{{$item->TXT_CENTRO}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>@include('planillamovilidad.ajax.estados')</td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-liquidacion-gasto-jefe-historial/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Revisar Liquidacion
                </a>  
              </li>
            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>