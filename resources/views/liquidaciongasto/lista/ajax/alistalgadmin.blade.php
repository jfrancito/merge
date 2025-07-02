<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>CODIGO</th>
      <th>CUENTA</th>

      <th>FECHA EMISION</th>
      <th>FECHA CREACION</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th>TRABAJADOR</th>
      <th>CENTRO</th>
      <th>AUTORIZA</th>
      <th>MONEDA</th>

      <th>REVISION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index+1}}</td>
        <td>{{$item->CODIGO}}</td>
        <td>{{$item->TXT_CUENTA}}</td>
        
        <td>{{date_format(date_create($item->FECHA_EMI), 'd/m/Y')}}</td>
        <td>{{date_format(date_create($item->FECHA_CREA), 'd/m/Y')}}</td>
        <td>{{$item->TXT_PERIODO}}</td>
        <td>{{$item->TOTAL}}</td>
        <td>{{$item->TXT_EMPRESA_TRABAJADOR}}</td>
        <td>{{$item->TXT_CENTRO}}</td>
        <td>{{$item->TXT_USUARIO_AUTORIZA}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-liquidacion-gasto-administracion/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Revisar Liquidacion
                </a>  
              </li>

              <li>
                <a href="{{ url('/liquidacion-viaje-pdf/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}" Target="_blank">
                  Liquidacion de viaje PDF
                </a>  
              </li>

            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>