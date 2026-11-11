<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CLIENTERR</th>
      <th>SUMARR</th>
      <th>TIPORR</th>
      <th>CLIENTE OTROS</th>
      <th>SUMA OTROS</th>
      <th>TIPO OTROS</th>
      <th>DIFERENCIA</th>
    </tr>
  </thead>
  <tbody>
    @foreach($diferencias as $index => $item)
        <tr data_cliente = "{{$item->CLIENTERR}}"
          class='dobleclickpc seleccionar'
          style="cursor: pointer;">
        <td>{{$item->CLIENTERR}}</td>
        <td>{{$item->SUMARR}}</td>
        <td>{{$item->TIPORR}}</td>
        <td>{{$item->CLIENTEO}}</td>
        <td>{{$item->SUMAO}}</td>
        <td>{{$item->TIPOO}}</td>
        <td>{{$item->diferencia}}</td>      

      </tr>                    
    @endforeach
  </tbody>
</table>


<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>CLIENTERR</th>
      <th>SUMARR</th>
      <th>TIPORR</th>
      <th>CLIENTE OTROS</th>
      <th>SUMA OTROS</th>
      <th>TIPO OTROS</th>

    </tr>
  </thead>
  <tbody>
    @foreach($solo_uno as $index => $item)
        <tr data_cliente = "{{$item->CLIENTERR}}"
          class='dobleclickpc seleccionar'
          style="cursor: pointer;">
        <td>{{$item->CLIENTERR}}</td>
        <td>{{$item->SUMARR}}</td>
        <td>{{$item->TIPORR}}</td>
        <td>{{$item->CLIENTEO}}</td>
        <td>{{$item->SUMAO}}</td>
        <td>{{$item->TIPOO}}</td>
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