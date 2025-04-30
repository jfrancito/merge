<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>FECHA EMISION</th>
      <th>TIPO DOC</th>
      <th>SERIE</th>
      <th>NRO</th>
      <th>RUC PROVEEDOR</th>
      <th>RZ PROVEEDOR</th>
      <th>TOTAL</th>      
    </tr>
  </thead>
  <tbody>
      @foreach($listadatos as $index => $item)
          <tr>
            <td class=''>{{$index + 1}}</td>
            <td class=''>{{$item['fecEmision']}}</td>
            <td class=''>{{$item['codTipoCDP']}}</td>
            <td class=''>{{$item['numSerieCDP']}}</td>
            <td class=''>{{$item['numCDP']}}</td>
            <td class=''>{{$item['numDocIdentidadProveedor']}}</td>
            <td class=''>{{$item['nomRazonSocialProveedor']}}</td>
            <td class=''>{{$item['mtoTotalCp']}}</td>
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