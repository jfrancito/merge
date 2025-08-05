<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="width:100% !important">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>NRO PLANILLA</th>
      <th>FECHA EMISION PLANILLA</th>
      <th>TRABAJADOR</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th>NRO FOLIO</th>
      <th>ID LIQUIDACION</th>
      <th>ESTADO LIQUIDACION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr>
        <td>{{$index + 1}}</td>
        <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
        <td>{{$item->FECHA_EMI}}</td>
        <td>{{$item->TXT_TRABAJADOR}}</td>
        <td>{{$item->TXT_PERIODO}}</td>
        <td>{{$item->TOTAL}}</td>
        <td>{{$item->SERIEFOLIO}} - {{$item->NUMEROFOLIO}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{$item->TXT_ESTADO}}</td>
      </tr>                    
    @endforeach
  </tbody>
</table>