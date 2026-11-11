<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>#</th>
      <th>CODIGO</th>
      <th>ENDTIDAD</th>
      <th>NRO CTA</th>
      <th>NRO CTA CCI</th>
      <th>MONEDA</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_precotizacion_id = "{{$item->id}}">
        <td >  
          {{$index+1}}
        </td>
        <td>{{$item->Entidad->codigo}}</td>

        <td>{{ $item->Entidad->entidad }}</td>
        <td>{{$item->nrocta}}</td>
        <td>
          {{$item->nroctacci}}
        </td>
        <td>
          {{$item->Moneda->descripcionabreviada}}
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/modificar-'.$url.'/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
                  Modificar
                </a>  
              </li>
              <li>
                <a href="{{ url('/eliminar-'.$url.'/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
                  Eliminar
                </a>  
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