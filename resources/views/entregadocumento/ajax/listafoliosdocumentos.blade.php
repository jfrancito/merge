<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>FOLIO</th>
      <th>CANTIDAD DOCUMENTOS</th>

      <th>USUARIO CREA</th>
      <th>FECHA CREA</th>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->FOLIO}}"
        class='dobleclickpc seleccionar'
        >
        <td>{{$index + 1}}</td>
        <td>{{$item->FOLIO}}</td>
        <td>{{$item->CAN_FOLIO}}</td>
        <td>{{$item->nombre}}</td>
        <td>{{date_format(date_create($item->FECHA_CREA), 'd-m-Y h:i:s')}}</td>
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


@if(isset($mensaje))
  <script type="text/javascript">
    alertajax("{{$mensaje}}");
  </script> 
@endif