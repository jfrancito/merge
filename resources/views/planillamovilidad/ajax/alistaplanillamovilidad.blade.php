<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>ADICIONAL</th>
      <th>IMPORTE</th>
      <th>DESCUENTO</th>
      <th>PERCEPCCION</th>
      <th>NETO A PAGAR</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "">
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
        <td>{{$index + 1}}</td>
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
