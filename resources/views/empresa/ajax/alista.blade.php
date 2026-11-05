<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>#</th>
      <th>RUC</th>
      <th>RAZON SOCIAL</th>
      <th>DIRECCION</th>
      <th>TELEFONO</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_precotizacion_id = "{{$item->id}}">
        <td >  
          {{$index+1}}
        </td>
        <td>{{$item->ruc}}</td>

        <td>{{ $item->descripcion }}</td>
        <td>{{$item->domiciliofiscal1}}</td>
        <td>
          {{ $item->telefono }}
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              {{-- <li>
                <a href="{{ url('/modificar-'.$url.'/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
                  Modificar
                </a>  
              </li> --}}
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