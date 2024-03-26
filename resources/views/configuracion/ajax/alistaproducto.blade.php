<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
  <thead>
    <tr>
      <th>Id</th>
      <th>Codigo</th>
      <th>Categoria</th>
      <th>Descripcion</th>
      <th>Peso</th>
      <th>Unidad Medida</th>      
      <th>Estado</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listaproducto as $index => $item)
      <tr data_producto_id = "{{$item->id}}" class='activo{{$item->activo}}'>
        <td>{{$index + 1 }}</td>
        <td>{{$item->codigo}}</td>
        <td>{{$item->categoria_nombre}}</td>
        <td>{{$item->descripcion}}</td>
        <td>{{$item->peso}}</td>
        <td>{{$item->unidad_medida_nombre}}</td>        
        <td>
          @if($item->activo == 1)
            Activo
          @else
            Inactivo
          @endif
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">

              <li>
                <a href="{{ url('/modificar-productos/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
                  Modificar
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