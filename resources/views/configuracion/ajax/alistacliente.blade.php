<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7">
  <thead>
    <tr>
      <th>Id</th>
      <th>Tipo Documento</th>
      <th>Numero Documento</th>
      <th>Nombre / Razón Social</th>
      <th>Direccion</th>
      <th>Correo</th>
      <th>Celular</th>
      <th>Estado</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listacliente as $index => $item)
      <tr data_cliente_id = "{{$item->id}}" class='activo{{$item->activo}}'>
        <td>{{$index + 1 }}</td>
        <td>{{$item->tipo_documento_nombre}}</td>
        <td>{{$item->numerodocumento}}</td>
        <td>{{$item->nombre_razonsocial}}</td>
        <td>{{$item->direccion}}</td>
        <td>{{$item->correo}}</td>
        <td>{{$item->celular}}</td>
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
                <a href="{{ url('/modificar-clientes/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}">
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