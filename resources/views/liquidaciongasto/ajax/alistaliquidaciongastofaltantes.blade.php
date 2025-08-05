<table id="nso" class="table table-striped table-striped  nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CREA</th> 
      <th>SERIE</th> 
      <th>NUMERO</th> 
      <th>FECHA EMISION</th> 
      <th>PROVEEDOR</th> 
      <th>TOTAL</th> 
      <th>IND_PDF</th> 
      <th>IND_XML</th> 
      <th>IND_CDR</th> 
      <th>BUSQUEDAD</th> 
    </tr>
  </thead>
  <tbody>
    @foreach($listacabecera as $index=>$item)
      <tr>
        <td>{{$index + 1}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{$item->FECHA_EMI}}</td>
        <td>{{$item->SERIE}}</td>
        <td>{{$item->NUMERO}}</td>
        <td>{{$item->FECHA_EMISIONDOC}}</td>
        <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>
        <td>{{$item->TOTAL}}</td>
        <td>{{$item->IND_PDF}}</td>
        <td>{{$item->IND_XML}}</td>
        <td>{{$item->IND_CDR}}</td>
        <td>{{$item->BUSQUEDAD}}</td>
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
