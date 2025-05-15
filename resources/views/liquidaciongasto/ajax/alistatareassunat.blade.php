@if($mensaje!='')
<div role="alert" class="alert alert-danger alert-dismissible">
    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
      <span aria-hidden="true" class="mdi mdi-close"></span></button><span class="icon mdi mdi-close-circle-o"></span>
      <strong>Error!</strong> {{$mensaje}}
</div>
@endif

<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>DOCUMENTO</th>
      <th>ARCHIVOS</th>
      <th>OPCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listasunattareas as $index => $item)
      <tr>
          <td class="cell-detail">
            <span><b>RUC : </b>{{$item->RUC}}</span>
            <span><b>TD : </b>{{$item->TIPODOCUMENTO_NOMBRE}}</span>
            <span><b>SERIE : </b>{{$item->SERIE}}</span>
            <span><b>NUMERO : </b>{{$item->NUMERO}}</span>
          </td>
          <td class="cell-detail">
            <span><b>PDF : </b></span>
            <span><b>XML : </b></span>
            <span><b>CDR : </b></span>
            <span><b>TOTAL : </b></span>
          </td>
          <td class="cell-detail user-info">
          </td>
      </tr>                    
    @endforeach
  </tbody>
</table>
