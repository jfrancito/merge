<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>ID DOCUMENTO</th>
      <th>RUC</th>
      <th>RAZON SOCIAL</th>
      <th>SERIE</th>
      <th>NUMERO</th>
      <th>MONEDA</th>
      <th>TOTAL VENTA</th>
      <th>ESTADO</th>
      <th>RESPONSABLE</th>
      <th>MODO REPARABLE</th>
      <th>MODO REPARABLE HIBRIDO</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr>
        <td>{{$index + 1}}</td>
        <td>{{$item->OPERACION}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{$item->RUC_PROVEEDOR}}</td>
        <td>{{$item->RZ_PROVEEDOR}}</td>
        <td>{{$item->SERIE}}</td>
        <td>{{$item->NUMERO}}</td>
        <td>{{$item->MONEDA}}</td>
        <td>{{number_format($item->TOTAL_VENTA_ORIG, 2, '.', ',')}}</td>
        <td>{{$item->TXT_ESTADO}}</td>
        <td>{{$item->NOMBRES}}</td>
        <td>{{$item->MODO_REPARABLE}}</td>
        <td>{{$item->MODO_REPARABLE_HIBRIDO}}</td>
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