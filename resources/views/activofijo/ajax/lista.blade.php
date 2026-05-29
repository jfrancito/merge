<table id="tabla-obras" class="table table-striped table-hover table-fw-widget">
  <thead>
    <tr>
      <th class="no-export">Opciones</th>
      <th>Item PLE</th>
      <th>Nombre</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lista as $item)
      <tr>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="#" class="btn-editar-activo" 
                   data-id="{{$item->id}}" 
                   data-item_ple="{{$item->item_ple}}" 
                   data-nombre="{{$item->nombre}}" 
                   data-cantidad="{{$item->cantidad}}" 
                   data-estado="{{$item->estado}}" 
                   data-tipo="{{ $item->tipo_activo }}"
                   data-marca="{{ $item->marca }}"
                   data-modelo="{{ $item->modelo }}"
                   data-numero_serie="{{ $item->numero_serie }}"
                   data-factura="{{ $item->factura }}"
                   data-fecha_emision="{{ $item->fecha_emision }}"
                   data-base_de_calculo="{{ $item->base_de_calculo }}"
                   data-depreciacion_acumulada="{{ $item->depreciacion_acumulada }}"
                   data-fecha_inicio_depreciacion="{{ $item->fecha_inicio_depreciacion }}"
                   data-ultima_fecha_depreciacion="{{ $item->ultima_fecha_depreciacion }}"
                   data-cod_centro="{{ $item->cod_centro }}">
                  Editar
                </a>
              </li>
              <li>
                <a href="#" class="btn-eliminar-activo" data-id="{{$item->id}}">
                  Eliminar
                </a>
              </li>
            </ul>
          </div>
        </td>
        <td>{{$item->item_ple}}</td>
        <td>{{$item->nombre}}</td>
        <td>{{$item->estado}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
