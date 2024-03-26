<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CODIGO REQ.</th>
      <th>USUARIO CREA</th>
      <th>TELEFONO</th>
      <th>CORREO ELECTRONICO</th>
      <th>FECHA CREA</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->id}}">
        <td>{{$item->codigo}}</td>
        <td>{{$item->nombre_director}} {{$item->apellidopaterno_director}} {{$item->apellidomaterno_director}}</td>
        <td>{{$item->telefono_director}}</td>
        <td>{{$item->correo_director}}</td>
        <td>{{$item->fecha_crea}}</td>
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